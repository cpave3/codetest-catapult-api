<?php

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

// JWT login
$router->post('auth/login', ['uses' => 'AuthController@authenticate']);

// V1 Routes
$router->group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'], function () use ($router) {

    // User Routes
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/',  ['uses' => 'UserController@index']);
        $router->get('/{id}', ['uses' => 'UserController@read']);
        $router->post('/', ['uses' => 'UserController@create']);
        $router->delete('/{id}', ['uses' => 'UserController@delete']);
        $router->put('/{id}', ['uses' => 'UserController@update']);
    });


});
