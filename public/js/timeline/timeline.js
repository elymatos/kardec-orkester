(function ($) {

    $.fn.timelineview = function (options) {

        // get options
        var opts = $.extend({}, $.fn.timelineview.defaults, options);

        /*
         * Iterate through each of the elements to apply to
         */
        return this.each(function () {

            var timelineContainer = $(this);

            var $table;
            var nextRow;
            var start = 1801;
            var end = 1890;
            var yearData = [];
            var monthData = [];
            var dayData = [];
            var biggestDayInYear = [];
            for (var i = 0; i <= (end - start); i++) {
                yearData[i] = 0;
                biggestDayInYear[i] = 0;
                monthData[i] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                dayData[i] = [];
                for (var k = 0; k < 12; k++) {
                    dayData[i][k] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                }
            }

            var openYear = null;
            var inTransit = false;
            var yearQuantities = [];
            var maxLettersPerYear = 0;
            var screenWidth, yearWidth;
            var currentYear;
            //var months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var months = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
            var daysPerMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            var letterHeight = 25;
            var nextClick;
            var targetDay;
            var letterData;
            var lifeEvents = [];
            var lifeEventDetailShown = false;

            // empty the filter variable, which will now be used by the letters table
            var filter = '';

            // not yet plotted
            var yearsPlotted = false;
            var monthsPlotted = false;

            if (!opts.letterID) {
                // create timeline immediately if we're not looking at a single letter
                createTimeline();
            } else {
                timelineContainer.find('#darwin_timeline_letter_table').on('show', function () {
                    if (!timelineContainer.find('#darwin_timeline_letter_table').hasClass('initialised')) {
                        timelineContainer.find('#darwin_timeline_letter_table').addClass('initialised');
                        // create the timeline now that the "around this date" tab has been clicked
                        createTimeline();
                    }
                });
            }

            /**
             * create timeline when ready
             */
            function createTimeline() {

                var letterDate = opts.defaultLetterDate;

                var container = timelineContainer.find("#darwin_timeline_letter_content");
                var timelineChart = timelineContainer.find("#timeline");

                // ajax spinner
                container.append('<div id="timeline-loading"></div>');

                //@dbgIE11
                // console.log('createTimeline');

//    $.getJSON("/sites/all/modules/darwin_letter_timeline/timeline-gen.js", function (data) {
//     $.getJSON("/sites/all/modules/darwin_letter_timeline/timeline-new.js", function (data) {
                $.getJSON("https://projetokardec.ufjf.br/wp-content/uploads/timeline/letters-timeline-json-pt.json", function (data) {

                    // filter letters by canonical name
                    if (opts.filterCanonicalRx) {
                        var newLetters = [];
                        $.each(data.letters, function (i, item) {

                            // if (i<50 && console) {
                            //   console.log({item:item});
                            // }

                            var match = false;
                            for (var n in item) {
//                var str = item[n] + "";
                                // str = str.toLowerCase();
                                // filter = filter.toLowerCase();
                                if (
                                    (item.sender && item.sender.match(opts.filterCanonicalRx)) ||
                                    (item.recipient && item.recipient.match(opts.filterCanonicalRx))
                                ) {
                                    // if (str.match(opts.filterCanonicalRx)) {
//            if (str.indexOf(filter) != -1) {
                                    match = true;
                                    break;
                                }
                                // @CR2018-02-09
                                else if (
                                    (item.sender && item.sender == opts.filterFullName) ||
                                    (item.recipient && item.recipient == opts.filterFullName)
                                ) {
                                    // if (str.match(opts.filterCanonicalRx)) {
//            if (str.indexOf(filter) != -1) {
                                    match = true;
                                    break;
                                }

                            }

                            if (match) {
                                newLetters.push(item);
                            }
                        });

                        // replace letters data source
                        data.letters = newLetters;
                    }

                    //var $content = "";
                    var lastDate = '1801-01-01';
                    $.each(data.letters, function (i, item) {
                        var match = true;

                        if (item.direction == undefined) {
                            if (console) console.log('letter ' + item.id + ', direction undefined');
                            if (console) console.log(item);
                            item.direction = 'To';
//            data.letters[i] = item;
                        }

//          if (item.dateStart <= '1809-12-01') {
                        if (item.dateStart == '1801-01-01') {
                            if (item.dateEnd != undefined && item.dateEnd != '') {
//              if (console) console.log('letter ' + item.id + ', dateStart < 1809-12-01, used dateEnd');
                                //if (console) console.log('letter ' + item.id + ', dateStart = 1809-01-01, used dateEnd');
                                item.dateStart = item.dateEnd;
                            }

//             if (item.dateStart != undefined && item.dateStart != '' && item.dateStart <= '1809-12-01') {
// //              var thisDate = item.dateStart.split("-");
//               var newDate = '1882-12-31';
//               if (console) console.log('letter ' + item.id + ', dateStart moved from ' + item.dateStart + ' to ' + newDate);
//               item.dateStart = newDate;
//             }

//            console.log(item);
                        }

                        if (item.dateStart == undefined || item.dateStart == '') {
                            if (item.dateEnd != undefined && item.dateEnd != '') {
                                //if (console) console.log('letter ' + item.id + ', dateStart undefined, used dateEnd');
                                item.dateStart = item.dateEnd;
//              data.letters[i] = item;
                            } else {
                                if (console) console.log('letter ' + item.id + ', dateStart undefined, no dateEnd');
                                item.dateStart = lastDate;
//              data.letters[i] = item;
                            }
                        } else {
                            lastDate = item.dateStart;
                        }

                        if (match) {


                            //else
                            {
                                var thisData = item.dateStart.split("-");
                                var thisYear = parseInt(thisData[0]);
                                var mm = parseInt(thisData[1]);
                                var dd = parseInt(thisData[2]);
                                if (isNaN(thisYear) || isNaN(mm) || isNaN(dd)) {
                                    if (console) console.log('letter ' + item.id + ', dateStart not valid: ' + item.dateStart);
                                    if (isNaN(thisYear)) {
                                        thisYear = 1801;
                                    }
                                    if (isNaN(mm)) {
                                        mm = 1;
                                    }
                                    if (isNaN(dd)) {
                                        dd = 1;
                                    }

                                    // need a valid date value or dataTables will complain
                                    item.dateStart = thisYear + '-' + (mm < 10 ? '0' : '') + mm + '-' + (dd < 10 ? '0' : '') + dd;
                                }
                                // else
                                {
                                    yearData[(thisYear - start)]++;
                                    monthData[(thisYear - start)][mm - 1]++;
                                    dayData[(thisYear - start)][mm - 1][dd - 1]++;
                                }

                                // if we've been given a specific letter ID
                                if (opts.letterID) {
                                    // if it matches, then make a note of the date
                                    if (item.id == opts.letterID) {
                                        letterDate = [thisYear, mm, dd];
                                    }
                                }
                            }
                        }
                    });


                    //timelineContainer.find("#letterDataTemplate table tbody").children().remove();
                    //timelineContainer.find("#letterDataTemplate table tbody").html($content);*/
                    //console.log(monthData);
                    window._letterData = letterData = data.letters;

                    // trigger initial size configuration
                    if (opts.showTimelineChart) {
                        timelineChart.trigger('window.resize');
                    }

                    //@dbgIE11
                    // console.log('about to init');

                    // initialise components
                    init();


                    /**
                     * @CR2017-03-16
                     * right, now all that lot's loaded and dealt with
                     * let's look up and add life events
                     * data as {
                     *  top_level: [array],
                     *  by_year: [1861:[array], ...]
                     * }
                     *
                     * event contains: {
                     *  title, body, y, m, d, display_date, z (day of year)
                     * }
                     */
                    if (opts.showLifeEvents) {
                        $.getJSON("https://projetokardec.ufjf.br/wp-content/uploads/timeline/timeline-events-json-pt.json", function (data) {
                            if (data['top_level']) {
                                lifeEvents = data;
                                for (var k = 0; k < data['top_level'].length; k++) {
                                    var event = data['top_level'][k];
                                    var eventId = 'lifeEvent_tl' + event['nid'];
                                    var lifeEvent = timelineContainer.find('#' + eventId);
                                    if (lifeEvent.length == 0) {
                                        lifeEvent = $('<span class="lifeEvent" id="' + eventId + '" data-nid="' + event['nid'] + '"><span class="event-date">' + event['display_date'] + ':</span> <span class="event-title">' + event['title'] + '</span></span>');
                                        // expect to find a bar with given year
                                        var bar = timelineContainer.find('#bars span.year[data-year=' + event['y'] + ']');
                                        if (bar.length) {
                                            bar.append(lifeEvent);
                                        }
                                    }
                                }
                            }
                        });
                    }

                });

                // update coordinates of rectBackBtn
                function getRectBackBtn() {
                    var close = timelineContainer.find('#closeYear');
                    if (close.length) {
                        return close[0].getBoundingClientRect();
                    } else {
                        return null;
                    }
                }

                var resizeTimer = null;

                // set up handler to cope with window resize

                if (opts.showTimelineChart) {
                    timelineChart.on('window.resize', function () {
                        screenWidth = $(container).width();
                        yearWidth = (screenWidth / (end - start));

                        var wh = $(window).height();
                        var h;
                        if (opts.isNameRegs) {
                            h = wh * 0.25;
                        } else {
                            h = wh * 0.4;
                        }
                        // force a min height
                        h = Math.max(h, 200);

                        timelineChart.height(h);
                        // firefox puts a big gap otherwise
                        timelineContainer.find('#block-darwin-letter-timeline-darwin-timeline-chart').css('min-height', 'auto');

                        if (resizeTimer) {
                            clearTimeout(resizeTimer);
                            resizeTimer = null;
                        }

                        // use a little delay before applying new window size
                        // to avoid to many calls to this
                        resizeTimer = setTimeout(function () {
                            resizeTimer = null;

                            // if years have been plotted, then time to resize
                            if (yearsPlotted) {
                                // console.log('resizing years');
                                plotYears(true);
                            }

                            // if months have been plotted, then time to resize
                            if (monthsPlotted && openYear && currentYear) {
                                // console.log('resizing months');
                                openYear.css("width", screenWidth + 'px');
                                openYear.css("left", 0);
                                openYear.css("height", timelineContainer.find("#bars").height() + 'px');
                                plotMonths(openYear, currentYear, true);
                            }

                            if (openYear) {
                                var y = timelineChart.height() + 5;
                                timelineChart.find('span.lifeEvent.forYear').each(function (i, e) {
                                    // work out position relative to timeline based on day of year
                                    // note "screenWidth" is actually container width
                                    var x = screenWidth * $(e).attr('data-z') / 365.0;
                                    $(e).css('left', x + 'px').css('top', y + 'px');
                                });
                            }

                        }, 250);
                    });

                    // handle window resize
                    $(window).resize(function () {
                        timelineChart.trigger('window.resize');
                    });

                    // remove spinner
                    timelineContainer.find('#timeline-loading').remove();
                }


                // initialise chart
                function init() {

                    // console.log(opts);

                    // console.log(letterData);
                    // screenWidth = $(container).width();
                    // yearWidth = (screenWidth / (end - start));
                    // target.height($(window).height() * 0.4);

                    if (opts.showTimelineChart) {
                        timelineChart.append("<section id='bars'></section>")
                    }

                    // letter quantities
//      var influence = 0;
                    for (var i = 0; i < (end - start); i++) {
                        yearQuantities[i] = yearData[i];
                        maxLettersPerYear = Math.max(yearQuantities[i], maxLettersPerYear);
                    }

                    var defaultTimeout = 0;

                    // if chart is shown
                    if (opts.showTimelineChart) {
                        plotYears();
                        // wait a second if chart is to be shown
                        defaultTimeout = 1000;
                    }

                    // wait a second before doing this if showing chart (why? transition?)
                    setTimeout(function () {

                        if (opts.letterID) {

                            // use a bit more height when have single letter ID
                            var wh = $(window).height();
                            var t = $('.region-content').offset().top;
                            var h = wh - t - 150 /* woolly offset */;
                            if (h > 300) {
                                timelineContainer.find("#letterDataTemplate").height(h);
                            }
                            timelineContainer.find("#letterDataTemplate")[0].offsetHeight;
                        }

                        // load table takes a few seconds
                        //@dbgIE11 - taking ~40 secs on IE11 - until deferRender enabled
                        loadTable();
                        //@dbgIE11
                        // console.log('table loaded');

                        // a dynamic title: '[number of letters] exchanged with [Correspondent]'
                        if (opts.isNameRegs && $("input#timelinefilter_canonical").length > 0) {
                            timelineContainer.find('#timeLineIntro').text(letterData.length + ' letter' + (letterData.length == 1 ? '' : 's') + ' exchanged with: ' + opts.filterFullName);
                        }

                        if (timelineChart.length == 0) {
                            if (opts.letterID) {

                                openLettersWindow(letterDate[2], letterDate[1], letterDate[0], opts.letterID);

                                // when the user opens the letters table on the "letter" page
                                // then trigger this opener - basically to scroll to date
                                timelineContainer.find('#darwin_timeline_letter_table').on('show', function () {
                                    openLettersWindow(letterDate[2], letterDate[1], letterDate[0], opts.letterID);
                                });

                                // reconfigure secondary content size
                                $('.campl-secondary-content').trigger('reconfigure');

                            } else {
                                var querydate = getQueryParameter('date');
                                if (querydate) {
                                    timelineContainer.find("#letterDataTemplate").height($(window).height());
                                    var dates = querydate.split("/");
                                    //openLettersWindow(day,month,year,top)
                                    openLettersWindow(dates[0], dates[1], dates[2]);
                                }
                            }
                        }
                    }, defaultTimeout);
                };

                // this can take a few seconds - there's a lot of data
                function loadTable() {
                    $table = timelineContainer.find('#letterTable').DataTable({
                        oLanguage: {
                            "sSearch": "Filtro:",
                            "sInfo": "_START_ até _END_ de _TOTAL_ itens",
                            "sInfoFiltered": " - filtrados de _MAX_ itens",
                            "sZeroRecords": "Nenhum item",
                            "sEmptyTable": "Nenhum item",
                            "sInfoEmpty": "Nenhum item"
                        },


                        //@dbgIE11 - this brings it down from 40 secs to about 4 secs
                        "bDeferRender": true,
                        bAutoWidth: false,
                        bSortClasses: false,


                        data: letterData,
                        columns: [
                            {data: "dateStart", visible: false},
                            {
                                data: "code",
                                className: 'letterName',
                                width: "5%",
                            },
                            {
                                data: "title",
                                className: 'letterName',
                                width: "35%",
                                render: function (data, type, full, meta) {
                                    return cleanCharaters(data);
                                }
                            },
                            {
                                data: "summary",
                                className: 'letterDesc',
                                width: "50%",
                                render: function (data, type, full, meta) {
                                    return cleanCharaters(data);
                                }
                            },
                            {data: "path", visible: false}
                        ],

                        scrollY: timelineContainer.find("#letterDataTemplate").height() - 50,
                        scrollX: false,
                        scroller: true
                        // diagonal stripes rendering issue in chrome
                        //scroller: {
                        //    rowHeight: 30
                        //}
                    });
                    timelineContainer.find('#letterTable tbody').on('click', 'tr', function () {
                        var rowData = $table.row(this).data();
                        createPreview(rowData);

                    });
                    timelineContainer.find('#letterTable_length').hide();

                    //console.log(nextRow);

                    if (nextRow != undefined && nextRow > 0) {
                        //@dbgIE11 -- this is where IE is slow
                        // $table.row(nextRow).scrollTo();
                        //@dbgIE11 -- added new API hook, uses deprecated method if no filter - no sorting - yes-faster
                        $table.row(nextRow).scrollToFast(nextRow);
                    }
                }

                function createPreview(rowData) {
                    //alert( 'You clicked on '+rowData.title+'\'s row' );
                    timelineContainer.find("#rowPreview").remove();

                    // @CR2017-02-10 - append Google analytics code to URL
                    var letterUrl = rowData.path.replace('letters/', 'letter/');

                    // not working with drupal URL / CUDL call
                    // if (letterID) {
                    //   letterUrl += '?utm_source=timeline&utm_medium=around_this_date';
                    // }
                    // else if (opts.isNameRegs) {
                    //   letterUrl += '?utm_source=timeline&utm_medium=name_register';
                    // }
                    // else {
                    //   letterUrl += '?utm_source=timeline&utm_medium=main_timeline';
                    // }

                    timelineContainer.find("#letterDataTemplate").append("<div id='rowPreview'><div id='closePreview'>x</div><h2>" + cleanCharaters(rowData.title) + "</h2><p>" + cleanCharaters(rowData.summary) + "</p><p><a class='letterLink' target='_blank' href='/" + letterUrl + "'>View letter</a></p></div>")
                    timelineContainer.find("#closePreview").on("click", function () {
                        timelineContainer.find("#rowPreview").remove();
                    });
                }

                function plotYears(resizing) {

                    var l, w, h;
                    var bh = timelineContainer.find("#bars").height();

                    for (var i = 0; i < (end - start); i++) {
                        var yearClass = "interval";
                        //if ((i - 1) % 10 == 0) {
                        if ((i + 1) % 10 == 0) {
                            yearClass = "decade";
                        }
                        //var thisYear = 9 + i;
                        var thisYear = i + 1;
                        if (thisYear < 10) {
                            thisYear = "0" + thisYear;
                        }

                        var bar = timelineContainer.find('#bar' + i);
                        if (bar.length == 0) {
                            bar = $("<span id='bar" + i + "' class='year' data-expanded='false'><b class='" + yearClass + "'>18" + (thisYear) + "</b></span>");
                            // @CR2017-03-16 - timeline_events, add a data-year attribute
                            bar.attr('data-year', "18" + thisYear);
                            timelineContainer.find("#bars").append(bar);
                        }

                        // if (opts.showLifeEvents) {
                        //   for (var k = 0; k < lifeEvents.length; k++) {
                        //     if (lifeEvents[k].year == start + i) {
                        //       var lifeEvent = timelineContainer.find('#lifeEvent' + k);
                        //       if (lifeEvent.length == 0) {
                        //         lifeEvent = $("<span class='lifeEvent' id='lifeEvent'" + k + ">" + lifeEvents[k].year + ": " + lifeEvents[k].title + "</span>");
                        //         bar.append(lifeEvent);
                        //       }
                        //     }
                        //   }
                        // }

                        // left, width, height
                        l = i * yearWidth + 'px';
                        w = yearWidth + 'px';
                        h = (5 + ((yearQuantities[i] / maxLettersPerYear) * bh)) + 'px';

                        // if already expanded bar, then update data attributes instead
                        if (bar.hasClass("expanded")) {
                            bar.attr("data-width", w);
                            bar.attr("data-left", l);
                            bar.attr("data-height", h);
                        } else {
                            bar.css("width", w).css("left", l);
                            bar.css("height", h);
                        }
                        bar.attr("data-year", start + i);
                    }

                    // if resizing, then we've done enough by this point
                    if (resizing) {
                        return;
                    }

                    var roundedMid = Math.round(Math.floor(maxLettersPerYear / 2) / 10) * 10;
                    // show year-middle if NOT name regs
                    if (!opts.isNameRegs) {
                        //timelineContainer.find("#years-middle").remove();
                        //timelineContainer.find("#bars").prepend("<div id='years-middle' ><span>" + roundedMid + "</span></div>");
                        //timelineContainer.find("#years-middle").css("bottom", ((roundedMid / maxLettersPerYear) * 100) + '%');
                    }
                    $("#tooltip").remove();
                    $("body").append("<div id='tooltip' />");

                    timelineContainer.find(".lifeEvent").on("click", function () {
                        timelineContainer.find(".lifeDetails").removeClass("selectedEvent");
                        $(this).addClass("selectedEvent");
                    });

                    timelineContainer.find("#bars").on("positiontooltip", function (srce, e) {
                        if (e.originalEvent) {

                            var x, y;
                            if (e.mypos) {
                                x = e.mypos.left + 8;
                                y = e.mypos.top;
                            } else {
                                x = e.originalEvent.clientX;
                                y = e.originalEvent.clientY;
                                x += $(window).scrollLeft();
                                y += $(window).scrollTop();
                            }

                            /**
                             * @CR2017-03-16 - timeline events
                             */
                            var tt = $("#tooltip");
                            x = x - (tt.width() / 2) - 14;

                            // force height calculation
                            tt[0].offsetHeight;
                            var h = tt.height();
                            // console.log(h);
                            y -= h + 48;

                            tt.css("left", x + 'px')
                                .css("top", y + 'px')
                                .css("z-index", 2000);
                        }
                    });

                    var barsHover = false;
                    timelineContainer.find("#bars").on("mouseenter", function (e) {

                        // @CR2017-03-16 - life events
                        if (lifeEventDetailShown) {
                            return;
                        }

                        // show only if year is not open
                        // if (!openYear) {
                        barsHover = true;
                        $("#tooltip").show();
                        //}

                        timelineContainer.find("#bars").trigger('positiontooltip', e);
                    });

                    // var tdbg = 0;
                    timelineContainer.find("#bars").on("mousemove", function (e) {

                        // @CR2017-03-16 - life events
                        if (lifeEventDetailShown) {
                            return;
                        }

                        // show only if year is not open
                        // if (!openYear && !barsHover) {
                        barsHover = true;
                        // }

//        var yearIndex = Math.floor((end - start) * (e.originalEvent.clientX / ($(window).width())));
//         console.log(target);

                        var okToShow = true;
                        var offset = timelineContainer.find("#bars").offset();
                        if (e.originalEvent && e.originalEvent.clientX != undefined) {
                            var x = e.originalEvent.clientX + $(window).scrollLeft();
                            var y = e.originalEvent.clientY + $(window).scrollTop();

                            /**
                             * @CR2017-03-16 - timeline events
                             */
                            var src = $(e.srcElement || e.target); //@CR2017-09-04
                            if (src.hasClass('lifeEvent')) {
                                $("#tooltip").html(src.html());
                            } else if (!openYear) {
                                var yearIndex = Math.floor((end - start) * ((x - offset.left) / (timelineChart.width())));
                                var yearStat = yearQuantities[yearIndex];
                                okToShow = yearStat !== undefined;
                                $("#tooltip").html((1801 + yearIndex) + ":<br />" + yearStat + ' ' + (yearStat == 1 ? 'item' : 'itens'));
                            } else {
                                // var monthIndex = Math.floor(12 * ((x - offset.left) / (timelineChart.width())));
                                // var dayIndex = 10;
                                // var monthStat = monthData[(currentYear - start)][monthIndex];
                                // okToShow = monthStat !== undefined;

                                var monthFloat = 12 * ((x - offset.left) / (timelineChart.width()));
                                var monthIndex = Math.floor(monthFloat);
                                var daysFloat = monthFloat - monthIndex;
                                var dayIndex = Math.floor(daysPerMonth[monthIndex] * daysFloat);
                                var dayStat = dayData[(currentYear - start)][monthIndex][dayIndex];
                                okToShow = dayStat !== undefined;

                                $("#tooltip").html(((dayIndex + 1) + '/' + months[monthIndex]) + ":<br />" + dayStat + " " + (dayStat == 1 ? 'item' : 'itens'));
                            }

                            var rectBackBtn = getRectBackBtn();
                            // console.log(x, y, rectBackBtn);
                            if (!okToShow || (rectBackBtn &&
                                x > rectBackBtn.left && x < rectBackBtn.left + rectBackBtn.width &&
                                e.originalEvent.clientY > rectBackBtn.top && e.originalEvent.clientY < rectBackBtn.top + rectBackBtn.height)) {
                                $("#tooltip").hide();
                            } else {
                                $("#tooltip").show();
                                timelineContainer.find("#bars").trigger('positiontooltip', e);
                            }
                        }

                        // if (++tdbg%20==0) {
                        //   console.log([target, offset, e.originalEvent.clientX-offset.left, yearIndex, target.width(), e.originalEvent]);
                        // }

                    });
                    timelineContainer.find("#closeYear").on("mouseenter", function (e) {
                        e.preventDefault();
                        $("#tooltip").html("");
                        $("#tooltip").hide();
                    });
                    timelineContainer.find("#bars").on("mouseleave", function (e) {
                        barsHover = false;
                        $("#tooltip").html("");
                        $("#tooltip").hide();

                    });

                    /**
                     * @CR2017-03-16 - timeline events for when a year is expanded
                     */
                    function showTimelineEventsForYear(year) {
                        if (!lifeEvents['by_year'] || !lifeEvents['by_year'][year]) {
                            return;
                        }

                        for (var k = 0; k < lifeEvents['by_year'][year].length; k++) {
                            var event = lifeEvents['by_year'][year][k];
                            var eventId = 'lifeEvent_yr' + event['nid'];
                            var lifeEvent = timelineContainer.find('#' + eventId);

                            if (lifeEvent.length == 0) {
                                lifeEvent = $('<span class="lifeEvent forYear" id="' + eventId + '" data-nid="' + event['nid'] + '" data-z="' + event['z'] + '"><span class="event-date">' + event['display_date'] + ':</span> <span class="event-title">' + event['title'] + '</span></span>');
                                // work out position relative to timeline based on day of year
                                // note "screenWidth" is actually container width
                                var x = screenWidth * event['z'] / 365.0;
                                var y = timelineChart.height() + 5;
                                lifeEvent.css('left', x + 'px').css('top', y + 'px');
                                lifeEvent.data({eventId: eventId, event: event});
                                // append to #timeline
                                timelineChart.append(lifeEvent);

                                lifeEvent.mouseenter(function (e) {
                                    // @CR2017-03-16 - life events
                                    if (lifeEventDetailShown) {
                                        return;
                                    }
                                    var offset = timelineContainer.find("#bars").offset();
                                    var off2 = $(this).offset();
                                    if (e.originalEvent && e.originalEvent.clientX != undefined) {

                                        e.mypos = off2;

                                        // console.log(e, $(e.srcElement ? e.srcElement : e.target).html());

                                        $("#tooltip").html($(e.srcElement ? e.srcElement : e.target).html());
                                        $("#tooltip").show();
                                        timelineContainer.find("#bars").trigger('positiontooltip', e);
                                    }
                                });

                                lifeEvent.mouseleave(function (e) {
                                    $("#tooltip").hide();
                                });

                                lifeEvent.click(function () {
                                    if (!lifeEventDetailShown) {
                                        showTimelineEventDetail($(this).data('event'));
                                    }
                                    return false;
                                });
                            }
                        }
                    }

                    function showTimelineEventDetail(event) {
                        // flag to say this is on display
                        lifeEventDetailShown = true;
                        $("#tooltip").hide();

                        // find or create detail popup
                        // for blurb about location, and letters list
                        var div = timelineContainer.find('#lifeEvent-detail');
                        if (!div.length) {
                            div = $('<div id="lifeEvent-detail"></div>');
                            timelineContainer.find('#timeline').append(div);
                        }
                        div.children().remove();
                        var inner = $('<div class="inner"></div>');
                        div.append(inner);

                        inner.append($('<a id="lifeEvent-close" href="#"> </a>'));
                        inner.append($('<h2 class="lifeEvent-date"></h2>').text(event['display_date']));
                        if (event['image']) {
                            inner.append('<img src="' + event['image'] + '" />');
                        }
                        inner.append($('<h3 class="lifeEvent-title"></h3>').text(event['title']));
                        inner.append($('<div class="lifeEvent-body"></div>').html(event['body']));

                        // // list of related letters
                        // if (event['letters']) {
                        //   inner.append($('<h3 class="lifeEvent-subtitle">Letters</h3>'));
                        //   var ul = $('<ul class="lifeEvent-letters"></ul>');
                        //
                        //   var letter, li, a;
                        //   for (var i in event['letters']) {
                        //     letter = event['letters'][i];
                        //     li = $('<li/>');
                        //     a = $('<a target="_blank"></a>').html(letter['title']).attr('href', letter['url']);
                        //     li.append(a);
                        //     ul.append(li);
                        //   }
                        //
                        //   inner.append(ul);
                        // }

                        inner.find('#lifeEvent-close').click(function () {
                            timelineContainer.find('#lifeEvent-detail').remove();
                            $('#lifeEvent-blocker').remove();
                            // clear flag
                            lifeEventDetailShown = false;
                            return false;
                        });

                        // fade
                        var blocker = $('<div id="lifeEvent-blocker" />');
                        blocker.height($('body').height());
                        $('body').append(blocker);
                        setTimeout(function () {
                            blocker.addClass('shown');
                            div.addClass('shown');
                        }, 0);
                    }

                    timelineContainer.find(".year").on("click", function (e) {

                        if ($(this).attr("data-expanded") == "false" && !lifeEventDetailShown) {

                            // do nothing if a transition is occurring
                            if (inTransit) {
                                // console.log('already in transit');
                                return;
                            }

                            /**
                             * @CR2017-03-16 - timeline events
                             * check if source of click was a timeline event
                             * show detail if it was
                             */
                            var src = $(e.srcElement || e.target); //@CR2017-08-19
                            if (src.hasClass('lifeEvent')) {

                                if (!lifeEvents['top_level']) {
                                    return false;
                                }

                                // find by NID
                                var nid = src.attr('data-nid');
                                var event = null;
                                for (var k = 0; k < lifeEvents['top_level'].length; ++k) {
                                    if (lifeEvents['top_level'][k].nid == nid) {
                                        event = lifeEvents['top_level'][k];
                                    }
                                }
                                if (!event) {
                                    if (console) console.log('life event ' + nid + ' not found');
                                    return false;
                                }

                                showTimelineEventDetail(event);

                                return false;
                            }
                            /**
                             * @CR2017-03-16 - end
                             */

                            // now a transition is occurring until I say otherwise
                            inTransit = true;

                            timelineContainer.find("#timeLineIntro").fadeOut();

                            openYear = $(this);

                            // if transitions not supported, don't wait
                            if ($('html').hasClass('no-csstransforms3d')) {
                                inTransit = false;
                                showTimelineEventsForYear(openYear.attr('data-year'));
                            } else {
                                // else, wait for transition to end before we allow mouse actions again
                                $(this).on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", {}, function () {
                                    $(this).off("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd");
                                    // console.log('transition over');
                                    inTransit = false;
                                    if (openYear) showTimelineEventsForYear(openYear.attr('data-year'));
                                });
                            }

                            openYear.css('cursor', 'default');

                            //$("#tooltip").hide();
                            barsHover = false;

                            openYear.find(".lifeEvent").addClass("selectedEvent");
                            openYear.addClass("expanded");
                            timelineContainer.find(".year").not(openYear).fadeOut();
                            openYear.attr("data-width", openYear.css("width"));
                            openYear.attr("data-left", openYear.css("left"));
                            openYear.attr("data-height", openYear.css("height"));
                            openYear.css("width", screenWidth + 'px');
                            openYear.css("left", 0);
                            openYear.css("height", timelineContainer.find("#bars").height() + 'px');
                            openYear.attr("data-expanded", "true");

                            // bring the year bar to the top
                            // but we need to undo on close

                            // @z-index was 1000 - above menu
                            openYear.css("z-index", 1);

                            currentYear = openYear.attr("data-year");
                            setTimeout(function () {
                                plotMonths(openYear, currentYear);
                            }, 1000);
                            openYear.prepend("<div id='closeYear'>&larr; Voltar</div>");
                            if (currentYear > start) {
                                openYear.prepend("<div id='prevYear'>&larr;</div>");
                            }
                            if (currentYear < (end - 1)) {
                                openYear.prepend("<div id='nextYear'>&rarr;</div>");
                            }
                            timelineContainer.find("#bars").trigger('mousemove', e);

                            timelineContainer.find("#closeYear").on("click", function (e) {

                                if (openYear) {

                                    if (lifeEventDetailShown) {
                                        return false;
                                    }

                                    // do nothing if a transition is occurring
                                    if (inTransit) {
                                        // console.log('already in transit');
                                        return false;
                                    }

                                    // now a transition is occurring until I say otherwise
                                    inTransit = true;

                                    // if transitions not supported, don't wait
                                    if ($('html').hasClass('no-csstransforms3d')) {
                                        inTransit = false;
                                    } else {
                                        // else, wait for transition to end before we allow mouse actions again
                                        openYear.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", {}, function () {
                                            $(this).off("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd");
                                            // console.log('transition over');
                                            inTransit = false;
                                        });
                                    }
                                }

                                // @CR2017-03-16 - timelive events - for year
                                timelineContainer.find(".lifeEvent.forYear").remove();

                                e.stopPropagation();
                                timelineContainer.find(".lifeEvent").removeClass("selectedEvent");
//          openYear = $("#closeYear").parent();

                                if (openYear) {
                                    openYear.css('cursor', '');
                                    openYear.attr("data-expanded", "false");
                                    openYear.css("width", openYear.attr("data-width"));
                                    openYear.css("height", openYear.attr("data-height"));
                                    openYear.css("left", openYear.attr("data-left"));
                                    openYear.find(".monthBars").remove();
                                    openYear.removeClass("expanded");
                                    // undo z-index change
                                    openYear.css("z-index", '');
                                    timelineContainer.find(".year").not(openYear).fadeIn();
                                    timelineContainer.find("#nextYear,#prevYear").remove();
                                    $(this).remove();
                                    openYear = null;
                                }
                                // clear flag that we've plotted months
                                monthsPlotted = false;
                            });

                            timelineContainer.find("#nextYear").on("click", function (e) {
                                e.stopPropagation();
                                timelineContainer.find(".lifeEvent").removeClass("selectedEvent");
                                nextClick = $(this).parent().next();
                                setTimeout(function () {
                                    nextClick.click();
                                }, 1000);
                                timelineContainer.find("#closeYear").click();

                            });
                            timelineContainer.find("#prevYear").on("click", function (e) {
                                e.stopPropagation();
                                timelineContainer.find(".lifeEvent").removeClass("selectedEvent");
                                nextClick = $(this).parent().prev();
                                setTimeout(function () {
                                    nextClick.click();
                                }, 1000);
                                timelineContainer.find("#closeYear").click();

                            });
                        }
                    });

                    // flag that we've plotted years
                    yearsPlotted = true;
                }

                function plotMonths(targetBar, yearNumber, resizing) {
                    scrollToDate("01", "01", yearNumber);
                    targetBar.find("monthBars").remove();
                    targetBar.append("<div class='monthBars'></div>");
                    var monthBars = targetBar.find(".monthBars");

                    // figure out the biggest day in this year if not yet known
                    if (biggestDayInYear[yearNumber - start] == 0) {
                        for (var mm = 0; mm < 12; mm++) {
                            var letters;
                            for (var i = 0; i < daysPerMonth[mm]; i++) {
                                letters = dayData[(yearNumber - start)][mm][i];
                                if (letters > biggestDayInYear[yearNumber - start]) {
                                    biggestDayInYear[yearNumber - start] = letters;
                                }
                            }
                        }
                    }

                    // don't allow div by zero
                    if (biggestDayInYear[yearNumber - start] == 0) {
                        biggestDayInYear[yearNumber - start] = 1;
                    }

                    // recalibrate letter height based on biggest day in year
                    var bh = timelineContainer.find("#bars").height();
                    letterHeight = (timelineContainer.find("#bars").height() - 50) / biggestDayInYear[yearNumber - start];


                    // console.log(biggestDayInYear, yearNumber - start);

                    var maxMonth = 0;
                    for (var k = 0; k < monthData[(yearNumber - start)].length; k++) {
                        maxMonth = Math.max(maxMonth, monthData[(yearNumber - start)][k]);
                    }
                    var barHeightScale = 0.7 * bh / (maxMonth == 0 ? 1 : maxMonth);
                    for (var i = 0; i < 12; i++) {
                        var monthHeight = barHeightScale * monthData[(yearNumber - start)][i];
                        var monthBar = timelineContainer.find('#monthbar' + i);
                        if (monthBar.length == 0) {
                            monthBar = $("<span id='monthbar" + i + "' class='month'><b>" + months[i] + "</b></span>");
                            monthBars.append(monthBar);
                        }
                        monthBar.css("width", (screenWidth / 12) + 'px').css("left", (i * (screenWidth / 12)) + 'px');

                        monthBar.attr("data-days", daysPerMonth[i]);
                        monthBar.attr("data-month", i + 1);
                        monthBar.attr("data-height", monthHeight);
                        monthBar.attr("data-year", yearNumber);
                        monthBar.animate({"height": (20 + monthHeight) + 'px'}).delay(0).promise().done(function () {

                            plotDays($(this), $(this).attr("data-days"), $(this).attr("data-height"), $(this).attr("data-month"), $(this).attr("data-year"), resizing);
                            $(this).find('span.timeline-letter').css('height', letterHeight + 'px');

                            $(this).find('.timeline-letter').on("click", function (e) {
                                console.log('timeline-letter');
                                console.log('days ' + $(this).attr("data-days"));
                                console.log('day ' + $(this).attr("data-day"));
                                console.log('month ' + $(this).attr("data-month"));
                                console.log('year ' + $(this).attr("data-year"));
                                openLettersWindow($(this).attr("data-day"), $(this).attr("data-month"), $(this).attr("data-year"));
                            });


                        });
                    }

                    // done if resizing
                    if (resizing) {
                        return;
                    }

                    /*
                    timelineContainer.find(".month").on("click", function (e) {
                        console.log('days ' + $(this).attr("data-days"));
                        console.log('day ' + $(this).attr("data-day"));
                        console.log('month ' + $(this).attr("data-month"));
                        console.log('year ' + $(this).attr("data-year"));

                        var position = e.pageX - $(this).offset().left;
                        var dayWidth = $(this).width() / $(this).attr("data-days");
                        var day = Math.round(position / dayWidth);
                        if (day == 0) {
                            day = 1;
                        }

                        // send d, m, y for scroll position
                        openLettersWindow(day, $(this).attr("data-month"), $(this).attr("data-year"));


                    });

                     */

                    // flag that we've plotted months
                    monthsPlotted = true;
                }

                function plotDays(targetMonth, monthLength, monthHeight, monthNumber, yearNumber, resizing) {
                    //console.log(targetMonth+"-"+monthLength+"-"+monthHeight+"-"+monthNumber+"-"+yearNumber);
                    for (var i = 0; i < monthLength; i++) {

                        var letters = dayData[(yearNumber - start)][(monthNumber - 1)][i];

                        for (var j = 0; j < letters; j++) {

                            var letterId = 'ltr_' + yearNumber + '_' + monthNumber + '_' + i + '_' + j;
                            var letter = timelineContainer.find('#' + letterId);
                            if (letter.length == 0) {
                                letter = $("<span class='timeline-letter' id='" + letterId + "'></span>");
                                targetMonth.append(letter);
                            }

                            var letterType = Math.round(Math.random() * 1);
                            if (letterType == 0) {
                                letter.addClass("toLetter");
                            } else {
                                letter.addClass("fromLetter");
                            }
                            var letterBottom;
                            if (i % 2 == 0) {
                                letterBottom = 0;
                            } else {
                                letterBottom = 0;
                            }
                            letter.css("bottom", (letterBottom + (letterHeight * j)) + 'px');
                            letter.css("left", ((targetMonth.width() / monthLength) * i) + 'px');
                            letter.attr("data-day", i + 1);
                            letter.attr("data-month", monthNumber);
                            letter.attr("data-year", yearNumber);
                        }
                    }
                }

                function scrollToDate(day, month, year, letterID) {
                    //console.log('scrollToDate = ' + day + ' ' + month + ' ' + year + ' ' + letterID);
                    //@dbgIE11
//        console.log('start scroll to date');
                    var row = -1;
                    var nrows = 0;
                    //@dbgIE11 - try without accumulating this array
                    var firstrow = -1;
//        var rows = [];
                    for (var i = 0; i < letterData.length; i++) {
                        //console.log( letterData[i]);
                        if (letterData[i].dateStart.indexOf(year + "-" + month) != -1) {
                            //@dbgIE11
                            if (firstrow == -1) {
                                firstrow = i;
                            }
//          rows.push(i);
                            ++nrows;
                        }
                        if (letterID) {
                            if (letterData[i].id == letterID) {
                                row = i;

                                // highlight selected letter
                                $($table.row(i).node()).addClass('active-letter');
                                // @CR2017-03-06 - do it a bit later too
                                // first highlight doesn't always work, perhaps too soon
                                setTimeout(function () {
                                    $($table.row(i).node()).addClass('active-letter');
                                }, 1000);
                                break;
                            }
                        } else {
                            if (letterData[i].dateStart == year + "-" + month + "-" + day) {
                                row = i;
                                break;
                            }
                        }
                    }

                    // does this offset help centre the chosen date in the table a little?
                    var offset = 3;
                    if (row >= 3 && row - offset < letterData.length) {
                        row -= offset;
                    }

                    //@dbgIE11 - scrollTo was about 10 seconds
                    // console.log('before scrollTo');

                    if ($table != undefined && row != -1) {
                        nextRow = row;
                        //@dbgIE11 -- this is where IE is slow
//          $table.row(row).scrollTo();
                        //@dbgIE11 -- added new API hook, uses deprecated method if no filter - no sorting - yes-faster
                        console.log('scroll to ' + row);
                        //$table.row(row).scrollToFast(row);
                        $table.row( row ).scrollTo();
                        //@dbgIE11
//        } else if ($table != undefined && rows != undefined && rows.length > 0) {
                    } else if ($table != undefined && firstrow > -1) {
                        //@dbgIE11 -- added new API hook, uses deprecated method if no filter - no sorting - yes-faster
                        console.log('scroll to ' + firstrow);
                        $table.row(firstrow).scrollToFast(firstrow);
//        $table.row(firstrow).scrollTo();
                    }

                    //@dbgIE11 - about 10 seconds
                    // console.log('after scrollTo');

                    timelineContainer.find("#letterDataTemplate").not(":visible").fadeIn();
                    if (timelineChart.length > 0) {
                        //timelineContainer.find("#letterDataTemplate").css("top",timelineContainer.find("#timeline").height()+timelineContainer.find("#timeline").offset().top+25);
                    } else {
                        timelineContainer.find("#letterDataTemplate").css("top", 0);
                    }
                    timelineContainer.find("#date-report").remove();
                    timelineContainer.find("#letterTable_wrapper").prepend("<span id='date-report'>Datas próximas a " + day + "/" + month + "/" + year + "</span>");
                }


                /**
                 * open letters window, scroll to date, or letter by ID
                 * @param day
                 * @param month
                 * @param year
                 * @param letterID
                 */
                function openLettersWindow(day, month, year, letterID /*, top*/) {
                    //console.log('openLettersWindow = ' + day + ' ' + month + ' ' + year + ' ' + letterID);
                    /*if(top==undefined){
                     top=(target.position().top+target.height())+'px';
                     }
                     timelineContainer.find("#letterDataTemplate").css("top",top);*/

                    // if we're inside #darwin_timeline_letter_table
                    // then don't fadeIn
                    // we're on the "letter" page and the user will
                    // click a tab to show the table

                    // if (timelineContainer.find("#darwin_timeline_letter_table").length) {
                    //   timelineContainer.find("#letterDataTemplate").css('display', 'block');
                    // }
                    // else {
                    timelineContainer.find("#letterDataTemplate").fadeIn();
                    // }

                    if (month < 10) {
                        month = "0" + month;
                    }
                    if (day < 10) {
                        day = "0" + day;
                    }

                    scrollToDate(day, month, year, letterID);

                    if (filter && filter != "") {
                        $table.search(filter).draw();
                    }

                    /*timelineContainer.find(".dateHeader th").each(function(){
                     $(this).html((day+index)+" "+months[(month-1)]+" "+year);
                     targetDay = $(this);
                     if(index==0){
                     timelineContainer.find(".tableScroll").animate({
                     scrollTop:targetDay.position().top
                     });
                     }
                     index++;

                     });
                     timelineContainer.find(".tableScroll .name").on("click",function(){
                     findMatchingName($(this).text());
                     });*/

                    // remove spinner
                    timelineContainer.find('#timeline-loading').remove();

                }

                // no close window required when showing ONLY the letters table
                if (opts.showTimelineChart) {
                    timelineContainer.find("#closeWindow").on("click", function () {
                        timelineContainer.find("#letterDataTemplate").fadeOut();
                    });
                } else {
                    timelineContainer.find("#closeWindow").remove();
                }

                function findMatchingName(nameToMatch) {

                    timelineContainer.find(".tableScroll .highlightedName").removeClass("highlightedName");
                    timelineContainer.find(".tableScroll .name").each(function () {
                        if ($.trim($(this).text()) == $.trim(nameToMatch)) {
                            $(this).parent().addClass("highlightedName");
                        }
                    });
                }
            }

            function cleanCharaters(data) {
                if (data == undefined) return '';
                data = data.split("<i>").join(" <i>");
                data = data.split("</i>").join("</i> ");
                data = data.split("<span").join(" <span");
                data = data.split("/span>").join("/span> ");
                data = data.split("</p><p>").join(" ");
                data = data.split("&amp;ndash;").join("-");
                data = data.split("&amp;hellip;").join("...");
                data = data.split("&amp;frac12;").join("½");
                data = data.split("&amp;eacute;").join("é");
                data = data.split("&amp;Eacute;").join("É");
                data = data.split("&amp;amp;").join("&");
                data = data.split("&amp;ntilde;").join("ñ");
                data = data.split("&amp;atilde;").join("ã");
                data = data.split("&amp;auml;").join("ä");
                data = data.split("&amp;uuml;").join("ü");
                data = data.split("&amp;ouml;").join("ö");
                data = data.split("&amp;pound;").join("£");
                data = data.split("&amp;aelig;").join("ae");
                return data;
            }

            function getQueryParameter(key) {
                key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
                var match = location.search.match(new RegExp("[?&]" + key + "=([^&]+)(&|$)"));
                return match && decodeURIComponent(match[1].replace(/\+/g, " "));
            }
        });
    }

    // default options
    $.fn.timelineview.defaults = {
        filterCanonicalRx: false,
        filterFullName: null,
        // flag if nameregs page
        isNameRegs: false,
        // life events not shown when top level filter in place
        showLifeEvents: true,
        // chart will be hidden on single letter pages
        showTimelineChart: true,
        // for particular letter page
        letterID: false,
        letterDate: false,
        // default letter date, for when letterID not found
        // will try to extract from <h1> if possible
        defaultLetterDate: '1801-01-01',
    };


    /**
     * @dbgIE11
     * attempt to speed up dataTable scroll to row
     */

    $(document).ready(function () {
        // DataTables 1.10 API method aliases
        var Api = $.fn.dataTable.Api;

        // register an alternative scroll method
        // passing row index in "ani"
        Api.register('row().scrollToFast()', function (ani) {
            var that = this;

            //@dbgIE11
            // console.log('start row().scrollToFast()');
            // console.log(ani);

            // if filtered, then have to use an iterator, which is slow in IE
            // otherwise use deprecated, but fast scroll method

            if ($('#letterTable_filter input').val() > '') {
                // it's this iterator that's slow
                this.iterator('row', function (ctx, rowIdx) {
                    if (ctx.oScroller) {
                        var displayIdx = that
                            //          .rows( { order: 'applied', search: 'applied' } )
                            .rows({search: 'applied'})
                            .indexes()
                            .indexOf(rowIdx);

                        ctx.oScroller.fnScrollToRow(displayIdx, ani);
                    }
                });
            } else {
                //@dbgIE11 -- try deprecated method - no sorting - yes-fast
                this.scroller().scrollToRow(ani);

            }

            return this;
        });

        // moved general initialisation to here
        var opts = {};
        var filter = '', filter2 = null;

        var mainTimeline = $('div.darwin-timeline-container');
        if (mainTimeline.length) {

            // check for presence of #timelinefilter element on page
            // use canonical name format
            var input = $('input#timelinefilter_canonical');
            if (input.length) {
                filter = input.val().split("amp;").join("");
            } else {
                input = $('div[data-canonical]:first');
                if (input.length) {
                    filter = input.attr("data-canonical");
                    console.log(filter);
                }
            }
            if (filter.indexOf(",") != -1) {
                var filterArr = filter.split(",");
                filter = filterArr[0] + " " + filterArr[1];
            }
            var input2 = $('input#timelinefilter_fullname');
            if (input2.length) {
                filter2 = input2.val();
                filter2 = filter2.split(", 1st baronet").join(" (1st baronet)");
                filter2 = filter2.split(", 4th baronet and 1st Baron Avebury").join(" (4th baronet and 1st Baron Avebury)");
                filter2 = filter2.split(", 3d baronet").join(" (3d baronet)");
            }
            // filter = getQueryParameter("filter");
            if (filter && filter != '') {
                opts.filterCanonicalRx = new RegExp(filter.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"), 'i');
                //@CR2018-02-09
                if (filter2) {
                    //opts.filterFullName = filter2;
                    if (filter2.indexOf(",") != -1) {
                        var filterArr = filter2.split(",");
                        filter2 = filterArr[0];
                    }
                    opts.filterFullName = filter2;

                } else {
                    opts.filterFullName = $("div[data-canonical] > h2:first").text();
                    opts.filterFullName = opts.filterFullName.split("\n").join(" ").split("  ").join(" ").split("  ").join(" ").split("  ").join(" ").split("  ").join(" ").split("  ").join(" ");
                    console.log(opts.filterFullName);

                }
                // don't show life events when filtered
                opts.showLifeEvents = false;
                opts.isNameRegs = true;
                console.log(opts.filterFullName);
                // remove intro text
                $('#timeLineIntro').text('');
            } else {
                // for individual letter pages
                // extract the letter ID, then we'll scroll to that and show the table
                var details = $('#letter_details');
                if (details.length) {
                    details.find('dd').each(function (i, e) {
                        if ($(e).text().match(/^DCP-LETT-/)) {
                            opts.letterID = $.trim($(e).text());

                            // if we have a letter ID, then there are rare occasions where
                            // this letter is NOT in the feed for the timeline
                            // this will mess up "around this date" unless we deal with it
                            // try to figure out the letter date from the letter title

                            var letterTitle = $('div.opener:first h1').text();
                            if (letterTitle) {
                                var matches;
                                // assume 4 digits beginning 18 is a year
                                matches = letterTitle.match(/(18[0-9]{2})/);
                                var y = 1801;
                                var m = '01';
                                var d = '01';
                                if (matches) {
                                    var mnths = {
                                        'jan': '01', 'feb': '02', 'mar': '03', 'apr': '04', 'may': '05', 'jun': '06',
                                        'jul': '07', 'aug': '08', 'sep': '09', 'oct': '10', 'nov': '11', 'dec': '12'
                                    };
                                    y = matches[1];
                                    // console.log(matches);
                                    // try a bit of text before the year
                                    matches = letterTitle.match(/([a-z]+)\s+18[0-9]{2}/i);
                                    // console.log(matches);
                                    if (matches) {
                                        var t = matches[1].substring(0, 3).toLowerCase();
                                        if (mnths[t]) {
                                            m = parseInt(mnths[t], 10);
                                            // try for a day!
                                            // @CR2017-03-16 - letter bug fix
                                            matches = letterTitle.match(/([0-9]{1,2})\s+[a-z]+\s+18[0-9]{2}/i);
                                            // console.log(matches);
                                            if (matches) {
                                                d = parseInt(matches[1], 10);
                                            }
                                        }
                                    }
                                }

                                opts.defaultLetterDate = [y, m, d];
                            }
                        }
                    });
                    if (opts.letterID) {
                        opts.showTimelineChart = false;

                        setTimeout(function () {
                            // also, for individual letters, create "with this correspondent" letters table
                            var correspTimeline = $('div.darwin-timeline-container-correspondent');
                            if (correspTimeline.length) {
                                var opts2 = $.extend({}, opts);

                                // @CR2018-03-29
                                // if a letter page, try from, to
                                var ld = $('#letter_details');
//                console.log(ld);

                                // lots of horrific spaces and newlines! in content
                                var ddf = $('#letter_details dl span.from dd').text();
                                if (ddf) ddf = $.trim(ddf.replace(/\s+/g, ' '));
                                var ddt = $('#letter_details dl span.to dd').text();
                                if (ddt) ddt = $.trim(ddt.replace(/\s+/g, ' '));

                                // console.log({ddf: ddf, ddt: ddt});

                                if (ddf && ddf != 'Charles Robert Darwin') {
                                    opts2.filterFullName = ddf;
                                } else if (ddt && ddt != 'Charles Robert Darwin') {
                                    opts2.filterFullName = ddt;
                                }


                                // find first non "Darwin, C. R." #terms entry, use that for canonical name
                                $('#terms li a').each(function (i, e) {
                                    if (!opts2.filterCanonicalRx) {
                                        var t = $.trim($(e).text());
                                        if (t != 'Darwin, C. R.') {
                                            opts2.filterCanonicalRx = t;
                                        }
                                    }
                                });
                                if (console) console.log({opts2: opts2});
                                if (!opts2.filterCanonicalRx && !opts2.filterFullName) {
                                    // hide correspondent link if none found
                                    $('#correspondentLink').hide();
                                } else {
                                    correspTimeline.timelineview(opts2);
                                    // NOW create the timeline
                                    mainTimeline.timelineview(opts);
                                }
                            }

                        });
                        return;
                    }
                }
            }

            // NOW create the timeline
            mainTimeline.timelineview(opts);
        }
    });


})(jQuery);
