<?php

  class CategoryController extends BaseController{

    public static function list(){
        $products = Product::list();
        $categories = Category::list();
        View::make('category/list.html', array(
            'categories' => $categories
        ));
    }

    public static function store()
    {
        self::check_admin();
        $params = $_POST;
        
        $attributes = array(
            'name' => $params['name'],
            'description' => $params['description']
        );
        
        $category = new Category($attributes);   
        $errors = $category->errors();
        
        if (count($errors) == 0) {
            $category->save();
            
            Redirect::to('/kategoriat', array(
                'message' => 'Kategoria on lisätty.'
            ));
        } else {
            $categories = Category::list();
            View::make('category/add.html', array(
                'errors' => $errors,
                'attributes' => $attributes
                ));
        }
    }
    
    public static function create()
    {
        self::check_admin();
        View::make('category/add.html', array(
        ));
    }
    
    public static function edit($id)
    {
        self::check_admin();
        $category = Category::show($id);
        View::make('category/edit.html', array(
            'attributes' => $category
        ));
    }
    
    public static function update($id)
    {
        self::check_admin();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description']
        );
        
        $category   = new Category($attributes);
        $errors = $category->errors();
        
        if (count($errors) > 0) {
            View::make('category/edit.html', array(
                'errors' => $errors,
                'attributes' => $attributes
            ));
        } else {
            $category->update();
            Redirect::to('/kategoriat', array(
                'message' => 'Tietoja on muokattu onnistuneesti.'
            ));
        }
    }

    public static function destroy($id)
    {
        self::check_admin();
        $category = new Category(array(
            'id' => $id
        ));
        
        $category->destroy();
        
        Redirect::to('/kategoriat', array(
            'message' => 'Kategoria on poistettu onnistuneesti!'
        ));
    }

  }