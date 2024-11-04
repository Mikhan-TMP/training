<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingPage::index'); //set default
$routes->get('/userdashboard', 'APIController::index');
$routes->get('/signup', 'SignupController::index');
$routes->match(['get', 'post'], 'SignupController/store', 'SignupController::store');
$routes->match(['get', 'post'], 'SigninController/loginAuth', 'SigninController::loginAuth');
$routes->get('/signin', 'SigninController::index');
$routes->get('/logout', 'SigninController::logout');
$routes->post('/userdashboard/changepassword', 'APIController::changePassword');

$routes->post('/userdashboard/editprofile', 'APIController::editProfile');

$routes->get('/verify/(:any)', 'SignupController::verify/$1');

// $routes->get('/userdashboard/menu', 'APIController::getMenu');
// $routes->post('userdashboard/menu', 'APIController::addMenu');
