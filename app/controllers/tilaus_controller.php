<?php

  class TilausController extends BaseController{

    public static function tilausSaapuneet(){
      View::make('tilaus-saapuneet.html');
    }

    public static function tilausNayta(){
      View::make('tilaus-nayta.html');
    }

    public static function tilausMuokkaa(){
      View::make('tilaus-muokkaa.html');
    }

    public static function tilausOmat(){
      View::make('tilaus-lista.html');
    }

    public static function ostoskori(){
      View::make('ostoskori.html');
    }
  }
