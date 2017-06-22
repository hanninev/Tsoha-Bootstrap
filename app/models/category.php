<?php

  class Category extends BaseModel{

  	public $id, $name, $description;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT * FROM Category');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$categories = array();

  		foreach ($rows as $row) {
  			$categories[] = new Category(array(
  				'id' => $row['id'],
  				'name' => $row['name'],
  				'description' => $row['description']
  				));
  		}
  		return $categories;
  	}

  	public static function find($id) {
      if ($id == "" || $id == null) {
        return null;
      }

  		$query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$category = new Category(array(
  				'id' => $row['id'],
  				'name' => $row['name'],
  				'description' => $row['description']
  				));

  			return $category;
  		}
  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Category (name, description) VALUES (:name, :description) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

        public function update($id){
      $query = DB::connection()->prepare('UPDATE Category SET name = :name, description = :description) WHERE id = :id');
        $query->execute(array('name' => $this->name, 'description' => $this->description));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
  }
