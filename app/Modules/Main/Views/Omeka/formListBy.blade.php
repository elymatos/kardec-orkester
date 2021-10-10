<?php
$lang = $data->lang;
$q = $data->q;

if ($lang == 'fr') {
    $action = "https://projetokardec.ufjf.br/fr/manuscrits";
}
if ($lang == 'pt') {
    $action = "https://projetokardec.ufjf.br/fr/manuscritos";
}

$s = [
    'todas' => ['pt' => 'Todas', 'fr' => 'Tout'],
    'todos' => ['pt' => 'Todos', 'fr' => 'Tout'],
    'pesquisar' => ['pt' => 'Pesquisar', 'fr' => 'Rechercher'],
    'pesquisar_por' => ['pt' => 'Pesquisar por', 'fr' => 'Rechercher par'],
    'identificador' => ['pt' => 'Identificador (ex. 180A)', 'fr' => 'identifiant (ex. 180A)'],
    'colecao' => ['pt' => 'Coleção', 'fr' => 'Collection'],
    'ano' => ['pt' => 'Ano', 'fr' => 'An'],
    'categoria' => ['pt' => 'Categoria', 'fr' => 'Catégorie'],
];


?>

<div class="ui pointing menu">
    <a class="item  {{($data->q == 'datePub') ? 'active' : '' }}" href="https://projetokardec.ufjf.br/listar-por?q=datePub&lang={{$lang}}">
        Data de Publicação
    </a>
    <a class="item">
        Messages
    </a>
    <a class="item">
        Friends
    </a>
    <a class="item">
        Messages
    </a>
    <a class="item">
        Friends
    </a>
    <a class="item">
        Messages
    </a>
    <a class="item">
        Friends
    </a>
</div>
