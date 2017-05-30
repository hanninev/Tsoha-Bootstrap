<?php

  class ProductController extends BaseController{

    public static function index(){
      $products = Product::list();
      View::make('index.html', array('products' => $products));
    }

    public static function show($id){
      $product = Product::show($id);
      View::make('product-show.html', array('product' => $product));
    }

    public static function edit($id){
      $product = Product::show($id);
      View::make('product-edit.html', array('product' => $product));
    }

    public static function update($id) {
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'name' => $params['name'],
        'price' => $params['price'],
        'description' => $params['description']
        );
    
      $product = new Product($attributes);
      $errors = $product->errors();

      if(count($errors) > 0) {
        View::make('game/edit.html', array('errors' => $errors, 'attributes' => $attributes));
      } else {
        $product->update();
        Redirect::to('/tuote/' . $product->id, array('message' => 'Tuotetta on muokattu onnistuneesti.'));
      }
    }

    public static function store(){
      $params = $_POST;
      $product = new Product(array(
        'name' => $params['name'],
        'price' => $params['price'],
        'description' => $params['description']
        ));

      $product->save();

    Redirect::to('/tuote/' . $product->id, array('message' => 'Tuote on lisätty.'));
    }

    public static function create(){
      View::make('product-add.html');
    }
  }
