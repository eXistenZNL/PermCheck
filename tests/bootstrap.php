<?php

$loader = require dirname(__DIR__) . '/vendor/autoload.php';

// Add the tests namespace to the Composer autoloader for tests only.
$loader->setPsr4("tests\\", __DIR__);
