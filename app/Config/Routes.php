<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'DocumentsController::index');
$routes->get('/', 'HomeController::index');
// $routes->get('/tabs', 'Home::showTabs');
// $routes->resource('documents');
$routes->post('/documents/store', 'DocumentsController::store');
$routes->get('/documents/index', 'DocumentsController::index');
$routes->get('/excel', 'ExcelController::index');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/revenue', 'RevenueController::index');
$routes->get('detail-site', 'RevenueController::detailSite');
$routes->post('/send-email', 'RevenueController::sendEmail');
$routes->post('/revenue', 'RevenueController::index');
$routes->post('/revenue/get-user', 'RevenueController::getUser');
$routes->post('/revenue/user-store', 'RevenueController::storeUser');
$routes->post('/get-roles', 'RevenueController::getRoles');
$routes->post('/revenue-import-excel', 'RevenueController::import');
$routes->post('/revenue/get-data-site', 'RevenueController::getDataSite');
$routes->post('/dashboard', 'DashboardController::index');
$routes->get('/export-excel/(:segment)', 'DashboardController::exportExcel/$1');
// $routes->get('/download-document/(:id)', 'DownloadController::download/$1');
$routes->get('download-document/(:any)', 'DocumentsController::download/$1');
$routes->get('documents', 'DocumentController::index');
// $routes->get('documents/getData', 'DocumentsController::loadData'); // API AJAX
$routes->post('documents/getData', 'DocumentsController::loadData'); // API AJAX
$routes->post('excel/getData', 'ExcelController::loadData'); // API AJAX
$routes->post('/import-excel', 'ExcelController::import');
