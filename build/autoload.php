<?php

// load psr4
require __DIR__.'/artifacts/gw2tools.phar';

// prevent composer from autoloading GW2Treasures\GW2Tools\* from src
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->setPsr4('GW2Treasures\\GW2Tools\\', []);
