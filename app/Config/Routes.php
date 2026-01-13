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

// Página de inicio (bienvenida)
$routes->get('/', 'InicioController::index', ['filter' => 'auth']);
$routes->get('inicio', 'InicioController::index', ['filter' => 'auth']);

$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('dashboard/puntos-por-dia', 'DashboardController::puntosPorDia', ['filter' => 'auth']);
$routes->get('dashboard/compras-por-dia', 'DashboardController::comprasPorDia', ['filter' => 'auth']);
$routes->get('dashboard/top-clientes', 'DashboardController::topClientes', ['filter' => 'auth']);
$routes->get('dashboard/puntos-por-mes', 'DashboardController::puntosPorMes', ['filter' => 'auth']);
$routes->get('dashboard/compras-por-mes', 'DashboardController::comprasPorMes', ['filter' => 'auth']);
// Nuevos endpoints para gráficos adicionales
$routes->get('dashboard/distribucion-tipos', 'DashboardController::distribucionTiposPuntos', ['filter' => 'auth']);
$routes->get('dashboard/canjes-por-dia', 'DashboardController::canjesPorDia', ['filter' => 'auth']);
$routes->get('dashboard/canjes-por-mes', 'DashboardController::canjesPorMes', ['filter' => 'auth']);
$routes->get('dashboard/comparativa-puntos', 'DashboardController::comparativaPuntosGanadosVsCanjeados', ['filter' => 'auth']);
$routes->get('dashboard/estadisticas-campanias', 'DashboardController::estadisticasCampanias', ['filter' => 'auth']);
$routes->get('dashboard/monto-compras-por-dia', 'DashboardController::montoComprasPorDia', ['filter' => 'auth']);
$routes->get('dashboard/monto-compras-por-mes', 'DashboardController::montoComprasPorMes', ['filter' => 'auth']);
$routes->get('dashboard/actividad-por-hora', 'DashboardController::actividadPorHora', ['filter' => 'auth']);
$routes->get('dashboard/kpis-resumen', 'DashboardController::kpisResumen', ['filter' => 'auth']);

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

$routes->post('clientes/buscar-dni', 'ClientesController::buscarPorDocumento', ['filter' => 'auth']);
$routes->post('compras/registrar', 'ComprasController::registrar', ['filter' => 'auth']);

$routes->post('clientes/guardar', 'ClientesController::guardar', ['filter' => 'auth']);

// Endpoint para obtener token CSRF via AJAX
$routes->get('csrf/token', 'CsrfController::token', ['filter' => 'auth']);

$routes->get('compras', 'ComprasController::index', ['filter' => 'auth']);
$routes->get('clientes', 'ClientesController::index', ['filter' => 'auth']);

$routes->get('compras/ticket/(:num)', 'ComprasController::ticket/$1', ['filter' => 'auth']);
$routes->get('compras/ticket-cliente/(:num)', 'ComprasController::ticketCliente/$1', ['filter' => 'auth']);

$routes->get('clientes/(:num)/puntos', 'ClientesController::puntos/$1', ['filter' => 'auth']);

$routes->get('clientes/(:num)/edit', 'ClientesController::edit/$1', ['filter' => 'auth']);
$routes->post('clientes/(:num)/update', 'ClientesController::update/$1', ['filter' => 'auth']);
$routes->post('clientes/(:num)/delete', 'ClientesController::delete/$1', ['filter' => 'auth']);

// Rutas del módulo Perfil (accesible para todos los usuarios autenticados)
$routes->get('perfil', 'Profile::index', ['filter' => 'auth']);
$routes->post('perfil/update', 'Profile::update', ['filter' => 'auth']);
$routes->post('perfil/avatar', 'Profile::uploadAvatar', ['filter' => 'auth']);
$routes->post('perfil/avatar/delete', 'Profile::deleteAvatar', ['filter' => 'auth']);
$routes->post('perfil/password', 'Profile::changePassword', ['filter' => 'auth']);

// Ruta para servir archivos de uploads (avatars)
$routes->get('uploads/avatars/(:any)', 'Uploads::avatar/$1');

// Rutas del módulo Campañas (solo administradores)
$routes->get('campanias', 'Campanias::index', ['filter' => 'auth']);
$routes->get('campanias/crear', 'Campanias::create', ['filter' => 'auth']);
$routes->post('campanias/store', 'Campanias::store', ['filter' => 'auth']);
$routes->get('campanias/editar/(:num)', 'Campanias::edit/$1', ['filter' => 'auth']);
$routes->post('campanias/update/(:num)', 'Campanias::update/$1', ['filter' => 'auth']);
$routes->post('campanias/cerrar/(:num)', 'Campanias::cerrar/$1', ['filter' => 'auth']);
$routes->get('campanias/gestionar-puntos/(:num)', 'Campanias::gestionarPuntos/$1', ['filter' => 'auth']);
$routes->post('campanias/migrar-puntos', 'Campanias::migrarPuntosCliente', ['filter' => 'auth']);

// Rutas del módulo Canjes (todos los usuarios autenticados)
$routes->get('canjes', 'Canjes::index', ['filter' => 'auth']);
$routes->post('canjes/buscar-cliente', 'Canjes::buscarCliente', ['filter' => 'auth']);
$routes->post('canjes/registrar', 'Canjes::registrar', ['filter' => 'auth']);
$routes->post('canjes/ajustar', 'Canjes::ajustar', ['filter' => 'auth']);
$routes->get('canjes/ticket/(:num)', 'Canjes::ticket/$1', ['filter' => 'auth']);
$routes->get('canjes/historial/(:num)', 'Canjes::historial/$1', ['filter' => 'auth']);



