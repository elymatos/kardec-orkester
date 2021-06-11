<?php
$baseURL = "https://orkester.projetokardec.ufjf.br";
//$baseURL = "http://localhost:8900";
?>
<script src="{{$baseURL}}/js/timeline/datatables.min.js"></script>
<script src="{{$baseURL}}/js/timeline/timeline.js"></script>
<link href="{{$baseURL}}/js/timeline/style.css" rel="stylesheet">
<link href="{{$baseURL}}/js/timeline/datatables.min.css" rel="stylesheet">

<div>
    <p>Clique em uma das barras correspondentes a cada ano ou sobre o circulo correspondente a um evento. Percorra a lista de itens ou use o campo 'Filtro' para pesquisar nos títulos e descrições.</p>
</div>

<div id="block-system-main" class="block block-system">
    <div>
        <div class="darwin-timeline-container" >
            <div id="block-darwin-letter-timeline-darwin-timeline-chart">
                <div>
                    <div id='darwin_timeline_chart_content'>
                        <main id="timeline">

                        </main>
                    </div>
                </div>
            </div>
            <div id="block-darwin-letter-timeline-darwin-timeline-letters">
                <div>
                    <div id='darwin_timeline_letter_content'>
                        <aside id="letterDataTemplate">
                            <div id="closeWindow">x</div>

                            <table id='letterTable' class="display">
                                <thead>
                                <th>Date</th>
                                <th>From/to</th>
                                <th>Person</th>
                                <th>Excerpt</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>