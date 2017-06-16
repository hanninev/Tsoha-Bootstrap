<?php

  class ProductInstanceController extends BaseController{

    public static function store($product_id){
      self::check_admin();
      $params = $_POST;
      $errors = self::validate_count($params['count']);

      if (count($errors) > 0) {
          $products = Product::list();

      View::make('index.html', array('errors' => $errors, 'products' => $products, 'admin' => BaseController::admin()));
    } else {
      for ($i=0; $i < $params['count']; $i++) { 
        $attributes = array('product' => Product::show($product_id));
        $productInstance = new ProductInstance($attributes);
        $productInstance->save();
      }

      $product = Product::show($product_id);

      Redirect::to('/tuote', array('message' => 'Tuotetta ' . $product->name . ' on lisätty ' . $params['count'] . ' kappaletta.'));
    } 
    }

    public static function destroy($product_id){
    self::check_admin();
    $params = $_POST;

    if ($params['count'] == ProductInstance::howManyLeft($product_id)) {
      ProductController::destroy($product_id);
    }

    $errors = array();
    $errors = array_merge($errors, self::validate_count($params['count']));
    $errors = array_merge($errors, self::validate_destroy($params['count'], $product_id));

    if (count($errors) > 0) {
    $products = Product::list();

    View::make('index.html', array('errors' => $errors, 'products' => $products, 'admin' => BaseController::admin()));
    } else {
    $attributes = array('product' => Product::show($product_id));
    $productInstance = new ProductInstance($attributes);
    $productInstance->destroyCount($product_id, $params['count']);

    $product = Product::show($product_id);

    Redirect::to('/tuote', array('message' => 'Tuotetta ' . $product->name . ' on poistettu ' . $params['count'] . ' kappaletta.'));  
  }
  }

  public static function validate_count($count) {
      $errors = array();
      if($count == '' || $count == null) {
        $errors[] = 'Kirjoita kenttään, kuinka paljon lisätään tai poistetaan!';
      }
      elseif($count <= 0) {
        $errors[] = 'Muutoksen pitää olla positiivinen kokonaisluku!';
      }
      elseif(!is_numeric($count)) {
        $errors[] = 'Muutos pitää ilmoittaa numeroarvona!';
      }

    return $errors;
  }

    public static function validate_destroy($count, $product_id) {
      $errors = array();
      $productInstances = ProductInstance::howManyLeft($product_id);
      if($count > $productInstances) {
        $errors[] = 'Tuotetta on varastossa vain ' . $productInstances . ' kappaletta, joten et voi poistaa ' . $count . ' kappaletta!';
      }     
    return $errors;
    }

  }
