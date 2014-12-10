<?php

spl_autoload_register(function ($class) {
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