<?php

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 'on');

spl_autoload_register(function ($class){

    $prefix = 'Juxta\\';

    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $file = __DIR__ . '/src/' . str_replace('\\', '/', substr($class, $len)) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$config = new Juxta\Config(require_once 'config.php');

$app = new Juxta\App($config);

echo $app->run();
