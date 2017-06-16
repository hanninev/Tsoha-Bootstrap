<?php

  class Order extends BaseModel{

  	public $id, $user, $status, $forename, $surname, $phonenumber, $email, $delivery_address, $zipcode, $postoffice, $time;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
      $this->validators = array('validate_forename', 'validate_surname', 'validate_phonenumber', 'validate_email', 'validate_delivery_address', 'validate_zipcode', 'validate_postoffice');
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT * FROM Order');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$orders = array();

  		foreach ($rows as $row) {
  			$orders[] = new Order(array(
  				'id' => $row['id'],
  				'user' => User::find($row['user1_id']),
  				'status' => $row['status1_id'],
  				'forename' => $row['forename'],
  				'surname' => $row['surname'],
          'phonenumber' => $row['phonenumber'],
          'email' => $row['email'],
          'delivery_address' => $row['delivery_address'],
          'zipcode' => $row['zipcode'],
          'postoffice' => $row['postoffice'],
          'time' => $row['time']
  				));
  		}
  		return $orders;
  	}

  	public static function show($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Order1 WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$order = new Order(array(
  				'id' => $row['id'],
  				'user' => User::find($row['user1_id']),
  				'status' => $row['status_id'],
  				'forename' => $row['forename'],
  				'surname' => $row['surname'],
          'phonenumber' => $row['phonenumber'],
          'email' => $row['email'],
          'delivery_address' => $row['delivery_address'],
          'zipcode' => $row['zipcode'],
          'postoffice' => $row['postoffice'],
          'time' => $row['time']
  				));

  			return $order;
  		}
  		return null;
  	}

    public function save() {
      if ($this->user) {
        self::saveWithUser();
      } else {
        self::saveWithoutUser();
      }
    }

    public function saveWithUser(){
      $query = DB::connection()->prepare('INSERT INTO Order1 (user1_id, status_id, forename, surname, phonenumber, email, delivery_address, zipcode, postoffice) VALUES (:user, :status, :forename, :surname, :phonenumber, :email, :delivery_address, :zipcode, :postoffice) RETURNING id');
        $query->execute(array('user' => $this->user->id, 'status' => $this->status, 'forename' => $this->forename, 'surname' => $this->surname, 'phonenumber' => $this->phonenumber, 'email' => $this->email, 'delivery_address' => $this->delivery_address, 'zipcode' => $this->zipcode, 'postoffice' => $this->postoffice));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function saveWithoutUser(){
      $query = DB::connection()->prepare('INSERT INTO Order1 (status_id, forename, surname, phonenumber, email, delivery_address, zipcode, postoffice) VALUES (:status, :forename, :surname, :phonenumber, :email, :delivery_address, :zipcode, :postoffice) RETURNING id');
        $query->execute(array('status' => $this->status, 'forename' => $this->forename, 'surname' => $this->surname, 'phonenumber' => $this->phonenumber, 'email' => $this->email, 'delivery_address' => $this->delivery_address, 'zipcode' => $this->zipcode, 'postoffice' => $this->postoffice));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validate_delivery_address() {
    return self::validate_string_length($this->delivery_address, 'Toimitusosoite', 20);
    }

  }
