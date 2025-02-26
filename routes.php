<?php
/**
 * Application Route Definitions
 *
 * Filename:        routes.php
 * Location:        /
 * Project:         LAS-mvc-jokes
 * Date Created:    06/09/2024
 *
 * Author:          Luis Alvarez  <20114831@tafe.wa.edu.au>
 * Author:          Luis Alvarez  <20114831@tafe.wa.edu.au>
 */

/* ----------------------------------------------------------------------------
 * Static Page Endpoints
 */
$router->get('/', 'StaticPageController@index');
$router->get('about', 'StaticPageController@about');
$router->get('/home', 'StaticPageController@home', ['auth']);

/* ----------------------------------------------------------------------------
 * Jokes Endpoints
 */


$router->get('/jokes/search', 'JokeController@search');
$router->get('/joke/search', 'JokeController@search');


$router->get('/jokes/create', 'JokeController@create', ['auth']);
$router->get('/jokes/edit/{id}', 'JokeController@edit', ['auth']);
$router->get('/jokes/{id}', 'JokeController@show');

$router->get('/jokes', 'JokeController@index', ['auth']);

$router->post('/jokes', 'JokeController@store', ['auth']);
$router->put('/jokes/{id}', 'JokeController@update', ['auth']);
$router->delete('/jokes/{id}', 'JokeController@destroy', ['auth']);


/* ----------------------------------------------------------------------------
 * Categories Endpoints
 */



/* ----------------------------------------------------------------------------
 * Users Endpoints
 */
        //    $uri,     $controller,                   $middleware
//$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create', ['auth']);
$router->get('/users/edit/{id}', 'UserController@edit', ['auth']);
$router->get('/users/search', 'UserController@search');
$router->get('/users/{id}', 'UserController@show');

$router->get('/users', 'UserController@index', ['auth']);

$router->post('/users', 'UserController@store', ['auth']);
$router->put('/users/{id}', 'UserController@update', ['auth']);
$router->delete('/users/{id}', 'UserController@destroy', ['auth']);


/* ----------------------------------------------------------------------------
 * User Authentication Endpoints
 */
$router->get('/auth/register', 'UserAuthController@create', ['guest']);
$router->get('/auth/login', 'UserAuthController@login', ['guest']);

$router->post('/auth/register', 'UserAuthController@store', ['guest']);
$router->post('/auth/logout', 'UserAuthController@logout', ['auth']);
$router->post('/auth/login', 'UserAuthController@authenticate', ['guest']);


$router->get('/auth/password', 'CreatePasswordController@index', ['guest']);
$router->post('/auth/password', 'CreatePasswordController@index', ['guest']);