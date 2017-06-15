<?php

  $routes->get('/', function() {
    ProductController::index();
  });

  $routes->get('/ostoskori', function() {
    OrderController::cart();
  });

  $routes->get('/tilaus/saapuneet', function() {
    OrderController::inbox();
  });

  $routes->get('/tilaus', function() {
    OrderController::show();
  });

  $routes->get('/tilaus/omat', function() {
    OrderController::myOrders();
  });

  $routes->get('/tilaus/muokkaa', function() {
    OrderController::edit();
  });

  $routes->get('/tuote', function() {
    ProductController::index();
  });

  $routes->post('/tuote', function() {
    ProductController::store();
  });

  $routes->get('/tuote/uusi', function() {
    ProductController::create();
  });
  
  $routes->get('/tuote/:id', function($id) {
    ProductController::show($id);
  });

  $routes->get('/tuote/:id/muokkaa', function($id) {
    ProductController::edit($id);
  });

  $routes->post('/tuote/:id/muokkaa', function($id) {
    ProductController::update($id);
  });

  $routes->post('/tuote/:id/poista', function($id){
  ProductController::destroy($id);
  });

  $routes->post('/tuote/:id/lisaaOstoskoriin', function($id){
  ProductController::addToCart($id);
  });

  $routes->post('/tuote/:id/poistaOstoskorista', function($id){
  OrderController::removeFromCart($id);
  });

  $routes->post('/ostoskori/tyhjenna', function() {
  OrderController::clearCart();
  });

  $routes->post('/tuote/:id/lisaa', function($id){
  ProductInstanceController::store($id);
  });

  $routes->post('/tuote/:id/poistalukumaara', function($id){
  ProductInstanceController::destroy($id);
  });

  $routes->get('/kayttaja/muokkaa', function() {
    UserController::edit();
  });

  $routes->get('/login', function() {
  UserController::login();
  });

  $routes->post('/login', function() {
  UserController::handle_login();
  });

  $routes->post('/logout', function(){
  UserController::logout();
  });

  $routes->get('/kategoria/lisaa', function() {
    CategoryController::add();
  });

  $routes->get('/kategoria/muokkaa', function() {
    CategoryController::edit();
  });

  $routes->get('/kategoria/listaa', function() {
    CategoryController::list();
  });