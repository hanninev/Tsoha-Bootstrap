<?php

class Product extends BaseModel
{
    
    public $id, $category, $name, $description, $price, $count, $available, $validators;
    
    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array(
            'validate_name',
            'validate_price',
            'validate_description',
            'validate_category',
            'validate_no_dublicate_product_name'
        );
    }
    
    public static function list() {
        $options = array();
        self::listWithSearch($options);
    }
    
    public static function listWithSearch($options)
    {
        $category = '';
        if (isset($options['category'])) {
            $category .= ' AND Product.category_id = :category';
        }
        
        $query_string = 'SELECT Product.id, Product.category_id, Product.name, Product.description, Product.price, Product.available FROM Product LEFT JOIN Category ON Product.category_id = Category.id WHERE Product.available AND Product.id IN (SELECT Product_id FROM ProductInstance WHERE Order1_id IS NULL' . $category . ')';
        
        $query = DB::connection()->prepare($query_string);
        $query->execute($options);
        $rows     = $query->fetchAll();
        $products = array();
        
        foreach ($rows as $row) {
            $products[] = new Product(array(
                'id' => $row['id'],
                'category' => Category::show($row['category_id']),
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price'],
                'available' => $row['available'],
                'count' => ProductInstance::howManyLeft($row['id'])
            ));
        }
        
        return $products;
    }
    
    public static function show($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Product WHERE id = :id LIMIT 1');
        $query->execute(array(
            'id' => $id
        ));
        $row = $query->fetch();
        
        if ($row) {
            $product = new Product(array(
                'id' => $row['id'],
                'category' => Category::show($row['category_id']),
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price'],
                'available' => $row['available'],
                'count' => ProductInstance::howManyLeft($row['id'])
            ));
            
            return $product;
        }
        return null;
    }
    
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO Product (name, category_id, description, price, available) VALUES (:name, :category_id, :description, :price, :available) RETURNING id');
        $query->execute(array(
            'name' => $this->name,
            'category_id' => $this->category->id,
            'description' => $this->description,
            'price' => $this->price,
            'available' => $this->available
        ));
        $row      = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update()
    {
        $query = DB::connection()->prepare('UPDATE Product SET name = :name, category_id = :category_id, description = :description, price = :price, available = :available WHERE id = :id');
        $query->execute(array(
            'name' => $this->name,
            'category_id' => $this->category->id,
            'description' => $this->description,
            'price' => $this->price,
            'available' => $this->available,
            'id' => $this->id
        ));
        $row = $query->fetch();
    }
    
    
    // Jos tuotteen jokin ilmentymä on liitettynä johonkin tilaukseen, tuotetta ei poisteta tietokannasta.
    public function destroy()
    {
        ProductInstance::destroyAllInStorage($this->id);
        
        $query = DB::connection()->prepare('SELECT * FROM ProductInstance WHERE Product_id = :id LIMIT 1');
        $query->execute(array(
            'id' => $this->id
        ));
        $row = $query->fetch();
        
        if (!$row) {
            $query = DB::connection()->prepare('DELETE FROM Product WHERE id = :id');
            $query->execute(array(
                'id' => $this->id
            ));
            $row = $query->fetch();
        }
    }
    
    public function validate_price()
    {
        return self::validate_positive_number_value($this->price, 'Hinta', 1, 10);
    }
    
    public function validate_count()
    {
        return self::validate_positive_number_value($this->count, 'Lukumäärä', 1, 10);
    }
    
    public function validate_category()
    {
        $errors = array();
        if ($this->category == null) {
            $errors[] = 'Valitse kategoria!';
        }
        return $errors;
    }
    
    public function validate_no_dublicate_product_name()
    {
        return self::validate_no_dublicate_value('tuote', 'Product', 'name');
    }
    
}