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
$router->get('/products/category/(\d+)', 'ProductController@getByCategory');
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
$router->post('/users/register', 'UserController@register');
$router->put('/users/(\d+)', 'UserController@update');
$router->put('/users/admin/(\d+)', 'UserController@updateAdmin');
$router->delete('/users/(\d+)', 'UserController@delete');
$router->get('/users', 'UserController@getAll');
$router->get('/users/(\d+)', 'UserController@getOne');

// routes for the cart endpoint
$router->get('/shoppingcart', 'CartController@getAll');
$router->get('/shoppingcart/(\d+)', 'CartController@getOne');
$router->post('/shoppingcart', 'CartController@create');
$router->put('/shoppingcart/(\d+)', 'CartController@update');
$router->delete('/shoppingcart/(\d+)', 'CartController@delete');

// routes for the orders endpoint
$router->get('/orders', 'OrderController@getAll');
$router->get('/orders/(\d+)', 'OrderController@getOne');


// Run it!
$router->run();