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

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => APP_BASE . '/app/logs/'.date('Y-m-d').'.log',
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/admin',
            'http' => true,
            'users' => array(
                // raw password is foo
                'admin' => array('ROLE_ADMIN', '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
            ),
        ),
    )
));

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
