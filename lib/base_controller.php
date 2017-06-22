<?php

  class BaseController{

    public static function get_user_logged_in(){
    
    if(isset($_SESSION['user'])){
      $user_id = $_SESSION['user'];
      $user = User::find($user_id);

      return $user;
    }

    return null;
  }

    public static function check_logged_in(){
      if(!isset($_SESSION['user'])) {
      Redirect::to('/login', array('errors' => array('Kirjaudu ensin sisään!')));
      }
    }

    public static function admin(){
      if(isset($_SESSION['user'])) {
        if (User::getRole($_SESSION['user']) == 1) {
          return true;
        } 
      }
      return false;
      }

    public static function user(){
      if(isset($_SESSION['user'])) {
        if (User::getRole($_SESSION['user']) == 2) {
          return true;
        } 
      }
      return false;
      }

    public static function check_admin(){
      if((!isset($_SESSION['user'])) || (isset($_SESSION['user']) && (User::getRole($_SESSION['user']) != 1))) {
      Redirect::to('/login', array('errors' => array('Vain ylläpito voi tarkastella tätä sivua!')));
    }
  }

  }
