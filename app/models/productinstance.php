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

    // Poistetaan tietokannasta kaikki kyseisen tuotteen ilmentymät, joita ei ole liitetty mihinkään tilaukseen.
    public static function destroyAllInStorage($productId){
      $query = DB::connection()->prepare('DELETE FROM ProductInstance WHERE Product_id = :id AND Order1_id IS NULL');
        $query->execute(array('id' => $productId));
        $row = $query->fetch();
    }

    public static function destroyCount($productId, $count){
      $query = DB::connection()->prepare('DELETE FROM ProductInstance WHERE id IN (SELECT id FROM ProductInstance WHERE product_id = :id AND Order1_id IS NULL LIMIT :amount)');
        $query->execute(array('id' => $productId, 'amount' => $count));
        $row = $query->fetch();
    }

  }
