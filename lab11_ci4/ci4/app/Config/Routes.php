<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route utama dan Artikel
$routes->get('/', 'Home::index');
$routes->get('/artikel', 'Artikel::index'); 

// Route User Login/Logout (Praktikum sebelumnya)
$routes->get('user/login', 'UserController::index');
$routes->post('user/login', 'UserController::auth');
$routes->get('user/logout', 'UserController::logout');

// Route Halaman Statis
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');

// Route CRUD Artikel (Biasa - Bukan API)
$routes->get('/artikel/detail/(:segment)', 'Artikel::detail/$1');
$routes->get('/artikel/tambah', 'Artikel::tambah');
$routes->post('/artikel/simpan', 'Artikel::simpan');
$routes->get('/artikel/edit/(:num)', 'Artikel::edit/$1');
$routes->post('/artikel/update/(:num)', 'Artikel::update/$1');
$routes->get('/artikel/delete/(:num)', 'Artikel::delete/$1');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

// Route Admin MVC (Dengan Filter Auth Biasa)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// Route Praktikum 8 (AJAX MVC)
$routes->get('/ajax', 'AjaxController::index');
$routes->get('/ajax/getData', 'AjaxController::getData');
$routes->delete('/ajax/delete/(:num)', 'AjaxController::delete/$1');
$routes->post('/ajax/simpan', 'AjaxController::simpan');



// 1. Route API Login
$routes->post('api/login', 'Api\Auth::login');
$routes->options('api/login', 'Api\Auth::login');

// 2. Route API Tampil Data (Bebas diakses publik)
$routes->get('post', 'Post::index');
$routes->get('post/(:segment)', 'Post::show/$1');

// 3. Route API Manajemen Data (Wajib bawa Token / Filter apiauth)
$routes->post('post', 'Post::create', ['filter' => 'apiauth']);
$routes->put('post/(:segment)', 'Post::update/$1', ['filter' => 'apiauth']);
$routes->delete('post/(:segment)', 'Post::delete/$1', ['filter' => 'apiauth']);

// 4. Bypass preflight OPTIONS untuk CORS
$routes->options('post', 'Post::index');
$routes->options('post/(:any)', 'Post::index');