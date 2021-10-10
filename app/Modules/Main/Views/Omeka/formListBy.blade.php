<?php
$lang = $data->lang;
$q = $data->q;

if ($lang == 'fr') {
    $action = "https://projetokardec.ufjf.br/fr/manuscrits";
}
if ($lang == 'pt') {
    $action = "https://projetokardec.ufjf.br/fr/manuscritos";
}

?>


<div class="ui list">
    <h3 style="margin-top:8px">Data de publicação</h3>
    @foreach($data->items['pubDateInv'] as $i => $value)
        @php
            list($y, $m, $d) = explode('/', $i);
            $date = "{$d}/{$m}/{$y}";
        @endphp
        <div class="item">
            <i class="file alternate outline icon"></i>
            <div class="content">
                <a class="header" href="https://projetokardec.ufjf.br/listar-por?q=pubDate&value={{$i}}">{{$date}} ({{$value}})</a>
            </div>
        </div>
    @endforeach
</div>
<div class="ui list">
    <h3 style="margin-top:8px">Ano</h3>
    @foreach($data->items['year'] as $i => $value)
        <div class="item">
            <i class="file alternate outline icon"></i>
            <div class="content">
                <a class="header" href="https://projetokardec.ufjf.br/listar-por?q=year&value={{$i}}">{{$i}} ({{$value}})</a>
            </div>
        </div>
    @endforeach
</div>
<div class="ui list">
    <h3 style="margin-top:8px">Categoria</h3>
    @foreach($data->items['tag'] as $i => $value)
        <div class="item">
            <i class="file alternate outline icon"></i>
            <div class="content">
                <a class="header" href="https://projetokardec.ufjf.br/listar-por?q=year&value={{$i}}">{{$i}} ({{$value}})</a>
            </div>
        </div>
    @endforeach
</div>
<div class="ui list">
    <h3 style="margin-top:8px">Coleção</h3>
    @foreach($data->items['collection'] as $i => $value)
        <div class="item">
            <i class="file alternate outline icon"></i>
            <div class="content">
                <a class="header" href="https://projetokardec.ufjf.br/listar-por?q=year&value={{$i}}">{{$i}} ({{$value}})</a>
            </div>
        </div>
    @endforeach
</div>