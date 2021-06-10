<?php

use App\Modules\Main\Services\OmekaService;
use App\Modules\Main\Services\TimelineService;
use Orkester\Manager;

$baseDir = realpath(dirname(dirname(dirname(__FILE__))));

//ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_STRICT");
ini_set("display_errors", "1");
ini_set("log_errors", "1");
ini_set("error_log", "php_error.log");
ini_set("session.save_path", "{$baseDir}/var/sessions");

require $baseDir . '/vendor/autoload.php';
set_error_handler('errorHandler');

try {
    Orkester\Manager::init();
    $collection = [
        '1' => 'C',
        '2' => 'A',
        '3' => 'F'
    ];
    $dataTimeline = [
        "requestURI" => '',
        "dateTimeFormat" => "iso8601",
        "statistics" => [
            "letter" => [
                [
                    "count" => 0,
                    "kardecSent" => 0,
                    "kardecReceived" => 0,
                    "3rdParty" => 0
                ]
            ],
            "people" => [
                [
                    "count" => 0,
                ]
            ],
            "bibliographies" => [
                [
                    "count" => 0,
                ]
            ],
        ],
        "letters" => [
        ]
    ];
    Orkester\Manager::setData((object)[
        'limit' => 1000,
        'page' => 1,
        'lang' => 'pt'
    ]);
    $omekaService = Manager::getContainer()->get(OmekaService::class);
    $letters = [];
    $items = $omekaService->browseItems();
    foreach ($items as $i => $item) {
        list($y, $m, $d) = explode('/', $item->date);
        $sm = $m;
        $em = $m;
        if ($m == 'MM') {
            $sm = '01';
            $em = '12';
        }
        $sd = $d;
        $ed = $d;
        if ($d == 'DD') {
            $sd = '01';
            $ed = '31';
        }
        $displayDate = $d . '/' . $m . '/' . $y;
        $date =  $y . '-' . $sm . '-' . $sd;
        $dateStart =  $y . '-' . $sm . '-' . $sd;
        $dateEnd =  $y . '-' . $em . '-' . $ed;
        $ix = $dateStart . substr('000' . $i, -3);
        $letters[$ix] = [
            "id" => $item->id,
            "code" => $item->id . $collection[$item->idCollection],
            "path" => "",
            "title" => $item->title . ' [' . $displayDate . ']',
            "date" => $date,
            "displayDate" => $displayDate,
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "direction" => "",
            "deprecated" => "Unidentified",
            "sender" => "Unidentified",
            "recipient" => "Unidentified",
            "url" => "/item-pt?id={$item->id}",
            "summary" => $item->title
        ];
    }
    ksort($letters);
    foreach($letters as $letter) {
        $dataTimeline['letters'][] = $letter;
    }
    $json = json_encode($dataTimeline);
    file_put_contents('../../public/js/timeline/letters-timeline-json-pt.json', $json);
} catch (Exception $e) {
    print_r($e);
    print_r($e->getMessage());
}

