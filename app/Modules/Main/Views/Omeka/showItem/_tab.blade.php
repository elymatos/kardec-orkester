<div class="dataArea">
    <div class="ui top attached secondary menu">
        <div class="ui stackable grid" style="width:100%">
            <div class="four wide column">
                <a class="active item" data-tab="first">Tradução&nbsp;<i class="br flag"></i></a>
            </div>
            <div class="four wide column">
                <a class="item" data-tab="second">Manuscrito</a>
            </div>
            <div class="four wide column">
                <a class="item" data-tab="third">Transcrição&nbsp;<i class="france flag"></i></a>
            </div>
            <div class="four wide column">
                <a class="item" data-tab="fourth">Datas próximas</a>
            </div>
        </div>
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

<style>
    .cc_logo {
        width: 96px;
        height: 32px
    }

    .dataArea {
        min-height: 670px;
        border: 5px solid #eeeeee;
    }

</style>