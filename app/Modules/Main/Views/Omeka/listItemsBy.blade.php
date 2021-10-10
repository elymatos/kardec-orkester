<?php
$lang = $data->lang;

if ($data->lang == 'pt') {
    $href = "https://projetokardec.ufjf.br/manuscritos?";
}
if ($data->lang == 'fr') {
    $href = "https://projetokardec.ufjf.br/manuscrits?";
}
$code = [1 => 'C', 2 => 'K', 3 => 'F'];

mdump($data->items);

$header = '';

$count = count($data->items);
if ($count > 0) {
?>

<div class="ui list">
    @foreach($data->items as $item)
        @php
        list($y, $m, $d) = explode('/', $item->date);
        $date = "{$d}/{$m}/{$y}";
        $itemCode = $item->id . $code[$item->idCollection];
        @endphp
        @if($header != $item->header)
        <h3 style="margin-top:8px">{{$item->header}} </h3>
            @php($header = $item->header)
        @endif

    <div class="item">
        <i class="file alternate outline icon"></i>
        <div class="content">
            <a class="header" href="https://projetokardec.ufjf.br/item-{{$lang}}?id={{$item->id}}">{{$date}} - {{$item->title}} [{{$itemCode}}]</a>
            <!--
            <div class="description"></div>
            -->
        </div>
    </div>
    @endforeach
</div>

<?php
}
?>

<style>
    .ui.card > .content > .header:not(.ui), .ui.cards > .card > .content > .header:not(.ui) {
        font-weight: 700;
        font-size: 1.05em;
        margin-top: -.21425em;
        line-height: 1.05em;
    }

    .ui.card > .content > .header:not(.ui), .ui.cards > .card > .content > .description {
        font-weight: 700;
        font-size: 1.05em;
        line-height: 1.05em;
    }

    .ui.card, .ui.cards > .card {
        width: 310px;
    }

    .paginationContainer {
        display: flex;
        justify-content: space-between;
        margin-top: 1.5em;
        height: 40px;
    }

    .navButton {
        background-color: #c2955f;
    }

    .labelPagina {
        width: 5em;
    }
</style>