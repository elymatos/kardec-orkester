<?php
$lang = $data->lang;

$s = [
    'pagina' => ['pt' => 'Página', 'fr' => 'Page'],
    'anterior' => ['pt' => 'Anterior', 'fr' => 'Précédent'],
    'proxima' => ['pt' => 'Próxima', 'fr' => 'Prochain'],
];

if ($data->lang == 'pt') {
    $href = "https://projetokardec.ufjf.br/imagens?";
}
if ($data->lang == 'fr') {
    $href = "https://projetokardec.ufjf.br/fr/images?";
}
$query = [
    'idColecao' => $data->idColecao,
    'tag' => $data->tag,
    'ano' => $data->ano
];
$href .= http_build_query($query);

$count = count($data->images);
if ($count > 0) {
?>
<div id="imageGallery" class="ui cards">
    @foreach($data->images as $item)
        <div class="card">
            <div class="image"  style="width:310px;height:200px; overflow: hidden;">
                <img data-original="http://omeka-wp.projetokardec.ufjf.br/files/fullsize/{{$item->filename}}"
                     src="http://omeka-wp.projetokardec.ufjf.br/files/thumbnails/{{$item->filename}}"
                     itemprop="thumbnail"/>
            </div>
            <div class="content">
                <a class="header" href="#">{{$item->title}}</a>
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

<script>
    window.onload = function () {
        'use strict';

        var Viewer = window.Viewer;
        var console = window.console || {
            log: function () {
            }
        };
        var pictures = document.querySelector('#imageGallery');
        var options = {
            // inline: true,
            url: 'data-original',
        };
        var viewer = new Viewer(pictures, options);
    }

</script>

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

    .imageCard {
        max-height: 200px;
    }

</style>