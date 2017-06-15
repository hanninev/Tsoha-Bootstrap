<?php

  class Status extends BaseModel{

  	public $id, $name;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT * FROM Status');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$orders = array();

  		foreach ($rows as $row) {
  			$statuses[] = new Order(array(
  				'id' => $row['id'],
          'name' => $row['name']
  				));
  		}
  		return $statuses;
  	}

  	public static function show($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Status WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$status = new Status(array(
  				'id' => $row['id'],
          'name' => $row['name']
  				));

  			return $status;
  		}
  		return null;
  	}

  }
