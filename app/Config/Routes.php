<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('login', 'Auth::login');
// $routes->post('auth/doLogin', 'Auth::doLogin');
// $routes->get('logout', 'Auth::logout');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('categories', 'Category::index', ['filter' => 'auth']);
$routes->get('categories/create', 'Category::create', ['filter' => 'auth']);
$routes->post('categories/store', 'Category::store', ['filter' => 'auth']);
$routes->get('categories/edit/(:num)', 'Category::edit/$1', ['filter' => 'auth']);
$routes->post('categories/update/(:num)', 'Category::update/$1', ['filter' => 'auth']);
$routes->get('categories/delete/(:num)', 'Category::delete/$1', ['filter' => 'auth']);

$routes->get('products', 'Product::index', ['filter' => 'auth']);
$routes->get('products/create', 'Product::create', ['filter' => 'auth']);
$routes->post('products/store', 'Product::store', ['filter' => 'auth']);
$routes->get('products/edit/(:num)', 'Product::edit/$1', ['filter' => 'auth']);
$routes->post('products/update/(:num)', 'Product::update/$1', ['filter' => 'auth']);
$routes->get('products/delete/(:num)', 'Product::delete/$1', ['filter' => 'auth']);

$routes->get('users', 'User::index', ['filter' => 'auth']);
$routes->get('users/create', 'User::create', ['filter' => 'auth']);
$routes->post('users/store', 'User::store', ['filter' => 'auth']);
$routes->get('users/edit/(:num)', 'User::edit/$1', ['filter' => 'auth']);
$routes->post('users/update/(:num)', 'User::update/$1', ['filter' => 'auth']);
$routes->get('users/delete/(:num)', 'User::delete/$1', ['filter' => 'auth']);

$routes->get('export/products', 'ExportController::exportProducts', ['filter' => 'auth']);
$routes->get('export/products-pdf', 'ExportController::exportProductsPdf', ['filter' => 'auth']);

$routes->post('clientes/buscar-dni', 'ClientesController::buscarPorDocumento');
$routes->post('compras/registrar', 'ComprasController::registrar');

$routes->post('clientes/guardar', 'ClientesController::guardar');

// Endpoint para obtener token CSRF via AJAX
$routes->get('csrf/token', 'CsrfController::token');

$routes->get('compras', 'ComprasController::index');
$routes->get('clientes', 'ClientesController::index');

$routes->get('compras/ticket/(:num)', 'ComprasController::ticket/$1');
$routes->get('compras/ticket-cliente/(:num)', 'ComprasController::ticketCliente/$1');

$routes->get('clientes/(:num)/puntos', 'ClientesController::puntos/$1');

$routes->get('clientes/(:num)/edit', 'ClientesController::edit/$1');
$routes->post('clientes/(:num)/update', 'ClientesController::update/$1');
$routes->post('clientes/(:num)/delete', 'ClientesController::delete/$1');



