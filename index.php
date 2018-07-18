<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\phpappbuilder\router\Router;

use Tracy\Debugger;
Debugger::$strictMode = true;
//Debugger::$showBar = true;
Debugger::enable();

$router = new Router();
$router->run();