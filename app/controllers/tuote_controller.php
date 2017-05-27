<?php

  class TuoteController extends BaseController{

    public static function index(){
      $tuotteet = Tuote::listaaKaikki();
      View::make('index.html', array('tuotteet' => $tuotteet));
    }

    public static function tuoteNayta($id){
      //toteutus kesken
      View::make('tuote-nayta.html');
    }

    public static function tuoteMuokkaus(){
      View::make('tuote-muokkaa.html');
    }

    public static function tuoteLisays(){
      View::make('tuote-lisaa.html');
    }
  }
