<?php
define("APP_BASE", __DIR__);
// Doctrine CLI configuration
require APP_BASE . '/vendor/autoload.php';

$app = new Silex\Application();


$newDefaultAnnotationDrivers = array(
    APP_BASE . "/src/"
);

$app['debug'] = true;

$app->register(new NunoPress\Silex\Config\Provider\ConfigServiceProvider(), [
    'config.path' => APP_BASE . '/app/config',
    'config.environment' => ($app['debug']) ? 'dev' : 'prod'
]);

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
$driverImpl = $config->newDefaultAnnotationDriver($newDefaultAnnotationDrivers);
$config->setMetadataDriverImpl($driverImpl);
$config->setProxyDir(APP_BASE . "/app/cache/doctrine/proxy");
$config->setProxyNamespace("Proxies");
$em = \Doctrine\ORM\EntityManager::create($app['config']->get('db.options'), $config);
$helpers = new Symfony\Component\Console\Helper\HelperSet(array(
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em),
));