<?php

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 'on');

spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName  = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
});

set_include_path('src/' . PATH_SEPARATOR . get_include_path());

use Juxta\App;
use Juxta\Config;

$config = new Config(require_once 'config.php');

$app = new App($config);

echo $app->run();
