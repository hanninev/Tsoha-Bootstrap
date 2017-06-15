<?php

  class UserController extends BaseController{

    public static function edit(){
   	  View::make('user/edit.html');
    }

    public static function login(){
      View::make('login.html');
    }
    
    public static function handle_login(){
    $params = $_POST;

    $user = User::authenticate($params['username'], $params['password']);

    if(!$user){
      View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
    }else{
      $_SESSION['user'] = $user->id;

      Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->forename . '!'));
    }
  }

      public static function login_in_cart(){
    $params = $_POST;

    $user = User::authenticate($params['username'], $params['password']);

    if(!$user){
      View::make('cart.html', array('errors' => array('Väärä käyttäjätunnus tai salasana!'), 'username' => $params['username']));
    }else{
      $_SESSION['user'] = $user->id;

      Redirect::to('/ostoskori', array('message' => 'Hei ' . $user->forename . ', olet nyt kirjautuneena. Tarkistathan vielä, että toimitustiedot ovat ajantasalla!'));
    }
  }

  public static function logout(){
    $_SESSION['user'] = null;
    $_SESSION['cart'] = null;
    Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
  }


  }
