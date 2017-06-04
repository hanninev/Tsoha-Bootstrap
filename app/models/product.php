<?php

  class Product extends BaseModel{

  	public $id, $category, $name, $photo, $description, $price, $available, $validators;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
      $this->validators = array('validate_name');
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT Product.id, Product.category_id, Product.name, Product.description, Product.price, Product.available FROM Product LEFT JOIN Category ON Product.category_id = Category.id');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$products = array();

  		foreach ($rows as $row) {
  			$products[] = new Product(array(
  				'id' => $row['id'],
  				'category' => Category::show($row['category_id']),
  				'name' => $row['name'],
  				'description' => $row['description'],
  				'price' => $row['price'],
          'available' => $row['available']
  				));
  		}
  		return $products;
  	}

  	public static function show($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Product WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

      $ProductInstanceCount = DB::connection()->prepare('SELECT Count(id) AS count FROM ProductInstance WHERE Product_id = :id');
      $ProductInstanceCount->execute(array('id' => $id));
      $row2 = $ProductInstanceCount->fetch();

  		if ($row) {
  			$product = new Product(array(
  				'id' => $row['id'],
          'category' => Category::show($row['category_id']),
  				'name' => $row['name'],
  				'description' => $row['description'],
  				'price' => $row['price'],
          'available' => $row['available']
  				));

  			return $product;
  		}
  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Product (name, category_id, description, price, available) VALUES (:name, :category_id, :description, :price, :available) RETURNING id');
        $query->execute(array('name' => $this->name, 'category_id' => $this->category, 'description' => $this->description, 'price' => $this->price, 'available' => $this->available));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

        public function update(){
      $query = DB::connection()->prepare('UPDATE Product SET name = :name, category_id = :category_id, description = :description, price = :price, available = :available WHERE id = :id');
        $query->execute(array('name' => $this->name, 'category_id' => $this->category, 'description' => $this->description, 'price' => $this->price, 'available' => $this->available, 'id' => $this->id));
        $row = $query->fetch();
    }

    public function validate_name() {
      $errors = array();
      if($this->name == '' || $this->name == null) {
        $errors[] = 'Nimi ei saa olla tyhjä!';
      }
      return $errors;
    }

    public function destroy(){
      $query = DB::connection()->prepare('DELETE FROM Product WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }
  }
