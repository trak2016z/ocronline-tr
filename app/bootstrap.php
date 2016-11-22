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
            'form' => array('login_path' => '/login', 'check_path' => '/user/login_check'),
            'logout' => array('logout_path' => '/user/logout', 'invalidate_session' => true),
            'anonymous' => true,
            'users' => function () use ($app) {
                return new OCROnline\UserProvider($app['orm.em']);
            },
        ),
        
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
        array('^/user',  'ROLE_USER')
    )
));

$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

$app->register(new Silex\Provider\CsrfServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());


$app->get("/", "OCROnline\\Controller\\HomeController::indexAction");
$app->get("/admin", "OCROnline\\Controller\\AdminController::indexAction");
$app->get("/login", "OCROnline\\Controller\\LoginController::indexAction");
$app->get("/register", "OCROnline\\Controller\\RegisterController::indexAction");
$app->post("/register", "OCROnline\\Controller\\RegisterController::indexAction");

$app->run();
