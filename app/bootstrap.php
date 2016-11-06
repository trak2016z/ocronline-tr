<?php
define("APP_BASE", __DIR__ . "/../");

// app/bootstrap.php
require_once APP_BASE . '/vendor/autoload.php';

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;


$app = new Silex\Application();

$app['debug'] = true;

$app->register(new NunoPress\Silex\Config\Provider\ConfigServiceProvider(), [
    'config.path' => APP_BASE . '/app/config',
    'config.environment' => ($app['debug']) ? 'dev' : 'prod'
]);

// Templates
$app->register(new Silex\Provider\TwigServiceProvider(), $app['config']->get('twig') );

$app->register(new Silex\Provider\DoctrineServiceProvider, array(
    'db.options' => $app['config']->get('db.options')
));

$app->register(new DoctrineOrmServiceProvider, array(
    'orm.proxies_dir' => APP_BASE . '/app/cache/doctrine/proxy',
    'orm.em.options' => array(
        'mappings' => array(
            // Using actual filesystem paths
            array(
                'type' => 'annotation',
                'namespace' => 'OCROnline\Entity',
                'path' => APP_BASE . '/src/Entity',
            ),
        ),
    ),
));

$app->get("/", "OCROnline\\Controller\\HomeController::indexAction");

$app->run();
