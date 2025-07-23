<?php

global $router;

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/register', 'AuthController@showRegisterForm');

$router->get('/test-db', 'AuthController@testDb');
$router->get('/register', 'AuthController@showRegisterForm');
$router->post('/register', 'AuthController@register');


$router->get('/dashboard', 'DashboardController@index');
