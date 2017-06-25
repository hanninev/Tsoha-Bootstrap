<?php

class ProductInstanceController extends BaseController
{
    
    public static function store($product_id)
    {
        self::check_admin();
        $params = $_POST;
        $errors = self::validate_count($params['count']);
        
        $category = '';
        if (isset($_SESSION['category'])) {
            $category .= '?category=' . $_SESSION['category'];
        }
        
        
        if (count($errors) > 0) {
            $products = Product::list();
            
            Redirect::to('/' . $category, array(
                'errors' => $errors
            ));
        } else {
            for ($i = 0; $i < $params['count']; $i++) {
                $attributes      = array(
                    'product' => Product::show($product_id)
                );
                $productInstance = new ProductInstance($attributes);
                $productInstance->save();
            }
            
            $product = Product::show($product_id);
            
            Redirect::to('/' . $category, array(
                'message' => 'Tuotetta ' . $product->name . ' on lisätty ' . $params['count'] . ' kappaletta.'
            ));
        }
    }
    
    public static function destroy($product_id)
    {
        self::check_admin();
        $params = $_POST;
        
        if ($params['count'] == ProductInstance::howManyLeft($product_id)) {
            ProductController::destroy($product_id);
        }
        
        $category = '';
        if (isset($_SESSION['category'])) {
            $category .= '?category=' . $_SESSION['category'];
        }
        
        $errors = array();
        $errors = array_merge($errors, self::validate_count($params['count']));
        $errors = array_merge($errors, self::validate_destroy($params['count'], $product_id));
        
        if (count($errors) > 0) {
            $products = Product::list();
            
            Redirect::to('/' . $category, array(
                'errors' => $errors
            ));
        } else {
            $attributes      = array(
                'product' => Product::show($product_id)
            );
            $productInstance = new ProductInstance($attributes);
            $productInstance->destroyCount($product_id, $params['count']);
            
            $product = Product::show($product_id);
            
            Redirect::to('/' . $category, array(
                'message' => 'Tuotetta ' . $product->name . ' on poistettu ' . $params['count'] . ' kappaletta.'
            ));
        }
    }
    
    public static function validate_count($count)
    {
        $errors = array();
        if ($count == '' || $count == null) {
            $errors[] = 'Kirjoita kenttään, kuinka paljon lisätään tai poistetaan!';
        } elseif ($count <= 0) {
            $errors[] = 'Muutoksen pitää olla positiivinen kokonaisluku!';
        } elseif (!filter_var($count, FILTER_VALIDATE_INT)) {
            $errors[] = 'Muutoksen pitää olla kokonaisluku ja se tulee ilmoittaa numeroarvona!';
        }
        
        return $errors;
    }
    
    public static function validate_destroy($count, $product_id)
    {
        $errors           = array();
        $productInstances = ProductInstance::howManyLeft($product_id);
        if ($count > $productInstances) {
            $errors[] = 'Tuotetta on varastossa vain ' . $productInstances . ' kappaletta, joten et voi poistaa ' . $count . ' kappaletta!';
        }
        return $errors;
    }
    
}