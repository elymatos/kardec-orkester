<?php
?>
<script src="/js/timeline/datatables.min.js"></script>
<script src="/js/timeline/timeline.js"></script>
<link href="/js/timeline/style.css" rel="stylesheet">
<link href="/js/timeline/datatables.min.css" rel="stylesheet">

<div id="block-system-main" class="block block-system">
    <div>
        <div class="darwin-timeline-container" >
            <div id="block-darwin-letter-timeline-darwin-timeline-chart">
                <div>
                    <div id='darwin_timeline_chart_content'>
                        <main id="timeline">

                        </main>
                        <aside id="timeLineIntro">

                            <p>To get started, click on any year in the chart, or pick an event. Then
                                scroll up and down through a chronological list of all
                                letters. Use the filter to search for names and key words. Click on the
                                bars within each year to jump to the letters from a particular day. Or
                                close that year and choose another.
                            </p>
                        </aside>
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

</div><!--
<div class="darwin-timeline-container">
    <div id="block-darwin-letter-timeline-darwin-timeline-chart" style="min-height: auto;">
        <div>
            <div id="darwin_timeline_chart_content">
                <main id="timeline" style="height: 330.8px;">

                    <section id="bars"></section>
                </main>
                <aside id="timeLineIntro">

                    <p>To get started, click on any year in the chart, or pick an event. Then
                        scroll up and down through a chronological list of all
                        letters. Use the filter to search for names and key words. Click on the
                        bars within each year to jump to the letters from a particular day. Or
                        close that year and choose another.
                    </p>
                </aside>
            </div>
        </div>
    </div>
    <div id="block-darwin-letter-timeline-darwin-timeline-letters">
    </div>
</div>
-->