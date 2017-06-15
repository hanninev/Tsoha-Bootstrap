<?php

  class Order extends BaseModel{

  	public $id, $user, $status, $forename, $surname, $phonenumber, $email, $delivery_address, $zipcode, $postoffice, $time;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
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
  		$query = DB::connection()->prepare('SELECT * FROM Order WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$order = new Order(array(
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

  			return $order;
  		}
  		return null;
  	}

  }
