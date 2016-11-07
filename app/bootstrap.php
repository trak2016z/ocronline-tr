<?php
define("APP_BASE", dirname(__DIR__));

// app/bootstrap.php
require_once APP_BASE . '/vendor/autoload.php';

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;


$app = new Silex\Application();

$app['debug'] = true;

$app->register(new NunoPress\Silex\Config\Provider\ConfigServiceProvider(), [
    'config.path' => APP_BASE . '/app/config',
    'config.environment' => ($app['debug']) ? 'dev' : 'prod'
]);

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => APP_BASE . '/app/logs/'.date('Y-m-d').'.log',
));

$app->register(new Silex\Provider\SessionServiceProvider());



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
                'namespace' => 'OCROnline\\Entity',
                'path' => APP_BASE . '/src/OCROnline/Entity',
            ),
        ),
    ),
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'unsecured' => array(
            'pattern' => '^/',
            'http' => true,
            'anonymous' => true,
            'users' => function () use ($app) {
                return new OCROnline\UserProvider($app['orm.em']);
            },
        ),
        
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    )
));

$app->get("/", "OCROnline\\Controller\\HomeController::indexAction");
$app->get("/admin", "OCROnline\\Controller\\AdminController::indexAction");

$app->run();
