<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta name="Generator" content="Maestro Framework; http://maestro.org.br">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>{{$manager->getOptions('pageTitle')}}</title>
        <meta name="description" content="Framenet Brasil Webtool 4.0">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Carrega o icone da aplicação -->
        <link rel="icon" type="image/x-icon" href="favicon.ico" />

        <!-- Carrega o jQuery - obrigatório em todos os temas -->
        <script type="text/javascript" src="/scripts/jquery-2.1.1.min.js"></script>

        <!-- Carrega o tema e suas dependências -->
        {{var $includes = file_get_contents($page->uiPath . "/templates//assets.ink")}}
        {{var $lines = explode(PHP_EOL,$includes)}}
        {{foreach $lines as $line}}
            {{var $line = trim($line)}}
            {{if $line && $line[0] != ';'}}
                {{if strpos($line, ".jsw", strlen($line) - strlen(".jsw")) !== FALSE}}
                    {{var $line = substr($line,0,-1)}}
                    <script type="javascript/worker" src="{{$line}}"></script>
                {{/if}}
                {{if strpos($line, ".js", strlen($line) - strlen(".js")) !== FALSE}}
        <script type="text/javascript" src="{{$line}}"></script>
                {{/if}}
                {{if strpos($line, ".css", strlen($line) - strlen(".css")) !== FALSE}}
        <link rel="stylesheet" href="{{$line}}">
                {{/if}}
            {{/if}}
        {{/foreach}}
        <script type="text/javascript" src="/scripts/theme.js"></script>
        <link rel="stylesheet" href="/css/layout.css">
    </head>
    <body>
