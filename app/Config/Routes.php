<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'DocumentsController::index');
// $routes->get('/tabs', 'Home::showTabs');
// $routes->resource('documents');
// $routes->get('/download-document/(:id)', 'DownloadController::download/$1');
// $routes->get('documents/getData', 'DocumentsController::loadData'); // API AJAX

// $routes->get('/', 'HomeController::index');
// $routes->post('/documents/store', 'DocumentsController::store');
// $routes->get('/documents/index', 'DocumentsController::index');
// $routes->get('/excel', 'ExcelController::index');
// $routes->get('/dashboard', 'DashboardController::index');
// $routes->get('/revenue', 'RevenueController::index');
// $routes->get('detail-site', 'RevenueController::detailSite');
// $routes->post('/send-email', 'RevenueController::sendEmail');
// $routes->post('/revenue', 'RevenueController::index');
// $routes->post('/revenue/get-user', 'RevenueController::getUser');
// $routes->post('/revenue/user-store', 'RevenueController::storeUser');
// $routes->post('/get-roles', 'RevenueController::getRoles');
// $routes->post('/revenue-import-excel', 'RevenueController::import');
// $routes->post('/revenue/get-data-site', 'RevenueController::getDataSite');
// $routes->post('/dashboard', 'DashboardController::index');
// $routes->get('/export-excel/(:segment)', 'DashboardController::exportExcel/$1');
// $routes->get('documents', 'DocumentController::index');
// $routes->post('documents/getData', 'DocumentsController::loadData'); // API AJAX
// $routes->post('excel/getData', 'ExcelController::loadData'); // API AJAX
// $routes->post('/import-excel', 'ExcelController::import');

$routes->get('/', 'HomeController::index');

// DocumentsController
$routes->group('documents', function ($routes) {
    $routes->get('index', 'DocumentsController::index');
    $routes->post('store', 'DocumentsController::store');
    $routes->post('getData', 'DocumentsController::loadData');
    $routes->get('download/(:any)', 'DocumentsController::download/$1');
});
// excel controller
$routes->group('excel', function ($routes) {
    $routes->post('import', 'ExcelController::import');
});
// RevenueController
$routes->group('revenue', function ($routes) {
    $routes->get('/', 'RevenueController::index');
    $routes->post('/', 'RevenueController::index');
    $routes->get('detail-site', 'RevenueController::detailSite');
    $routes->post('send-email', 'RevenueController::sendEmail');
    $routes->post('get-user', 'RevenueController::getUser');
    $routes->post('user-store', 'RevenueController::storeUser');
    $routes->post('get-roles', 'RevenueController::getRoles');
    $routes->post('get-data-site', 'RevenueController::getDataSite');
});

// DashboardController
$routes->get('/account', 'DashboardController::account');
$routes->get('/dashboard', 'DashboardController::index');
$routes->post('/dashboard', 'DashboardController::index');
$routes->get('/export-excel/(:segment)', 'DashboardController::exportExcel/$1');
$routes->get('download-document/(:any)', 'DocumentsController::download/$1');

// ExcelController
$routes->group('excel', function ($routes) {
    $routes->get('/', 'ExcelController::index');
    $routes->post('getData', 'ExcelController::loadData'); // API AJAX
    $routes->post('import', 'ExcelController::import');
});
