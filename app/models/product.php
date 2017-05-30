<?php

  class Product extends BaseModel{

  	public $id, $category_id, $name, $photo, $description, $price, $available;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT * FROM Product');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$products = array();

  		foreach ($rows as $row) {
  			$products[] = new Product(array(
  				'id' => $row['id'],
  				'category_id' => $row['category_id'],
  				'name' => $row['name'],
  				'description' => $row['description'],
  				'price' => $row['price']
  				));
  		}
  		return $products;
  	}

  	public static function show($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Product WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$product = new Product(array(
  				'id' => $row['id'],
  				'category_id' => $row['category_id'],
  				'name' => $row['name'],
  				'description' => $row['description'],
  				'price' => $row['price']
  				));
  			return $product;
  		}
  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Product (name, description, price) VALUES (:name, :description, :price) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'price' => $this->price));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

        public function update($id){
      $query = DB::connection()->prepare('UPDATE Product SET name = :name, description = :description, price = :price) WHERE id = :id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'price' => $this->price));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
  }
