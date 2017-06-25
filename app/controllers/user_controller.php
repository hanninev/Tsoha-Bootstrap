<?php

class UserController extends BaseController
{
    
    public static function login()
    {
        View::make('login.html');
    }
    
    public static function handle_login()
    {
        $params = $_POST;
        
        $user = User::authenticate($params['username'], $params['password']);
        
        if (!$user) {
            View::make('login.html', array(
                'errors' => array(
                    'Väärä käyttäjätunnus tai salasana!'
                ),
                'username' => $params['username']
            ));
        } else {
            $_SESSION['user'] = $user->id;
            
            Redirect::to('/', array(
                'message' => 'Tervetuloa takaisin ' . $user->forename . '!'
            ));
        }
    }
    
    public static function login_in_cart()
    {
        $params = $_POST;
        
        $user = User::authenticate($params['username'], $params['password']);
        
        if (!$user) {
            View::make('cart.html', array(
                'errors' => array(
                    'Väärä käyttäjätunnus tai salasana!'
                ),
                'username' => $params['username']
            ));
        } else {
            $_SESSION['user'] = $user->id;
            
            Redirect::to('/ostoskori', array(
                'message' => 'Hei ' . $user->forename . ', olet nyt kirjautuneena. Tarkistathan vielä, että toimitustiedot ovat ajantasalla!'
            ));
        }
    }
    
    public static function logout()
    {
        $_SESSION['user'] = null;
        $_SESSION['cart'] = null;
        Redirect::to('/login', array(
            'message' => 'Olet kirjautunut ulos!'
        ));
    }
    
    
    public static function store()
    {
        $params = $_POST;
        
        $attributes = array(
            'forename' => $params['forename'],
            'surname' => $params['surname'],
            'phonenumber' => $params['phonenumber'],
            'email' => $params['email'],
            'password' => $params['password'],
            'address' => $params['address'],
            'zipcode' => $params['zipcode'],
            'postoffice' => $params['postoffice']
        );
        
        $user = new User($attributes);
        
        $errors = $user->errors();
        
        if (count($errors) == 0) {
            $user->save();
            
            Redirect::to('/', array(
                'message' => 'Tunnuksesi on luotu onnistuneesti.'
            ));
        } else {
            View::make('user/registration.html', array(
                'errors' => $errors,
                'attributes' => $attributes
            ));
        }
    }
    
    public static function create()
    {
        View::make('user/registration.html', array());
    }
    
    public static function show()
    {
        self::check_logged_in();
        View::make('user/show.html', array());
    }
    
    public static function edit()
    {
        self::check_logged_in();
        View::make('user/edit.html', array(
            'attributes' => self::get_user_logged_in()
        ));
    }
    
    public static function update()
    {
        self::check_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'id' => self::get_user_logged_in()->id,
            'forename' => $params['forename'],
            'surname' => $params['surname'],
            'phonenumber' => $params['phonenumber'],
            'email' => $params['email'],
            'password' => $params['password'],
            'address' => $params['address'],
            'zipcode' => $params['zipcode'],
            'postoffice' => $params['postoffice']
        );
        
        $user   = new User($attributes);
        $errors = $user->errors();
        
        if (count($errors) > 0) {
            View::make('user/edit.html', array(
                'errors' => $errors,
                'attributes' => $attributes
            ));
        } else {
            $user->update();
            Redirect::to('/kayttaja', array(
                'message' => 'Tietoja on muokattu onnistuneesti.'
            ));
        }
    }
    
    public static function destroy()
    {
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $user->destroy();
        self::logout();
    }
    
}