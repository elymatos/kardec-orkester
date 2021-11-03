<?php
$lang = $data->lang;
$q = $data->q;

if ($lang == 'fr') {
    $action = "https://projetokardec.ufjf.br/fr/manuscrits";
}
if ($lang == 'pt') {
    $action = "https://projetokardec.ufjf.br/fr/manuscritos";
}
$x = 0;
?>

<h3 style="margin-top:8px">Data de publicação</h3>
<div id="pubDateAccordion" class="ui accordion" style="width:100%">
    @foreach($data->items['pubDateInv'] as $value => $count)
        @php
            list($y, $m, $d) = explode('/', $value);
            $date = "{$d}/{$m}/{$y}";
        @endphp
        <div class="title" style="padding-top: 0px;padding-bottom: 0px;">
            <i class="dropdown icon"></i>
            <span class="item">{{$date}} ({{$count}})</span>
        </div>
        <div id="id_{{$x}}" class="content" data-id="{{$x}}" data-q="pubDate" data-value="{{$date}}">
        </div>
        @php
        ++$x;
        @endphp
    @endforeach
</div>

<h3 style="margin-top:8px">Ano</h3>
<div id="pubDateAccordion" class="ui accordion" style="width:100%">
    @foreach($data->items['year'] as $value => $count)
        <div class="title" style="padding-top: 0px;padding-bottom: 0px;">
            <i class="dropdown icon"></i>
            <span class="item">{{$value}} ({{$count}})</span>
        </div>
        <div id="id_{{$x}}" class="content" data-id="{{$x}}" data-q="year" data-value="{{$value}}">
        </div>
        @php
            ++$x;
        @endphp
    @endforeach
</div>

<h3 style="margin-top:8px">Categoria</h3>
<div id="pubDateAccordion" class="ui accordion" style="width:100%">
    @foreach($data->items['tag'] as $value => $count)
        <div class="title" style="padding-top: 0px;padding-bottom: 0px;">
            <i class="dropdown icon"></i>
            <span class="item">{{$value}} ({{$count}})</span>
        </div>
        <div id="id_{{$x}}" class="content" data-id="{{$x}}" data-q="tag" data-value="{{$value}}">
        </div>
        @php
            ++$x;
        @endphp
    @endforeach
</div>

<h3 style="margin-top:8px">Coleção</h3>
<div id="pubDateAccordion" class="ui accordion" style="width:100%">
    @foreach($data->items['collection'] as $value => $count)
        <div class="title" style="padding-top: 0px;padding-bottom: 0px;">
            <i class="dropdown icon"></i>
            <span class="item">{{$value}} ({{$count}})</span>
        </div>
        <div id="id_{{$x}}" class="content" data-id="{{$x}}" data-q="collection" data-value="{{$value}}">
        </div>
        @php
            ++$x;
        @endphp
    @endforeach
</div>

<script>
    window.onload = function () {
        'use strict';
        jQuery.fn.api.settings.api = {
            'listby get content' : 'https://orkester.projetokardec.ufjf.br/api/Main/Omeka/listItemsBy?__TEMPLATE=content&type=20&id={id}&q={q}&value={value}&lang=pt',
        };

        jQuery('.ui.accordion')
            .accordion({
                'onOpening': function() {
                    jQuery(this).api({
                        action: 'listby get content',
                        on: 'now',
                        onSuccess: function(response, element, xhr) {
                            jQuery(element).html(response.data);
                            jQuery('.ui.accordion').accordion('refresh');
                        },
                    });
                }
            })

    }

</script>
