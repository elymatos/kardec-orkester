<?php
/**
 * CARMA
 */
declare (strict_types=1);

$dir = dirname(dirname(__FILE__));
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_STRICT");
ini_set("display_errors", "1");
ini_set("log_errors", "1");
ini_set("error_log", "{$dir}/var/log/php_error.log");
ini_set("session.save_path", "{$dir}/var/sessions");

require __DIR__.'/../vendor/autoload.php';
set_error_handler('errorHandler');
Orkester\Manager::process();
Orkester\Manager::terminate();


