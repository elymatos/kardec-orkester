<?php
$lang = $data->lang;

$s = [
    'todas' => ['pt' => 'Todas', 'fr' => 'Tout'],
    'todos' => ['pt' => 'Todos', 'fr' => 'Tout'],
    'pesquisar' => ['pt' => 'Pesquisar', 'fr' => 'Rechercher'],
    'pesquisar_por' => ['pt' => 'Pesquisar por', 'fr' => 'Rechercher par'],
    'colecao' => ['pt' => 'Coleção', 'fr' => 'Collection'],
    'ano' => ['pt' => 'Ano', 'fr' => 'An'],
    'categoria' => ['pt' => 'Categoria', 'fr' => 'Catégorie'],
];


?>

<div class="notebox">
    <form role="search" method="get" class="ui form" action="https://projetokardec.ufjf.br/searchtest">
        <div class="field">
            <label>{{$s['pesquisar_por'][$lang]}}:</label>
            <input type="search" class="search-field" placeholder="{{$s['pesquisar'][$lang]}} …" value="{{$data->q}}" name="q">
        </div>
        <div class="two fields">
            <div class="field">
                <label>{{$s['colecao'][$lang]}}</label>
                <select name="idColecao" class="ui fluid dropdown">
                    <option value="">-- {{$s['todas'][$lang]}}</option>
                    <?php
                    foreach($data->colecoes as $colecao) {
                        $value = ($colecao->id == $data->idColecao) ? 'selected' : '';
                        echo "<option {$value} value=\"{$colecao->id}\">{$colecao->name}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="field">
                <label>{{$s['ano'][$lang]}}</label>
                <select name="ano" class="ui fluid dropdown">
                    <option value="">-- {{$s['todos'][$lang]}}</option>
                    <?php
                    foreach($data->anos as $ano) {
                        $value = ($ano->ano == $data->ano) ? 'selected' : '';
                        echo "<option {$value} value=\"{$ano->ano}\">{$ano->ano}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="field">
                <label>{{$s['categoria'][$lang]}}</label>
                <select name="tag" class="ui fluid dropdown">
                    <option value="">-- {{$s['todas'][$lang]}}</option>
                    <?php
                    foreach($data->tags as $tag) {
                        $value = ($tag->id == $data->tag) ? 'selected' : '';
                        echo "<option {$value} value=\"{$tag->id}\">{$tag->name}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <input type="submit" class="search-submit" value="{{$s['pesquisar'][$lang]}}">
    </form>
</div>
