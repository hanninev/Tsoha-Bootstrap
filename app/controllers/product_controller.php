<?php

  class ProductController extends BaseController{

    public static function index(){
      $tuotteet = Product::list();
      View::make('index.html', array('tuotteet' => $tuotteet));
    }

    public static function show($id){
      $tuote = Product::show($id);
      View::make('product-show.html', array('tuote' => $tuote));
    }

    public static function edit($id){
      $product = Product::show($id);
      View::make('product-edit.html', array('product' => $product));
    }

    public static function update($id) {
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'nimi' => $params['nimi'],
        'hinta' => $params['hinta'],
        'kuvaus' => $params['kuvaus']
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
        'nimi' => $params['nimi'],
        'hinta' => $params['hinta'],
        'kuvaus' => $params['kuvaus']
        ));

      $product->save();

    Redirect::to('/tuote/' . $product->id, array('message' => 'Tuote on lisätty.'));
    }

    public static function create(){
      View::make('product-add.html');
    }
  }
