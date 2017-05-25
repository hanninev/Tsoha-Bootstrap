<?php

  class HelloWorldController extends BaseController{

    public static function index(){
   	  View::make('index.html');
    }

  }
