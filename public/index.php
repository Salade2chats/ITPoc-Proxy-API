<?php
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

# phpinfo();exit;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$di = new Di();
require(APP_PATH . '/config/services.php');

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);


$loader->registerNamespaces([
    'ITPocProxy\Controller' => APP_PATH . '/controllers/',
    'ITPocProxy\Model' => APP_PATH . '/models/',
]);

$loader->register();

$application = new Application($di);
try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}

