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

