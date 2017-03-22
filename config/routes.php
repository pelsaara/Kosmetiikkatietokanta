<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/tuote', function() {
    HelloWorldController::tuote_list();
});
$routes->get('/tuote/1', function() {
    HelloWorldController::tuote_show();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/tuote/1/edit', function() {
    HelloWorldController::tuote_edit();
});