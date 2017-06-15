<?php

  class Product extends BaseModel{

  	public $id, $category, $name, $description, $price, $count, $available, $validators;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
      $this->validators = array('validate_name', 'validate_price', 'validate_description', 'validate_category');
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT Product.id, Product.category_id, Product.name, Product.description, Product.price, Product.available FROM Product LEFT JOIN Category ON Product.category_id = Category.id WHERE Product.available AND Product.id IN (SELECT Product_id FROM ProductInstance WHERE Order1_id IS NULL)');
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
          'available' => $row['available'],
          'count' => ProductInstance::howManyLeft($row['id'])
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
          'category' => Category::show($row['category_id']),
  				'name' => $row['name'],
  				'description' => $row['description'],
  				'price' => $row['price'],
          'available' => $row['available'],
          'count' => ProductInstance::howManyLeft($row['id'])
  				));

  			return $product;
  		}
  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Product (name, category_id, description, price, available) VALUES (:name, :category_id, :description, :price, :available) RETURNING id');
        $query->execute(array('name' => $this->name, 'category_id' => $this->category->id, 'description' => $this->description, 'price' => $this->price, 'available' => $this->available));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

        public function update(){
      $query = DB::connection()->prepare('UPDATE Product SET name = :name, category_id = :category_id, description = :description, price = :price, available = :available WHERE id = :id');
        $query->execute(array('name' => $this->name, 'category_id' => $this->category->id, 'description' => $this->description, 'price' => $this->price, 'available' => $this->available, 'id' => $this->id));
        $row = $query->fetch();
    }


    // Jos tuotteen jokin ilmentymä on liitettynä johonkin tilaukseen, tuotetta ei poisteta tietokannasta.
    public function destroy(){
      ProductInstance::destroyAllInStorage($this->id);

      $query = DB::connection()->prepare('SELECT * FROM ProductInstance WHERE Product_id = :id LIMIT 1');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();

        if(!$row) {
        $query = DB::connection()->prepare('DELETE FROM Product WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();        
      }
    }

    public function validate_name() {
      $errors = array();
      if($this->name == '' || $this->name == null) {
        $errors[] = 'Nimi ei saa olla tyhjä!';
      }
      if(strlen($this->name) > 50) {
        $errors[] = 'Nimi ei voi olla yli 50 merkkiä pitkä!';
      }
    return $errors;
    }


    public function validate_price() {
      $errors = array();
      if($this->price == '' || $this->price == null) {
        $errors[] = 'Hinta ei saa olla tyhjä!';
      }
      elseif($this->price < 0) {
        $errors[] = 'Hinta ei voi olla negatiivinen!';
      }
      elseif(!is_numeric($this->price)) {
        $errors[] = 'Hinta pitää ilmoittaa numeroarvona!';
      }

    return $errors;
    }

    public function validate_count() {
      if($this->count == '' || $this->count == null) {
        return 'Lukumäärä ei saa olla tyhjä!';
      }
      elseif($this->count < 0) {
        return 'Lukumäärä ei voi olla negatiivinen!';
      }
      elseif(!is_numeric($this->count)) {
        return 'Lukumäärä pitää ilmoittaa numeroarvona!';
      }
      return null;
    }

    public function validate_description() {
      return $this->validate_string_length($this->description, 'Kuvaus', 500);
    }

    public function validate_category() {
      $errors = array();
      if($this->category == null) {
        $errors[] = 'Valitse kategoria!';
      }
      return $errors;
    }

}
