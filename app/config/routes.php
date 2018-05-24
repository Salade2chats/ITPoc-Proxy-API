<?php
use Phalcon\Mvc\Router;

$router = new Router();

// Users
$router->add("/users/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Users',
    'action' => 'get'
])->via(["GET"]);

$router->add("/users", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Users',
    'action' => 'post'
])->via(["POST"]);

$router->add("/users/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Users',
    'action' => 'put'
])->via(["PUT"]);

$router->add("/users/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Users',
    'action' => 'delete'
])->via(["DELETE"]);

// Domains
$router->add("/domains/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domains',
    'action' => 'get'
])->via(["GET"]);

$router->add("/domains", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domains',
    'action' => 'post'
])->via(["POST"]);

$router->add("/domains/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domains',
    'action' => 'put'
])->via(["PUT"]);

$router->add("/domains/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'Domains',
    'action' => 'delete'
])->via(["DELETE"]);

// SubDomains
$router->add("/sub-domains/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomains',
    'action' => 'get'
])->via(["GET"]);

$router->add("/sub-domains", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomains',
    'action' => 'post'
])->via(["POST"]);

$router->add("/sub-domains/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomains',
    'action' => 'put'
])->via(["PUT"]);

$router->add("/sub-domains/{id}", [
    'namespace' => 'ITPocProxy\\Controller',
    'controller' => 'SubDomains',
    'action' => 'delete'
])->via(["DELETE"]);

return $router;
