<?php


use Phalcon\Db\Adapter\Pdo\Postgresql as DbAdapter;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Filter;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View;
use Phalcon\Security;

$di->set('view', function () {
    $view = new View();
    $view->disable();
    return $view;
}, true);

$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $eventsManager = new EventsManager();
    $eventsManager->attach(
        "dispatch:beforeDispatchLoop",
        function (Event $event, $dispatcher) {
            /** @var Dispatcher $dispatcher*/
            $ctrlName = $dispatcher->getControllerName();
            $normalizedName = strtolower(preg_replace('/(?<!^)([A-Z])/', '-\1', $ctrlName));
            $dispatcher->setControllerName($normalizedName);
        }
    );
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

$di->set('response', [
    'className' => 'Phalcon\Http\Response',
]);

$di->set("request", Request::class, true);

$di->set("modelsManager", function () {
    return new Manager();
});

$di->set("modelsMetadata", function () {
    return new Memory();
});

// Setup a base URI
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);

$di->set('router', function () {
    return require APP_PATH . '/config/routes.php';
});

// Setup the database service
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host' => 'database',
                'username' => getenv('PG_ITPOC_USER'),
                'password' => getenv('PG_ITPOC_PASSWORD'),
                'dbname' => getenv('PG_ITPOC_DB'),
            ]
        );
    }
);

// Register a 'filter' service in the container
$di->set(
    'filter',
    function () {
        return new Filter();
    }
);

$di->set(
    "security",
    function () {
        $security = new Security();

        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    },
    true
);
