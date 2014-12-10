<?php

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 'on');

require 'autoload.php';

$config = new Juxta\Config(require 'config.php');

$app = new Juxta\App($config);

echo $app->run();