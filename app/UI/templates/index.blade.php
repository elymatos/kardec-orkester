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
    <script type="text/javascript" src="/scripts/jquery-2.1.1.min.js"></script>
</head>
<body>
    {!! $page->generate('content') !!}
</body>
</html>