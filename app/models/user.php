<?php

  class User extends BaseModel{

  	public $id, $forename, $surname, $phonenumber, $email, $password, $address, $zipcode, $postoffice, $role;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
      $this->validators = array('validate_forename', 'validate_surname', 'validate_phonenumber', 'validate_email', 'validate_address', 'validate_zipcode', 'validate_postoffice', 'validate_password');
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
          'id' => $id,
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

    public static function getRole($id) {
      $query = DB::connection()->prepare('SELECT role FROM User1 WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      return $row['role'];
    }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO User1 (forename, surname, phonenumber, email, password, address, zipcode, postoffice, role) VALUES (:forename, :surname, :phonenumber, :email, :password, :address, :zipcode, :postoffice, 2) RETURNING id');
        $query->execute(array('forename' => $this->forename, 'surname' => $this->surname, 'phonenumber' => $this->phonenumber, 'email' => $this->email, 'password' => $this->password, 'address' => $this->address, 'zipcode' => $this->zipcode, 'postoffice' => $this->postoffice));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update(){
      $query = DB::connection()->prepare('UPDATE User1 SET forename = :forename, surname = :surname, phonenumber = :phonenumber, email = :email, address = :address, zipcode = :zipcode, postoffice = :postoffice, password = :password WHERE id = :id');
      $query->execute(array('forename' => $this->forename, 'surname' => $this->surname, 'phonenumber' => $this->phonenumber, 'email' => $this->email, 'address' => $this->address, 'zipcode' => $this->zipcode, 'postoffice' => $this->postoffice, 'id' => $this->id, 'password' => $this->password));
      $row = $query->fetch();
    }

    public function validate_address() {
      return self::validate_string_length($this->address, 'Kotiosoite', 5, 30);
    }

    public function validate_password() {
      return self::validate_string_length($this->password, 'Salasana', 5, 30);
    }

    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM User1 WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();        
      }
}
