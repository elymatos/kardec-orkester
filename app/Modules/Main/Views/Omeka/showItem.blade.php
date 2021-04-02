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

mdump($data->item);
$elements = (array)$data->item->elements;
$dublinCore = (array)$elements['Dublin Core'];
$manuscripts = (array)$elements['Manuscripts Item Type Metadata'];
list($y, $m, $d) = explode('/', $dublinCore["Date"][0]);
$date = "{$d}/{$m}/{$y}";

?>
<div class="">
    <div class="idItem">
        <div class="ui label right">
            <i class="file alternate icon"></i>{{$data->item->id}}
        </div>
    </div>
    @foreach($data->item->tags as $tag)
        <a class="ui tag label right">{{$tag['name']}}</a>
    @endforeach

    <h2>{{$data->item->title}} - {{$date}}</h2>
    <div class="description">{{$data->item->description}}</div>
    <div class="dataArea">
        <div class="ui top attached secondary menu">
            <a class="active item" data-tab="first">Tradução&nbsp;<i class="br flag"></i></a>
            <a class="item" data-tab="second">Manuscrito</a>
            <a class="item" data-tab="third">Transcrição&nbsp;<i class="france flag"></i></a>
            <a class="item" data-tab="fourth">Datas próximas</a>
        </div>
        <div class="ui bottom attached tab segment showFile active" data-tab="first">
            <?php
            if ($data->item->traducao == '') {
            ?>
            <span>Não há traduções para este item.</span>
            <?php
            } else {
            ?>
            {!! $data->item->traducao !!}
            <?php
            }
            ?>
        </div>
        <div class="ui bottom attached tab segment showFile" data-tab="second">
            <div id="itemViewer" class="viewer">
                <?php
                foreach($data->item->files as $file) {
                mdump($file);
                ?>

                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <img data-original="http://omeka.projetokardec.ufjf.br/files/fullsize/0ab3c8c51b7260da9eb3d78f6cfe7228.jpg"
                         src="http://omeka.projetokardec.ufjf.br/files/thumbnails/0ab3c8c51b7260da9eb3d78f6cfe7228.jpg"
                         itemprop="thumbnail" alt="Image description" style="width:150px;height:200px"/>
                    <figcaption itemprop="caption description">Image caption</figcaption>
                </figure>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="ui bottom attached tab segment showFile" data-tab="third">
            <?php
            if ($data->item->transcricao == '') {
            ?>
            <span>Não há transcrições.</span>
            <?php
            } else {
            ?>
            {!! $data->item->transcricao !!}
            <?php
            }
            ?>
        </div>
        <div class="ui bottom attached tab segment showFile" data-tab="fourth">
            <table class="ui celled table">
                <tbody>
                <?php
                foreach ($data->item->around as $aroundItem) {
                    //echo "<tr><td><a href='/items/show/{$aroundItem['id']}'>{$aroundItem['title']}</a></td></td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <a href="http://projetokardec.ufjf.br/termosuso">
            <img height="32" class="cc_logo"
                 src="https://omeka-wp.projetokardec.ufjf.br/themes/kardec-theme-3/css/images/by-nc-nd.png"
                 style="vertical-align:middle;">
        </a>
        <span>A visualização desta página implica no conhecimento e aceitação de nossos <a
                    href="http://projetokardec.ufjf.br/termosuso">Termos de Uso</span></a>.
    </div>

    <aside id="sidebar">
        <div class="sbshow">
            <div class="ui card">
                <div class="content">
                    <div class="header">Detalhes</div>
                </div>
                <div class="content">
                    <div class="ui small feed">
                        <div class="event">
                            <div class="content">
                                <b><?php echo "Título"; ?>
                                    :</b> <?php echo $dublinCore["Title"][0]; ?>
                            </div>
                        </div>
                        <div class="event">
                            <div class="content">
                                <b><?php echo "Descrição" ?>
                                    :</b> <?php echo $dublinCore["Description"][0]; ?>
                            </div>
                        </div>
                        <div class="event">
                            <div class="content">
                                <b><?php echo "Data"; ?>:</b> <?php echo $date; ?>
                            </div>
                        </div>
                        <div class="event">
                            <div class="content">
                                <b><?php echo "Coleção"; ?>:</b> <?php echo $data->item->collection; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

</div>



<script>
    window.onload = function () {
        'use strict';

        var Viewer = window.Viewer;
        var console = window.console || {
            log: function () {
            }
        };
        var pictures = document.querySelector('#itemViewer');
        var options = {
            // inline: true,
            url: 'data-original',
        };
        var viewer = new Viewer(pictures, options);

        jQuery('.menu .item')
            .tab()
        ;

        function copyCite(model) {
            var $temp = jQuery("<input>");
            jQuery("body").append($temp);
            var copyText = jQuery('#citacao_' + model).html().replace("<i>", "").replace("</i>", "").trim();
            console.log(jQuery('#citacao_' + model));
            console.log(copyText);
            $temp.val(copyText).select();
            document.execCommand("copy");
            $temp.remove();
            alert("Texto copiado: " + copyText);
        }

    }

</script>

<style>

    .underline {
        text-decoration: underline;
    }

    .thumbnail {
        width: 150px;
        height: 200px
    }

    .cc_logo {
        width: 96px;
        height: 32px
    }

    .dataArea {
        min-height: 670px;
        border: 5px solid #eeeeee;
    }

    .description {
        color: #444;
    }

</style>