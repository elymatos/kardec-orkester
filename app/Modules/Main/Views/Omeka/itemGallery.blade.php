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

//list($width1, $height1, $type, $attr) = getimagesize("http://omeka.projetokardec.ufjf.br/files/fullsize/0ab3c8c51b7260da9eb3d78f6cfe7228.jpg");
//list($width2, $height2, $type, $attr) = getimagesize("http://omeka.projetokardec.ufjf.br/files/fullsize/0b6a165e4756aac12ba203464c5fc608.jpg");

?>

<div id="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
         <img data-original="http://omeka.projetokardec.ufjf.br/files/fullsize/0ab3c8c51b7260da9eb3d78f6cfe7228.jpg" src="http://omeka.projetokardec.ufjf.br/files/thumbnails/0ab3c8c51b7260da9eb3d78f6cfe7228.jpg" itemprop="thumbnail" alt="Image description" style="width:150px;height:200px" />
        <figcaption itemprop="caption description">Image caption</figcaption>
    </figure>

    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <img data-original="http://omeka.projetokardec.ufjf.br/files/fullsize/0b6a165e4756aac12ba203464c5fc608.jpg" href="http://omeka.projetokardec.ufjf.br/files/fullsize/0b6a165e4756aac12ba203464c5fc608.jpg" src="http://omeka.projetokardec.ufjf.br/files/thumbnails/0b6a165e4756aac12ba203464c5fc608.jpg" itemprop="thumbnail" alt="Image description"   style="width:150px;height:200px"/>
        <figcaption itemprop="caption description">Image caption</figcaption>
    </figure>
</div>

<script>
    window.onload = function () {
        'use strict';

        var Viewer = window.Viewer;
        var console = window.console || {
            log: function () {
            }
        };
        var pictures = document.querySelector('#my-gallery');
        var options = {
            // inline: true,
            url: 'data-original',
            ready: function (e) {
                console.log(e.type);
            },
            show: function (e) {
                console.log(e.type);
            },
            shown: function (e) {
                console.log(e.type);
            },
            hide: function (e) {
                console.log(e.type);
            },
            hidden: function (e) {
                console.log(e.type);
            },
            view: function (e) {
                console.log(e.type);
            },
            viewed: function (e) {
                console.log(e.type);
            },
            move: function (e) {
                console.log(e.type);
            },
            moved: function (e) {
                console.log(e.type);
            },
            rotate: function (e) {
                console.log(e.type);
            },
            rotated: function (e) {
                console.log(e.type);
            },
            scale: function (e) {
                console.log(e.type);
            },
            scaled: function (e) {
                console.log(e.type);
            },
            zoom: function (e) {
                console.log(e.type);
            },
            zoomed: function (e) {
                console.log(e.type);
            },
            play: function (e) {
                console.log(e.type);
            },
            stop: function (e) {
                console.log(e.type);
            }
        };
        //options.container = "itemViewer";
        var viewer = new Viewer(pictures, options);
    }

</script>
