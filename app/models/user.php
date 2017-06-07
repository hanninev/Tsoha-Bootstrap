<?php

  class User extends BaseModel{

  	public $id, $forename, $surname, $phonenumber, $email, $password, $address, $zipcode, $postoffice;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

    public static function authenticate($email, $password) {
      $query = DB::connection()->prepare('SELECT * FROM User1 WHERE email = :email AND password = :password LIMIT 1');
      $query->execute(array('email' => $email, 'password' => $password));
      $row = $query->fetch();

      if ($row) {
        $user = new User(array(
          'id' => $row['id'],
          'forename' => $row['forename'],
          'surname' => $row['surname'],
          'phonenumber' => $row['phonenumber'],
          'address' => $row['address'],
          'zipcode' => $row['zipcode'],
          'postoffice' => $row['postoffice']
          ));

        return $user;
      }
      return null;
    }

    public static function find($id) {
      $query = DB::connection()->prepare('SELECT * FROM User1 WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if ($row) {
        $user = new User(array(
          'forename' => $row['forename'],
          'surname' => $row['surname'],
          'phonenumber' => $row['phonenumber'],
          'email' => $row['email'],
          'password' => $row['password'],
          'address' => $row['address'],
          'zipcode' => $row['zipcode'],
          'postoffice' => $row['postoffice']
          ));

        return $user;
      }
      return null;
    }

  }
