<?php
$code = [1 => 'C', 2 => 'K', 3 => 'F'];
$itemCode = $data->item->id . $code[$data->item->idCollection];
$elements = (array)$data->item->elements;
$dublinCore = (array)$elements['Dublin Core'];
$manuscripts = (array)$elements['Manuscripts Item Type Metadata'];
list($y, $m, $d) = explode('/', $dublinCore["Date"][0]);
$date = "{$d}/{$m}/{$y}";
$around = $data->item->around;

?>
<div style="width:100%">
    @include('showItem/top')
    <div><h2>{{$dublinCore["Title"][0]}} - {{$date}}</h2></div>
    <div class="ui stackable grid" style="width:100%">
        <div class="twelve wide column">
            @include('showItem/tab')
        </div>
        <div class="four wide column">
            @include('showItem/sidebar')
        </div>
    </div>
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

        jQuery('.ui.accordion')
            .accordion()
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

</style>