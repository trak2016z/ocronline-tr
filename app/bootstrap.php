<?php

// app/bootstrap.php
require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = new Silex\Application();

// Templates
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => dirname(__DIR__) . '/frontend/twig',
]);

// Adding Twig globals


$app->get("/", "OCROnline\\Controller\\HomeController::indexAction");

$app->run();
