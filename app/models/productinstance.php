<?php

  class ProductInstance extends BaseModel{

    public $id, $product, $order, $price;

    public function __construct($product) {
      $this->product = $product;
    }

    public static function howManyLeft($product_id) {
      $query = DB::connection()->prepare('SELECT count(id) AS count FROM ProductInstance WHERE ProductInstance.product_id = :id AND ProductInstance.order1_id IS NULL');
      $query->execute(array('id' => $product_id));
      $row = $query->fetch();

      return $row['count'];
    }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO ProductInstance (product_id) VALUES (:product_id) RETURNING id');
        $query->execute(array('product_id' => $this->product));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

// update kuntoon!
        public function update(){
      $query = DB::connection()->prepare('UPDATE Product SET name = :name, category_id = :category_id, description = :description, price = :price, available = :available WHERE id = :id');
        $query->execute(array('name' => $this->name, 'category_id' => $this->category, 'description' => $this->description, 'price' => $this->price, 'available' => $this->available, 'id' => $this->id));
        $row = $query->fetch();
    }

    // Poistetaan tietokannasta kaikki kyseisen tuotteen ilmentymät, joita ei ole liitetty mihinkään tilaukseen.
    public static function destroy($productId){
      $query = DB::connection()->prepare('DELETE FROM ProductInstance WHERE Product_id = :id AND Order1_id IS NULL');
        $query->execute(array('id' => $productId));
        $row = $query->fetch();
    }

  }
