<?php

  class ProductController extends BaseController{

    public static function index(){
      $products = Product::list();
      View::make('index.html', array('products' => $products));
    }

    public static function show($id){
      $product = Product::show($id);
      $count = ProductInstance::howManyLeft($id);
      View::make('product-show.html', array('product' => $product, 'count' => $count));
    }

    public static function edit($id){
      $product = Product::show($id);
      $categories = Category::list();
      View::make('product-edit.html', array('attributes' => $product, 'categories' => $categories));
    }

    public static function update($id) {
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'category' => $params['category'],
        'name' => $params['name'],
        'description' => $params['description'],
        'price' => $params['price']
        );

    if( empty($_POST["available"]) ) { 
      $attributes['available'] = "f";
    }else { 
      $attributes['available'] = "t";
    }
    
      $product = new Product($attributes);
    $errors = $product->errors();

    if(count($errors) > 0){
      $categories = Category::list();
      View::make('product-edit.html', array('errors' => $errors, 'attributes' => $attributes, 'categories' => $categories));
    }else{
      $product->update();
        Redirect::to('/tuote/' . $product->id, array('message' => 'Tuotetta on muokattu onnistuneesti.'));
      }
    }

    public static function store(){
      $params = $_POST;

      $attributes = array(
        'category' => $params['category'],
        'name' => $params['name'],
        'price' => $params['price'],
        'description' => $params['description']
        );

        if( empty($_POST["available"]) ) { 
        $attributes['available'] = "f";
        } else { 
        $attributes['available'] = "t";
        }

      $product = new Product($attributes);

      $errors = $product->errors();

      if(count($errors) == 0) {
      $product->save();

      for ($i=0; $i < $params['count']; $i++) { 
        $productInstance = new ProductInstance($product->id);
        $productInstance->save();
      }

      Redirect::to('/tuote/' . $product->id, array('message' => 'Tuote on lisätty.'));
    } else {
          $categories = Category::list();
          View::make('product-add.html', array('errors' => $errors, 'attributes' => $attributes, 'categories' => $categories));
      }
    }

    public static function create(){
      $categories = Category::list();
      View::make('product-add.html', array('categories' => $categories));
    }

    public static function destroy($id){
    $product = new Product(array('id' => $id));
 
   $product->destroy();

    Redirect::to('/tuote', array('message' => 'Tuote on poistettu onnistuneesti!'));
  }
  }
