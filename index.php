<?php

require_once __DIR__ . '/autoload.php';

use Entities\TelegraphText;
use Interfaces\IRender;
use Core\Templates\Swig;
use Core\Templates\Spl;

$telegraphText = new TelegraphText('text', 'some slug');
$telegraphText -> editText('title', 'some text');
var_dump($telegraphText);

$swig = new Swig('telegraph_text');
$swig -> addVariablesToTemplate(['slug', 'text']);

$spl = new Spl('telegraph_text');
$spl -> addVariablesToTemplate(['slug', 'title', 'text']);

$templateEngines = [$swig, $spl];

foreach ($templateEngines as $engine) {
    if ($engine instanceof IRender) {
        echo $engine -> render($telegraphText) . PHP_EOL;
    } else {
        echo 'Template engine does bot support render interface' . PHP_EOL;
    }
}
