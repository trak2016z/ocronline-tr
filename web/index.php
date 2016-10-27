<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function () use ($app) {
    return 'Skromne początki, wielkie marzenia...';
});

$app->run();

