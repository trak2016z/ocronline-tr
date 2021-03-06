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


$app->match("/", "OCROnline\\Controller\\HomeController::indexAction");
$app->match("/admin", "OCROnline\\Controller\\AdminController::indexAction");
$app->match("/login", "OCROnline\\Controller\\LoginController::indexAction");
$app->match("/register", "OCROnline\\Controller\\RegisterController::indexAction");

$app->mount("/user", function ($user) {
    $user->match("/", "OCROnline\\Controller\\UserController::indexAction");
    $user->match("/show/{user_id}", "OCROnline\\Controller\\UserController::showAction");
});

$app->match("/show/image/{id}", "OCROnline\\Controller\\ShowController::imageAction");
$app->match("/show/thumbnail/{id}", "OCROnline\\Controller\\ShowController::thumbnailAction");

$app->mount("/document", function ($document) {
    $document->match("/show/{id}", "OCROnline\\Controller\\DocumentController::showAction");
    $document->match("/best", "OCROnline\\Controller\\DocumentController::bestAction");
    $document->match("/last", "OCROnline\\Controller\\DocumentController::lastAction");
});

$app->error(function(Symfony\Component\HttpKernel\Exception\HttpException $e, Symfony\Component\HttpFoundation\Request $request, $code) use ($app) {
    $twig = $app['twig']->render('error.html.twig', array(
        'message' => $e->getMessage()
    ));
    return new Symfony\Component\HttpFoundation\Response($twig);
});

$app->run();
