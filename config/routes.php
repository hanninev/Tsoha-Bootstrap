<?php

  $routes->get('/', function() {
    ProductController::index();
  });

  $routes->get('/ostoskori', function() {
    OrderController::cart();
  });

  $routes->get('/tilaukset', function() {
    OrderController::arrivedOrders();
  });

  $routes->get('/tilaus/:id', function($id) {
    OrderController::show($id);
  });

  $routes->post('/tilaukset/:id/toimitetuksi', function($id) {
    OrderController::editStatus($id, 2);
  });

  $routes->post('/tilaukset/:id/hylkaa', function($id) {
    OrderController::editStatus($id, 3);
  });

  $routes->post('/tilaukset/:id/kasittelyyn', function($id) {
    OrderController::editStatus($id, 1);
  });

  $routes->get('/tilaukset/omat', function() {
    OrderController::myOrders();
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
  OrderController::addToCart($id);
  });

  $routes->post('/tuote/:id/poistaOstoskorista', function($id){
  OrderController::removeFromCart($id);
  });

  $routes->post('/ostoskori/tyhjenna', function() {
  OrderController::clearCart();
  });

  $routes->post('/tilaus', function() {
  OrderController::store();
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

  $routes->get('/kayttaja', function() {
  UserController::show();
  });

  $routes->post('/kayttaja/muokkaa/laheta', function() {
  UserController::update();
  });

  $routes->post('/kayttaja/poista', function() {
  UserController::destroy();
  });

  $routes->get('/login', function() {
  UserController::login();
  });

  $routes->post('/login', function() {
  UserController::handle_login();
  });

  $routes->post('/ostoskori/login', function() {
  UserController::login_in_cart();
  });

  $routes->post('/logout', function(){
  UserController::logout();
  });

  $routes->post('/kayttaja/uusi', function() {
    UserController::store();
  });

  $routes->get('/rekisteroidy', function() {
    UserController::create();
  });

  $routes->get('/kategoria/lisaa', function() {
    CategoryController::create();
  });


  $routes->post('/kategoria/lisaa/laheta', function() {
    CategoryController::store();
  });

  $routes->get('/kategoria/:id/muokkaa', function($id) {
    CategoryController::edit($id);
  });

  $routes->post('/kategoria/:id/muokkaa/laheta', function($id) {
    CategoryController::update($id);
  });

  $routes->get('/kategoriat', function() {
    CategoryController::list();
  });

  $routes->post('/kategoria/:id/poista', function($id) {
    CategoryController::destroy($id);
  });