<?php

require_once __DIR__ . '/vendor/autoload.php';

function autoload($className)
{
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $fullPath = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';

    // Добавим вывод информации для отладки
    // echo "Trying to load: " . $fullPath . PHP_EOL;

    if (file_exists($fullPath)) {
        require_once $fullPath;
    } else {
        echo "Class file not found: " . $fullPath . PHP_EOL;
    }
}

spl_autoload_register('autoload');
