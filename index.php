<?php
$basePath = __DIR__.'/';
require_once $basePath.'Modules/settings.php';
require_once $basePath.'Modules/routes.php';

$requestPath = '';
$result = [];

if ($_GET) 
{
    $requestPath = $_GET['route'];
}

if ($requestPath && $requestPath[-1] == "/") 
{
    $requestPath = substr($requestPath, 0, strlen($requestPath) - 1);
}

require_once $basePath.'vendor/autoload.php';
require_once $basePath.'Modules/exceptionshandler.php';

use \Modules\Core\Application;

$app = new Application;
$app->run($rules, $requestPath);