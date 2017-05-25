<?php

  class TuoteController extends BaseController{

    public static function tuoteNayta(){
      View::make('tuote-nayta.html');
    }

    public static function tuoteMuokkaus(){
      View::make('tuote-muokkaa.html');
    }

    public static function tuoteLisays(){
      View::make('tuote-lisaa.html');
    }
  }
