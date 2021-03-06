<?php

class ProductController extends BaseController
{
    
    public static function index()
    {
        $categories = Category::list();
        $params           = $_GET;
        $options          = array();
        $current_category = array();
        
        if (isset($params['category']) && filter_var($params['category'], FILTER_VALIDATE_INT)) {
            $options['category']  = $params['category'];
            $current_category     = Category::show($params['category']);
            $_SESSION['category'] = $params['category'];
        } elseif (isset($_SESSION['category'])) {
            $_SESSION['category'] = null;
        }
        
        $products = Product::listWithSearch($options);
        
        View::make('index.html', array(
            'products' => $products,
            'categories' => $categories,
            'current_category' => $current_category
        ));
    }
    
    public static function show($id)
    {
        $product = Product::show($id);
        $count   = ProductInstance::howManyLeft($id);
        View::make('product/show.html', array(
            'product' => $product
        ));
    }
    
    public static function edit($id)
    {
        self::check_admin();
        $product = Product::show($id);
        $categories = Category::list();
        View::make('product/edit.html', array(
            'attributes' => $product,
            'categories' => $categories
        ));
    }
    
    public static function update($id)
    {
        self::check_admin();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'category' => Category::show($params['category']),
            'name' => $params['name'],
            'description' => $params['description'],
            'price' => $params['price']
        );
        
        if (empty($params['available'])) {
            $attributes['available'] = 0;
        } else {
            $attributes['available'] = 1;
        }
        
        $product = new Product($attributes);
        $errors  = $product->errors();
        
        if (count($errors) > 0) {
            $categories = Category::list();
            View::make('product/edit.html', array(
                'errors' => $errors,
                'attributes' => $attributes,
                'categories' => $categories
            ));
        } else {
            $product->update();
            Redirect::to('/tuote/' . $product->id, array(
                'message' => 'Tuotetta on muokattu onnistuneesti.'
            ));
        }
    }
    
    public static function store()
    {
        self::check_admin();
        $params = $_POST;
        
        $attributes = array(
            'category' => Category::show($params['category']),
            'name' => $params['name'],
            'price' => $params['price'],
            'description' => $params['description'],
            'count' => $params['count']
        );
        
        if (empty($_POST["available"])) {
            $attributes['available'] = 0;
        } else {
            $attributes['available'] = 1;
        }
        
        $product = new Product($attributes);
        
        $errors = $product->errors();
        $errors = array_merge($errors, $product->validate_count());
        
        if (count($errors) == 0) {
            $product->save();
            
            $piAttributes = array(
                'product' => $product
            );
            
            for ($i = 0; $i < $params['count']; $i++) {
                $productInstance = new ProductInstance($piAttributes);
                $productInstance->save();
            }
            
            Redirect::to('/tuote/' . $product->id, array(
                'message' => 'Tuote on lisätty.'
            ));
        } else {
            $categories = Category::list();
            View::make('product/add.html', array(
                'errors' => $errors,
                'attributes' => $attributes,
                'categories' => $categories
            ));
        }
    }
    
    public static function create()
    {
        self::check_admin();
        $categories = Category::list();
        View::make('product/add.html', array(
            'categories' => $categories
        ));
    }
    
    public static function destroy($id)
    {
        self::check_admin();
        $product = new Product(array(
            'id' => $id
        ));
        
        $product->destroy();
        
        Redirect::to('/tuote', array(
            'message' => 'Tuote on poistettu onnistuneesti!'
        ));
    }
    
}