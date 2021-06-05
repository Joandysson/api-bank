<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// User
$router->get('/users', 'UserController@index');
$router->get('/user/{id}', 'UserController@show');
$router->post('/user', 'UserController@store');
$router->put('/user/{id}', 'UserController@update');
$router->delete('/user/{id}', 'UserController@delete');
// Account
$router->get('/accounts', 'AccountController@index');
$router->get('/account/{id}', 'AccountController@show');
$router->get('/accountbyuser/{id}', 'AccountController@showByUser');
$router->post('/account', 'AccountController@store');
$router->post('/transfer', 'AccountController@transfer');
$router->post('/deposit', 'AccountController@deposit');
$router->post('/withdraw', 'AccountController@withdraw');
$router->delete('/account/{id}', 'AccountController@delete');
// Transaction
$router->get('/transactions', 'AccountController@index');
