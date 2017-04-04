<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/suunnitelmat/tuote_list', function() {
    HelloWorldController::tuote_list();
});
$routes->get('/suunnitelmat/tuote_show', function() {
    HelloWorldController::tuote_show();
});

$routes->get('/suunnitelmat/login', function() {
    HelloWorldController::login();
});

$routes->get('/suunnitelmat/register', function() {
    HelloWorldController::register();
});

$routes->get('/suunnitelmat/mypage', function() {
    HelloWorldController::mypage();
});

$routes->get('/suunnitelmat/tuote_edit', function() {
    HelloWorldController::tuote_edit();
});

$routes->get('/product', function() {
    ProductController::index();
});

$routes->post('/product', function() {
    ProductController::store();
});

$routes->get('/product/new', function() {
    ProductController::create();
});

$routes->get('/product/:id', function($id) {
    ProductController::show($id);
});

$routes->get('/product/:id/edit', function($id) {
    ProductController::edit($id);
});

$routes->post('/product/:id/edit', function($id) {
    ProductController::update($id);
});

$routes->post('/product/:id/destroy', function($id) {
    ProductController::destroy($id);
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

