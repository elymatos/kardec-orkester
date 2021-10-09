<?php

namespace App\Repositories\ORM;

use Orkester\MVC\MRepositoryORM;

class OmekaRepository extends MRepositoryORM
{
    private array $locale;

    public function __construct()
    {
        parent::__construct('kardec');
        $this->locale = [
            'fr' => 'fr',
            'pt' => 'pt_BR'
        ];
    }

    public function fullTextSearch(string $search = '')
    {
        $command = "
SELECT s1.record_id id
FROM omeka_search_texts s1
where (s1.record_type = 'Item')
AND MATCH (s1.text) AGAINST ('{$search}')
UNION
SELECT f.item_id id
FROM omeka_search_texts s2
JOIN omeka_files f on (f.id = s2.record_id)
where (s2.record_type = 'File')
AND MATCH (s2.text) AGAINST ('{$search}')        ";
        return $this->executeQuery($command);
    }

    public function fullTextSearchLike(string $search = '')
    {
        if (trim($search) == '') {
            return [];
        }
        $firstWords = explode(' ', $search);
        $words = [];
        foreach ($firstWords as $i => $word) {
            $t = trim($word);
            if ($t != '') {
                $words[] = $t;
            }
        }
        $where1 = $where2 = '';
        foreach($words as $word) {
            $where1 .= (($where1 == '') ? '' : ' AND ') . " (s1.text like '%{$word}%') ";
            $where2 .= (($where2 == '') ? '' : ' AND ') . " (s2.text like '%{$word}%') ";
        }
        $command = "
SELECT s1.record_id id
FROM omeka_search_texts s1
where (s1.record_type = 'Item')
AND ( {$where1})
UNION
SELECT f.item_id id
FROM omeka_search_texts s2
JOIN omeka_files f on (f.id = s2.record_id)
where (s2.record_type = 'File')
AND ( {$where2})";
        return $this->executeQuery($command);
    }

    public function listTags(string $lang = 'pt')
    {
        $locale = $this->locale[$lang];
        $field = 'name';
        if ($locale == 'fr') {
            $field = 'name_fr';
        }
        $command = "
select id, {$field} name
from omeka_tags
order by name
        ";
        return $this->executeQuery($command);
    }

    public function listColecoes(string $lang = 'pt')
    {
        $locale = $this->locale[$lang];
        $command = "
SELECT record_id id, translation name
FROM omeka_multilanguage_translations
WHERE (record_type='Collection')
AND (locale_code = '{$locale}')
order by translation;
        ";
        return $this->executeQuery($command);
    }

    public function getColecao($idColecao, string $lang = 'pt')
    {
        $locale = $this->locale[$lang];
        $command = "
SELECT record_id id, translation name
FROM omeka_multilanguage_translations
WHERE (record_type='Collection')
AND (locale_code = '{$locale}')
AND (record_id = {$idColecao})
order by translation;
        ";
        $result = $this->executeQuery($command);
        return $result[0]['name'];
    }

    public function listAnos()
    {
        $command = "
SELECT distinct substr(text,1,4) ano
FROM omeka_element_texts
where element_id = 40
order by 1
";
        return $this->executeQuery($command);
    }

