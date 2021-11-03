<?php

use App\Modules\Main\Services\OmekaService;
use App\Modules\Main\Services\TimelineService;
use Carbon\Carbon;
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
    $dataTimeline = [
        "top_level" => [],
        "by_year" => []
    ];
    /*
     *       "nid": "1",
      "title": "Nasce  Hippolyte Leon Denizard Rivail, em Lyon, França",
      "body": "<p>Hippolyte Leon Denizard Rivail, filho de ---  e -- ....<\/p>\r\n",
      "y": "1804",
      "m": "10",
      "d": "03",
      "z": "42",
      "display_date": "12 February 1809",
      "top_level": "1",
      "image": "https:\/\/www.darwinproject.ac.uk\/sites\/default\/files\/MS-DAR-00225-000-00137-00001.jpg"
     */
    $items = [
        /*
        1 => [
            "title" => "Nasce  Hippolyte Leon Denizard Rivail",
            "body" => "Hippolyte Leon Denizard Rivail, filho de ---  e -- ....",
            "date" => "1804/10/03",
        ],
        2 => [
            "title" => "Morre  Hippolyte Leon Denizard Rivail (Allan Kardec)",
            "body" => "....",
            "date" => "1869/03/31",
        ],
        3 => [
            "title" => "Lançamento de O Livro dos Espíritos - 1. edição",
            "body" => "....",
            "date" => "1857/04/18",
        ],
        */
    ];
    foreach ($items as $id => $item) {
        $dt = Carbon::createFromFormat('Y/m/d', $item['date']);
        $event = [
            "nid" => $id,
            "title" => $item['title'],
            "body" => $item['body'],
            "y" => $dt->year,
            "m" => $dt->month,
            "d" => $dt->day,
            "z" => (int)$dt->floatDiffInDays($dt->year . '-01-01 00:00'),
            "display_date" => $dt->day . '/' . $dt->month . '/' . $dt->year,
            "top_level" => "1",
            "image" => ""
        ];
        $dataTimeline["top_level"][] = $event;
        $dataTimeline["by_year"][$dt->year][] = $event;
    }
    $json = json_encode($dataTimeline);
    file_put_contents('timeline-events-json-pt.json', $json);
} catch (Exception $e) {
    print_r($e);
    print_r($e->getMessage());
}

