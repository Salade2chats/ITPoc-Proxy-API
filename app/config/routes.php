<?php
use Phalcon\Mvc\Router;
use ITPocProxy\Controllers\User;
# use Phalcon\Mvc\Micro\Collection as MicroCollection;

# $users = new MicroCollection();
# $users->setHandler(new \ITPocProxy\Controller\UserController());
# $users->setPrefix('/users');
# $users->get('/{id}', 'get');
# $users->post('/{payload}', 'create');

$router = new Router();

$router->add("/user/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'User',
    'action' => 'get'
])->via(["GET"]);

$router->add("/user", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'User',
    'action' => 'post'
])->via(["POST"]);

$router->add("/user/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'User',
    'action' => 'put'
])->via(["PUT"]);

$router->add("/user/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'User',
    'action' => 'delete'
])->via(["DELETE"]);

// Domain
$router->add("/domain/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domain',
    'action' => 'get'
])->via(["GET"]);

$router->add("/domain", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domain',
    'action' => 'post'
])->via(["POST"]);

$router->add("/domain/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domain',
    'action' => 'put'
])->via(["PUT"]);

$router->add("/domain/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domain',
    'action' => 'delete'
])->via(["DELETE"]);


// SubDomain
$router->add("/sub-domain/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomain',
    'action' => 'get'
])->via(["GET"]);

$router->add("/sub-domain", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomain',
    'action' => 'post'
])->via(["POST"]);

$router->add("/sub-domain/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomain',
    'action' => 'put'
])->via(["PUT"]);

$router->add("/sub-domain/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomain',
    'action' => 'delete'
])->via(["DELETE"]);

return $router;
