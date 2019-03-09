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

$router->put('/user/{uid}/mail[/{mid}]', 'UserMailController@put');

$router->get('/user/{uid}/mail[/{mid}]', 'UserMailController@get');

$router->delete('/user/{uid}/mail[/{mid}]', 'UserMailController@delete');