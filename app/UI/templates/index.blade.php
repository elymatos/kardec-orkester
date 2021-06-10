<?php
use Orkester\Manager;
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>{{Manager::getOptions('pageTitle')}}</title>
    <meta name="description" content="Framenet Brasil Webtool 4.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Carrega o icone da aplicação -->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Carrega o jQuery - obrigatório em todos os temas -->
    <script type='text/javascript' id="nb-jquery" src='https://projetokardec.ufjf.br/wp-includes/js/jquery/jquery.min.js?ver=3.5.1' id='jquery-core-js'></script>

<!--
    <link rel='stylesheet' id='formidable-css'  href='https://projetokardec.ufjf.br/wp-content/plugins/formidable/css/formidableforms.css?ver=1311509' type='text/css' media='all' />
    <link rel='stylesheet' id='frm_fonts-css'  href='https://projetokardec.ufjf.br/wp-content/plugins/formidable/css/frm_fonts.css?ver=4.09.05' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-block-library-css'  href='https://projetokardec.ufjf.br/wp-includes/css/dist/block-library/style.min.css?ver=5.6' type='text/css' media='all' />
    <style id='wp-block-library-inline-css' type='text/css'>
        .has-text-align-justify{text-align:justify;}
    </style>
    <link rel='stylesheet' id='sek-base-light-css'  href='https://projetokardec.ufjf.br/wp-content/plugins/nimble-builder/assets/front/css/sek-base-light.css?ver=1617028101' type='text/css' media='all' />
    <link rel='stylesheet' id='hueman-main-style-css'  href='https://projetokardec.ufjf.br/wp-content/themes/hueman/assets/front/css/main.min.css?ver=1617028102' type='text/css' media='all' />
    <style id='hueman-main-style-inline-css' type='text/css'>
        body { font-size:1.13rem; }@media only screen and (min-width: 720px) {
            .nav > li { font-size:1.13rem; }
        }::selection { background-color: #c2955f; }
        ::-moz-selection { background-color: #c2955f; }a,a+span.hu-external::after,.themeform label .required,#flexslider-featured .flex-direction-nav .flex-next:hover,#flexslider-featured .flex-direction-nav .flex-prev:hover,.post-hover:hover .post-title a,.post-title a:hover,.sidebar.s1 .post-nav li a:hover i,.content .post-nav li a:hover i,.post-related a:hover,.sidebar.s1 .widget_rss ul li a,#footer .widget_rss ul li a,.sidebar.s1 .widget_calendar a,#footer .widget_calendar a,.sidebar.s1 .alx-tab .tab-item-category a,.sidebar.s1 .alx-posts .post-item-category a,.sidebar.s1 .alx-tab li:hover .tab-item-title a,.sidebar.s1 .alx-tab li:hover .tab-item-comment a,.sidebar.s1 .alx-posts li:hover .post-item-title a,#footer .alx-tab .tab-item-category a,#footer .alx-posts .post-item-category a,#footer .alx-tab li:hover .tab-item-title a,#footer .alx-tab li:hover .tab-item-comment a,#footer .alx-posts li:hover .post-item-title a,.comment-tabs li.active a,.comment-awaiting-moderation,.child-menu a:hover,.child-menu .current_page_item > a,.wp-pagenavi a{ color: #c2955f; }input[type="submit"],.themeform button[type="submit"],.sidebar.s1 .sidebar-top,.sidebar.s1 .sidebar-toggle,#flexslider-featured .flex-control-nav li a.flex-active,.post-tags a:hover,.sidebar.s1 .widget_calendar caption,#footer .widget_calendar caption,.author-bio .bio-avatar:after,.commentlist li.bypostauthor > .comment-body:after,.commentlist li.comment-author-admin > .comment-body:after{ background-color: #c2955f; }.post-format .format-container { border-color: #c2955f; }.sidebar.s1 .alx-tabs-nav li.active a,#footer .alx-tabs-nav li.active a,.comment-tabs li.active a,.wp-pagenavi a:hover,.wp-pagenavi a:active,.wp-pagenavi span.current{ border-bottom-color: #c2955f!important; }#header { background-color: #ffffff; }
        @media only screen and (min-width: 720px) {
            #nav-header .nav ul { background-color: #ffffff; }
        }
        #header #nav-mobile { background-color: ; }.is-scrolled #header #nav-mobile { background-color: ; background-color: rgba(0,0,0,0.90) }#nav-header.nav-container, #main-header-search .search-expand { background-color: #5c3900; }
        @media only screen and (min-width: 720px) {
            #nav-header .nav ul { background-color: #5c3900; }
        }
        .site-title a img { max-height: 250px; }body { background-color: #ffffff; }
    </style>
    <link rel='stylesheet' id='hueman-font-awesome-css'  href='https://projetokardec.ufjf.br/wp-content/themes/hueman/assets/front/css/font-awesome.min.css?ver=1617028102' type='text/css' media='all' />
    <link rel='stylesheet' id='jetpack_css-css'  href='https://projetokardec.ufjf.br/wp-content/plugins/jetpack/css/jetpack.css?ver=9.5' type='text/css' media='all' />
    -->
    <!--
    <link rel="stylesheet" href="https://orkester.projetokardec.ufjf.br/js/PhotoSwipe/dist/photoswipe.css">
    <link rel="stylesheet" href="https://orkester.projetokardec.ufjf.br/js/PhotoSwipe/dist/default-skin/default-skin.css">
    <script src="https://orkester.projetokardec.ufjf.br/js/PhotoSwipe/dist/photoswipe.min.js"></script>
    <script src="https://orkester.projetokardec.ufjf.br/js/PhotoSwipe/dist/photoswipe-ui-default.min.js"></script>
    -->
    <script src="https://orkester.projetokardec.ufjf.br/js/jquery-viewer/dist/viewer.js"></script><!-- Viewer.js is required -->
    <link  href="https://orkester.projetokardec.ufjf.br/js/jquery-viewer/dist/viewer.css" rel="stylesheet">
    <script src="https://orkester.projetokardec.ufjf.br/js/jquery-viewer/dist/jquery-viewer.js"></script>

</head>
<body class="page-template-default page logged-in no-customize-support wp-embed-responsive sek-hide-rc-badge col-1c full-width header-desktop-sticky header-mobile-sticky chrome">
    {!! $page->generate('content') !!}
</body>
</html>