    public function listItems(object $data)
    {
        $locale = $this->locale[$data->lang];
        $idItem = '';
        if ($data->idItem != '') {
            //$id = substr($data->idItem, 0, -1);
            //$idItem = " and (it.id = {$id}) ";
            $idItem = " and (it.id like '{$data->idItem}%') ";
        }
        $idColecao = ($data->idColecao != '') ? " and (it.collection_id = {$data->idColecao}) " : '';
        $ano = ($data->ano != '') ? " and (substr(e2.text,1,4) = '{$data->ano}')" : '';
        $tag = ($data->tag != '') ? " and (it.id in (select record_id from omeka_records_tags where (record_type = 'Item') and (tag_id = {$data->tag}) ))" : '';
        $limit = $data->limit;
        $offset = ($data->page - 1) * $limit;
        if ($data->q == '') {
            $range = "LIMIT {$limit} offset {$offset}";
        } else {
            $range = '';
        }
        $command = "
select * from (
SELECT it.id, t.translation title, e2.text date, e3.text identifier,it.collection_id idCollection
FROM omeka_multilanguage_translations t
JOIN omeka_element_texts e2 on (t.record_id = e2.record_id)
JOIN omeka_element_texts e3 on (t.record_id = e3.record_id)
JOIN omeka_items it on (t.record_id = it.id)
where (t.element_id = 50)
and (it.item_type_id IN (20, 21))
and (e2.element_id = 40)
and (e3.element_id = 43)
and (t.record_type = 'Item')
and (t.locale_code = '{$locale}')
{$idItem}
{$idColecao}
{$ano}
{$tag}
order by 3
) page
{$range}
";
        mdump($command);
        return $this->executeQuery($command);
    }

    public function listItemsByPublication(object $data)
    {
        $locale = $this->locale[$data->lang];
        $command = "
SELECT it.id, t.translation title, e2.text date, e3.text identifier,it.collection_id idCollection, e4.text pubDate, concat(substr(e4.text,7,4),'/',substr(e4.text,4,2),'/',substr(e4.text,1,2)) datapubinv
FROM omeka_multilanguage_translations t
JOIN omeka_element_texts e2 on (t.record_id = e2.record_id)
JOIN omeka_element_texts e3 on (t.record_id = e3.record_id)
JOIN omeka_element_texts e4 on (t.record_id = e4.record_id)
JOIN omeka_items it on (t.record_id = it.id)
where (t.element_id = 50)
and (it.item_type_id IN (20, 21))
and (e2.element_id = 40)
and (e3.element_id = 43)
and (e4.element_id = 74)
and (t.record_type = 'Item')
and (t.locale_code = '{$locale}')
order by 7 desc,3 desc,2
";
        mdump($command);
        return $this->executeQuery($command);
    }

    public function listImages(object $data)
    {
        $locale = $this->locale[$data->lang];
        $idColecao = ($data->idColecao != '') ? " and (it.collection_id = {$data->idColecao}) " : '';
        $ano = ($data->ano != '') ? " and (substr(e2.text,1,4) = '{$data->ano}')" : '';
        $tag = ($data->tag != '') ? " and (it.id in (select record_id from omeka_records_tags where (record_type = 'Item') and (tag_id = {$data->tag}) ))" : '';
        $limit = $data->limit;
        $offset = ($data->page - 1) * $limit;
        $command = "
select * from (
 SELECT it.id, t.translation title, f.filename
 FROM omeka_multilanguage_translations t
 JOIN omeka_items it on (t.record_id = it.id)
 JOIN omeka_files f on (t.record_id = f.item_id)
 where (t.element_id = 50)
 and (it.item_type_id = 6)
 and (t.record_type = 'Item')
and (t.locale_code = '{$locale}')
{$idColecao}
{$ano}
{$tag}
order by 2
) page
LIMIT {$limit} offset {$offset}
";
        mdump($command);
        return $this->executeQuery($command);
    }

    public function listFiles(int $idItem)
    {
        $command = "
        SELECT f.filename, f.original_filename original
FROM omeka_files f
WHERE (f.item_id = {$idItem})
AND (f.mime_type = 'image/jpeg')
ORDER BY f.id
        ";
        return $this->executeQuery($command);

    }

    public function listItemTags(int $idItem, string $lang = 'pt')
    {
        $locale = $this->locale[$lang];
        $field = 't.name';
        if ($locale == 'fr') {
            $field = 't.name_fr';
        }
        $command = "
select t.id, {$field} name
from omeka_tags t 
join omeka_records_tags r on (r.tag_id = t.id)
where (record_id = {$idItem})
order by name
        ";
        return $this->executeQuery($command);
    }

}
