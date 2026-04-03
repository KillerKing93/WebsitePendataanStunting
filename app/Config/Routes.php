<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::index');
$routes->post('login/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Children CRUD
    $routes->get('children', 'Admin\Children::index');
    $routes->get('children/create', 'Admin\Children::create');
    $routes->post('children/store', 'Admin\Children::store');
});

// API Routes
$routes->get('api/stunting-map', 'Api::stuntingMap');
