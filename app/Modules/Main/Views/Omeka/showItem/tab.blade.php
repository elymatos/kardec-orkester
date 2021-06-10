<?php
$lang = $data->lang;

$s = [
    'traducao' => ['pt' => 'Tradução', 'fr' => 'Traduction'],
    'transcricao' => ['pt' => 'Transcrição', 'fr' => 'Transcription'],
    'manuscritos' => ['pt' => 'Manuscritos', 'fr' => 'Manuscrits'],
    'datas_proximas' => ['pt' => 'Manuscritos em datas próximas', 'fr' => 'Manuscrits en dates proches'],
    'sem_traducao' => ['pt' => 'Não há traduções para este item.', 'fr' => 'Il n\'y a pas de traductions pour cet article.'],
    'sem_transcricao' => ['pt' => 'Não há transcrições para este item.', 'fr' => 'Il n\'y a pas de transcriptions pour cet article.'],
];

if ($data->lang == 'pt') {
    $href = "https://projetokardec.ufjf.br/item-pt?";
}
if ($data->lang == 'fr') {
    $href = "https://projetokardec.ufjf.br/fr/item-fr?";
}

?>

<div class="dataArea">
    <div class="ui styled accordion" style="width:100%">
        <div class="title">
            <i class="dropdown icon"></i>
            <a class="active item" data-tab="first">{{$s['traducao'][$lang]}} <i class="br flag"></i></a>
        </div>
        <div class="content">
            <?php
            if ($data->item->traducao == '') {
            ?>
            <span>{{$s['sem_traducao'][$lang]}}</span>
            <?php
            } else {
            ?>
            {!! $data->item->traducao !!}
            <?php
            }
            ?>
        </div>
        <div class="title">
            <i class="dropdown icon"></i>
            <a class="item" data-tab="second">{{$s['manuscritos'][$lang]}} </a>
        </div>
        <div class="content">
            <div id="itemViewer" class="viewer">

                <?php
                foreach($data->item->files as $file) {
                mdump($file);
                $pattern = "/_([0-9][0-9][0-9])_/i";
                $matches = [];
                preg_match($pattern, $file['original'], $matches);
                $caption = $matches[1];
                ?>

                <figure class="ui left" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <img data-original="http://omeka-wp.projetokardec.ufjf.br/files/fullsize/{{$file['filename']}}"
                         src="http://omeka-wp.projetokardec.ufjf.br/files/thumbnails/{{$file['filename']}}"
                         itemprop="thumbnail" alt="Image description" style="width:120px;height:160px;margin-right:8px"/>
                    <figcaption class="figureCaption" itemprop="caption description">{{$caption}}</figcaption>
                </figure>
                <?php
                }
                ?>
                    <div class="clear"></div>
            </div>
        </div>
        <div class="title">
            <i class="dropdown icon"></i>
            <a class="item" data-tab="third">{{$s['transcricao'][$lang]}} &nbsp;<i class="france flag"></i></a>
        </div>
        <div class="content">
            <?php
            if ($data->item->transcricao == '') {
            ?>
            <span>{{$s['sem_transcricao'][$lang]}}</span>
            <?php
            } else {
            ?>
            {!! $data->item->transcricao !!}
            <?php
            }
            ?>
        </div>
        <div class="title">
            <i class="dropdown icon"></i>
            <a class="item" data-tab="fourth">{{$s['datas_proximas'][$lang]}} </a>
        </div>
        <div class="content">
            <table class="ui celled table">
                <tbody>
                @foreach ($around as $aroundItem)
                    @php
                        $itemCodeProx = $aroundItem->id . $code[$aroundItem->idCollection];
                    @endphp

                    <tr>
                        <td><a href="{{$href}}?id={{$aroundItem->id}}"><i class="file alternate icon"></i>{{$itemCodeProx}}</a></td>
                        <td><a href="{{$href}}?id={{$aroundItem->id}}">{{$aroundItem->date}}</a></td>
                        <td><a href="{{$href}}?id={{$aroundItem->id}}">{{$aroundItem->title}}</a></td>
                    </tr>

                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<style>
    .dataArea {
        border: 8px solid #eeeeee;
    }
    .figureCaption {
        text-align:center;
        font-size: 0.8em;
        margin: -8px 8px 8px 0;
    }

</style>