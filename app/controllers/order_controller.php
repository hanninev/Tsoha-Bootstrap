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
      // jos session käyttäjällä sama id kuin tilauksen tehneellä
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

  public static function addToCart($id) {
          $product = Product::show($id);
          if(!isset($_SESSION['cart'])) {
            $cart = array($id);
            $_SESSION['cart'] = $cart;
          } else {
            array_push($_SESSION['cart'], $id);
          }
          Redirect::to('/', array('message' => 'Tuote ' . $product->name . ' on lisätty ostoskoriisi.'));
    }

    public static function store(){
      $params = $_POST;

      $attributes = array(
          'status' => 1,
          'forename' => $params['forename'],
          'surname' => $params['surname'],
          'phonenumber' => $params['phonenumber'],
          'email' => $params['email'],
          'delivery_address' => $params['delivery_address'],
          'zipcode' => $params['zipcode'],
          'postoffice' => $params['postoffice']
        );

      if(self::get_user_logged_in()) {
        $attributes['user'] = self::get_user_logged_in();
      }

      $order = new Order($attributes);

      $errors = $order->errors();

      if(count($errors) == 0) {
      $order->save();

      foreach ($_SESSION['cart'] as $product_id) {
        $productInstance = ProductInstance::showByProduct($product_id);
        $productInstance->order = $order;
        $productInstance->reverseProductInstance();
      }

      $_SESSION['cart'] = null;
      Redirect::to('/', array('message' => 'Tilaus on tehty onnistuneesti.'));
    } else {
          View::make('order/cart.html', array('errors' => $errors, 'attributes' => $attributes));
      }
    }


  }
