<?php
$lang = $data->lang;

$licenca = [
    'pt' => "Item disponível sob a licença \"CC BY-NC-ND 4.0\".
                        Você pode compartilhar este item, bastando mencionar os titulares dos direitos autorais e inserir a URL do item no acervo digital do 'Projeto Allan Kardec'.
                        É proibida a distribuição, publicação e comercialização deste item, em qualquer outro veículo, impresso ou digital, sem a prévia e expressa autorização dos responsáveis.
                        Para ler a licença completa, clique <a href=\"https://creativecommons.org/licenses/by-nc-nd/4.0/deed.pt_BR\">aqui</a>.",
    'fr' => "Article disponible sous licence \"CC BY-NC-ND 4.0\".
                         Vous pouvez partager cet élément en mentionnant simplement les titulaires des droits d'auteur et en insérant l'URL de l'élément dans la collection numérique du 'Projeto Allan Kardec'.
                         La distribution, la publication et la commercialisation de cet article, dans tout autre véhicule, imprimé ou numérique, est interdite sans l'autorisation préalable et expresse des responsables.
                         Pour lire la licence complète, cliquez <a href=\"https://creativecommons.org/licenses/by-nc-nd/4.0/deed.fr\">ici</a>.",
];

$s = [
    'detalhes' => ['pt' => 'Detalhes', 'fr' => 'Détails'],
    'titulo' => ['pt' => 'Título', 'fr' => 'Titre'],
    'data' => ['pt' => 'Data', 'fr' => 'Date'],
    'colecao' => ['pt' => 'Acervo', 'fr' => 'Collection'],
    'producao' => ['pt' => 'Produção', 'fr' => 'Production'],
    'transcricao' => ['pt' => 'Transcrição', 'fr' => 'Transcription'],
    'traducao' => ['pt' => 'Tradução', 'fr' => 'Traduction'],
    'indexacao' => ['pt' => 'Digitalização/Indexação', 'fr' => 'Balayage/indexage'],
    'publicado_em' => ['pt' => 'Publicado em', 'fr' => 'Publié dans'],
    'citar_como' => ['pt' => 'Citar como', 'fr' => 'Citer comment'],
    'download' => ['pt' => 'Download', 'fr' => 'Telecharger des fichiers'],
    'licenca' => ['pt' => $licenca['pt'], 'fr' => $licenca['fr']],
];
?>

<aside class="sidebarItem" style="width:100%">
    <div class="sbshow">
        <div class="ui card">
            <div class="content">
                <div class="header">{{$s['detalhes'][$lang]}} </div>
            </div>
            <div class="content">
                <div class="ui small feed">
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['titulo'][$lang]}} : </span>{{$dublinCore["Title"][0]}}
                        </div>
                    </div>
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['data'][$lang]}} : </span>{{$date}}
                        </div>
                    </div>
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['colecao'][$lang]}} : </span>{{$data->item->collection}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui card">
            <div class="content">
                <div class="header">{{$s['producao'][$lang]}} </div>
            </div>
            <div class="content">
                <div class="ui small feed">
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['transcricao'][$lang]}} : </span>{{$manuscripts["Transcribed by"][0]}}
                        </div>
                    </div>
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['traducao'][$lang]}} : </span>{{$manuscripts["Translated by"][0]}}
                        </div>
                    </div>
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['indexacao'][$lang]}} : </span>{{$manuscripts["Digitalized by"][0]}}
                        </div>
                    </div>
                    <div class="event">
                        <div class="content">
                            <span class="sblabel">{{$s['publicado_em'][$lang]}} : </span>{{$manuscripts["Published on"][0]}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui card">
            <div class="content">
                <div class="header">{{$s['citar_como'][$lang]}} </div>
            </div>
            <div class="content">
                <div class="ui small feed">
                    <div class="event">
                        <div class="content">

                            <div><strong>ABNT: </strong></div>
                            <div id="citacao_abnt">
                                <?php
                                echo str_replace(",", ", ", $data->item->cite_abnt);
                                ?>
                            </div>
                            <br>
                            <div><strong>Vancouver: </strong></div>
                            <div id="citacao_vancouver">
                                <?php
                                echo str_replace(",", ", ", $data->item->cite_vancouver);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui card">
            <div class="content">
                <div class="header">{{$s['download'][$lang]}} </div>
            </div>
            <div class="content">
                <div class="ui small feed">
                    <div class="description">
                        <img height="32" class="cc_logo" src="https://omeka-wp.projetokardec.ufjf.br/themes/kardec-theme-3/css/images/by-nc-nd.png" style="vertical-align:middle;">
                        {!! $s['licenca'][$lang] !!}
                    </div>
                    <div class="event">
                        <div class="content">
                            <?php
                            $id = $data->item->id;
                            $fileName = "projetokardec_item_" . $itemCode;
                            $pdfPath = "https://omeka-wp.projetokardec.ufjf.br/items/pdf/{$id}";
                            ?>
                            <div><i class="file pdf icon"></i><a href="{!! $pdfPath !!}" target="_blank">{{$fileName}}</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</aside>

<style>
    .sidebarItem {
        height: 100%;
        background-color: #eee;
    }
    .sidebarItem .sbshow {
        padding: 8px;
    }
    .sidebarItem .sbshow .ui.card {
        border-radius: 0;
        width: 100%;
    }

    .sidebarItem .sbshow .ui.card .header {
        font-size: 1em;
    }

    .sidebarItem .sbshow .ui.card .content {
        font-size: 1.125em;
    }

    .sidebarItem .sbshow .ui.card .content .sblabel{
        font-weight: bold;
    }

    .cc_logo {
        width: 96px;
        height: 32px
    }

</style>
