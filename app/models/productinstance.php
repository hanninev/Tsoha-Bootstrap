<?php

  class ProductInstance extends BaseModel{

    public $id, $product, $order, $price;

    public function __construct($attributes) {
      parent::__construct($attributes);
    }

    public static function howManyLeft($product_id) {
      $query = DB::connection()->prepare('SELECT count(id) AS count FROM ProductInstance WHERE ProductInstance.product_id = :id AND ProductInstance.order1_id IS NULL');
      $query->execute(array('id' => $product_id));
      $row = $query->fetch();

      return $row['count'];
    }

    public static function show($id) {
      $query = DB::connection()->prepare('SELECT * FROM ProductInstance WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if ($row) {
        $productInstance = new ProductInstance(array(
          'id' => $row['id'],
          'product' => Product::show($row['product_id']),
          'order' => Order::show($row['order1_id']),
          'price' => $row['price']
          ));

        return $productInstance;
      }
      return null;
    }

    public static function showByProduct($product_id) {
      $query = DB::connection()->prepare('SELECT * FROM ProductInstance WHERE product_id = :id LIMIT 1');
      $query->execute(array('id' => $product_id));
      $row = $query->fetch();

      if ($row) {
        $productInstance = new ProductInstance(array(
          'id' => $row['id'],
          'product' => Product::show($row['product_id']),
          'order' => Order::show($row['order1_id']),
          'price' => $row['price']
          ));

        return $productInstance;
      }
      return null;
    }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO ProductInstance (product_id) VALUES (:product_id) RETURNING id');
        $query->execute(array('product_id' => $this->product->id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function reverseProductInstance(){
      $query = DB::connection()->prepare('UPDATE ProductInstance SET Order1_id = :order_id, price = :price WHERE id = :id');
        $query->execute(array('id' => $this->id, 'order_id' => $this->order->id, 'price' => $this->product->price));
        $row = $query->fetch();
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
