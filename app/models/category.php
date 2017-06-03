<?php

  class Category extends BaseModel{

  	public $id, $parentcategory_id, $name, $description;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT * FROM Category');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$categories = array();

  		foreach ($rows as $row) {
  			$categories[] = new Category(array(
  				'id' => $row['id'],
  				'parentcategory_id' => $row['parentcategory_id'],
  				'name' => $row['name'],
  				'description' => $row['description']
  				));
  		}
  		return $categories;
  	}

  	public static function show($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$category = new Category(array(
  				'id' => $row['id'],
          'parentcategory_id' => $row['parentcategory_id'],
  				'name' => $row['name'],
  				'description' => $row['description']
  				));

  			return $category;
  		}
  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Category (parentcategory_id, name, description) VALUES (:name, :parentcategory_id, :description) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'parentcategory_id' => $this->parentcategory_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

        public function update($id){
      $query = DB::connection()->prepare('UPDATE Category SET name = :name, description = :description, parentcategory_id = :parentcategory_id) WHERE id = :id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'parentcategory_id' => $this->parentcategory_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
  }
