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


$router->get('list_test','CrudController@index');


$router->group(['prefix' => 'api'], function ($router) {


    // Login 
    $router->post('login', 'AuthController@login');
    $router->post('register','AuthController@register');

    $router->group(['middleware' => 'auth'],function($router){

        // Auths
        // $router->post('register','AuthController@register');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('me', 'AuthController@me');



        // Crud 
        $router->get('list','CrudController@index');
        $router->post('create','CrudController@store');
        $router->get('details','CrudController@details');
        $router->put('update','CrudController@update');
        $router->delete('delete/{id}','CrudController@delete');


    });



});
