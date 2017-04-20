<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

// Suunnitelmat
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

// Tuotteeseen liittyvät
$routes->get('/product', function() {
    ProductController::listAll();
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


//Käyttäjään liittyvät
$routes->get('/login', function() {
    ConsumerController::login();
});

$routes->post('/login', function() {
    ConsumerController::handle_login();
});

$routes->post('/logout', function() {
    ConsumerController::logout();
});

$routes->get('/register', function() {
    ConsumerController::register();
});

$routes->post('/register', function() {
    ConsumerController::store();
});

$routes->get('/mypage', function() {
    ConsumerController::show();
});

$routes->get('/consumer', function(){
ConsumerController::listAll();
});

$routes->get('/consumer/:id/edit', function($id) {
    ConsumerController::edit($id);
});

$routes->post('/consumer/:id/edit', function($id) {
    ConsumerController::update($id);
});

$routes->post('/consumer/:id/destroy', function($id) {
    ConsumerController::destroy($id);
});    
    
// Kategoriaan liittyvät 
$routes->get('/category', function(){
    CategoryController::listAll();
});

$routes->post('/category', function(){
    CategoryController::store();
});

$routes->get('/category/new', function() {
    CategoryController::create();
});

$routes->get('/category/:id', function($id){
    CategoryController::show($id);
});


// Merkkiin liittyvät 
$routes->get('/brand', function(){
    BrandController::listAll();
});

$routes->post('/brand', function(){
    BrandController::store();
});

$routes->get('/brand/new', function() {
    BrandController::create();
});

$routes->get('/brand/:id', function($id){
    BrandController::show($id);
});