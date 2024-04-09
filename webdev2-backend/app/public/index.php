<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the products endpoint
$router->get('/products', 'ProductController@getAll');
$router->get('/products/(\d+)', 'ProductController@getOne');
$router->post('/products', 'ProductController@create');
$router->put('/products/(\d+)', 'ProductController@update');
$router->delete('/products/(\d+)', 'ProductController@delete');

// routes for the categories endpoint
$router->get('/categories', 'CategoryController@getAll');
$router->get('/categories/(\d+)', 'CategoryController@getOne');
$router->post('/categories', 'CategoryController@create');
$router->put('/categories/(\d+)', 'CategoryController@update');
$router->delete('/categories/(\d+)', 'CategoryController@delete');

// routes for the users endpoint
$router->post('/users/login', 'UserController@login');
$router->post('/users/logout', 'UserController@logout');
$router->get('/users', 'UserController@getAll');
$router->get('/users/(\d+)', 'UserController@getOne');

// routes for the cart endpoint
$router->get('/cart', 'CartController@getAll');
$router->get('/cart/(\d+)', 'CartController@getOne');
$router->post('/cart', 'CartController@create');
$router->put('/cart/(\d+)', 'CartController@update');
$router->delete('/cart/(\d+)', 'CartController@delete');


// Run it!
$router->run();