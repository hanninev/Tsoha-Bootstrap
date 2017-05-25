<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/ostoskori', function() {
    TilausController::ostoskori();
  });

  $routes->get('/tilaus/saapuneet', function() {
    TilausController::tilausSaapuneet();
  });

  $routes->get('/tilaus', function() {
    TilausController::tilausNayta();
  });

  $routes->get('/tilaus/omat', function() {
    TilausController::tilausOmat();
  });

  $routes->get('/tilaus/muokkaa', function() {
    TilausController::tilausMuokkaa();
  });
  
  $routes->get('/tuote', function() {
    TuoteController::tuoteNayta();
  });

  $routes->get('/tuote/muokkaa', function() {
    TuoteController::tuoteMuokkaus();
  });

  $routes->get('/tuote/lisaa', function() {
    TuoteController::tuoteLisays();
  });

  $routes->get('/kayttaja/muokkaa', function() {
    KayttajaController::kayttajaMuokkaa();
  });

  $routes->get('/kategoria/lisaa', function() {
    KategoriaController::kategoriaLisays();
  });

  $routes->get('/kategoria/muokkaa', function() {
    KategoriaController::kategoriaMuokkaa();
  });

  $routes->get('/kategoria/listaa', function() {
    KategoriaController::kategoriaListaa();
  });