<?php

  class OrderController extends BaseController{

    public static function show($id){
      self::check_logged_in();
      $order = Order::show($id);
      $productInstances = ProductInstance::ProductInstanceByOrder($id);

      View::make('order/show.html', array('order' => $order, 'productInstances' => $productInstances));
    }

    public static function myOrders(){
      self::check_logged_in();
      $user = self::get_user_logged_in();
      $orders = Order::myOrders($user->id);
      View::make('order/myOrders.html', array('orders' => $orders));
    }

    public static function editStatus($order_id, $status_id) {
      self::check_admin();
      $order = Order::show($order_id);
      $order->editStatus($status_id);
      Redirect::to('/tilaukset', array());
    }

    public static function arrivedOrders(){
      self::check_admin();
      $orders = Order::arrivedList();
      View::make('admin/arrivedOrders.html', array('orders' => $orders));
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
      Redirect::to('/ostoskori', array('errors' => $errors, 'attributes' => $attributes));
      }
    }


  }
