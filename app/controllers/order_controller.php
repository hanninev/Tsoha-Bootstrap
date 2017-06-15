<?php

  class OrderController extends BaseController{

    public static function inbox(){
      View::make('admin/arrivedOrders.html');
    }

    public static function show(){
      View::make('order/show.html');
    }

    public static function edit(){
      View::make('order/edit.html');
    }

    public static function myOrders(){
      View::make('order/myOrders.html');
    }

    public static function cart(){
      $products = array();
      $totalPrice = 0;
      if (isset($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $id) {
        $product = Product::show($id);
        $totalPrice += $product->price;
        array_push($products, $product);
      }

      View::make('order/cart.html', array('products' => $products, 'totalPrice' => $totalPrice));
    } else {
      Redirect::to('/', array('errors' => array('Ostoskorisi on tyhjä.')));
    }

  }

  public static function clearCart() {
    $_SESSION['cart'] = null;
    Redirect::to('/', array('message' => 'Ostoskorisi on tyhjä.'));
  }

    public static function removeFromCart($id) {
          $product = Product::show($id);
          if(isset($_SESSION['cart'])) {
            if (($key = array_search($id, $_SESSION['cart'])) !== false) {
               unset($_SESSION['cart'][$key]);
            }

          Redirect::to('/ostoskori', array('message' => 'Tuote ' . $product->name . ' on poistettu ostoskorista.'));
    }
  }

  }
