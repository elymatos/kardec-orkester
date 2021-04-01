<?php
$lang = $data->lang;

$s = [
    'pagina' => ['pt' => 'Página', 'fr' => 'Page'],
    'anterior' => ['pt' => 'Anterior', 'fr' => 'Précédent'],
    'proxima' => ['pt' => 'Próxima', 'fr' => 'Prochain'],
];

if ($data->lang == 'pt') {
    $href = "https://projetokardec.ufjf.br/searchtest?";
}
if ($data->lang == 'fr') {
    $href = "https://projetokardec.ufjf.br/searchtestfr?";
}
$query = [
    'idColecao' => $data->idColecao,
    'tag' => $data->tag,
    'ano' => $data->ano
];
$href .= http_build_query($query);

$count = count($data->items);
if ($count > 0) {
?>
<div class="ui cards">
    @foreach($data->items as $item)
        <div class="card">
            <div class="content">
                <a class="header" href="#">{{$item->title}}</a>
                <div class="meta">{{$item->date}}</div>
            </div>
        </div>
    @endforeach
</div>
<?php
$current = $data->page;
$previous = $current - 1;
?>
<div class="paginationContainer">
    <div class="ui buttons">
        <?php
        if ($previous > 0) {
            $hrefpg = $href . "&pg={$previous}";
        ?>
        <button class="compact ui icon button">
            <a href="{{$hrefpg}}">
            <i class="left chevron icon"></i>
            </a>
        </button>
        <?php
        }
        ?>
    </div>
    <div class="ui buttons">
        <button class="compact ui button">
            <?php
            $hrefpg = $href . "&pg={$current}";
            ?>
            <a href="{{$hrefpg}}">
            {{$s['pagina'][$lang]}} {{$current}}
            </a>
        </button>
    </div>
    <div class="ui buttons">
        <?php
        if ($count >= $data->limit) {
        $next = $current + 1;
        $hrefpg = $href . "&pg={$next}";
        ?>
        <button class="compact ui right icon button">
            <a href="{{$hrefpg}}">
            <i class="right chevron icon"></i>
            </a>
        </button>
        <?php
        }
        ?>
    </div>
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