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

$routes->get('/suunnitelmat/tuote_edit', function() {
    HelloWorldController::tuote_edit();
});

$routes->get('/product', function(){
  ProductController::index();
});

$routes->post('/product', function(){
  ProductController::store();
});

$routes->get('/product/new', function(){
  ProductController::create();
});

$routes->get('/product/:id', function($id){
  ProductController::show($id);
});

