<?php
use \Shaarli\Controller as SC;

define('BASE_PATH', dirname($_SERVER['PHP_SELF']));
define('APP_PATH', realpath(dirname(__FILE__)));

//require_once __DIR__ . '/legacy.php';
require_once __DIR__ . '/vendor/autoload.php';

$frontController = new SC\FrontController();

$frontController->run();
