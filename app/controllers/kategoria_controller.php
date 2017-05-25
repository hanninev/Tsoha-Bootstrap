<?php

  class KategoriaController extends BaseController{

    public static function kategoriaListaa(){
      View::make('kategoria-listaa.html');
    }

    public static function kategoriaMuokkaa(){
      View::make('kategoria-muokkaa.html');
    }

    public static function kategoriaLisays(){
      View::make('kategoria-lisaa.html');
    }
  }