<?php

  class Product extends BaseModel{

  	public $id, $kategoria_id, $nimi, $kuva, $kuvaus, $hinta;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

  	public static function list() {
  		$query = DB::connection()->prepare('SELECT * FROM Tuote');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$tuotteet = array();

  		foreach ($rows as $row) {
  			$tuotteet[] = new Tuote(array(
  				'id' => $row['id'],
  				'kategoria_id' => $row['kategoria_id'],
  				'nimi' => $row['nimi'],
  				'kuvaus' => $row['kuvaus'],
  				'hinta' => $row['hinta']
  				));
  		}
  		return $tuotteet;
  	}

  	public static function show($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Tuote WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if ($row) {
  			$tuote = new Tuote(array(
  				'id' => $row['id'],
  				'kategoria_id' => $row['kategoria_id'],
  				'nimi' => $row['nimi'],
  				'kuvaus' => $row['kuvaus'],
  				'hinta' => $row['hinta']
  				));
  			return $tuote;
  		}
  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Tuote (nimi, kuvaus, hinta) VALUES (:nimi, :kuvaus, :hinta) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'hinta' => $this->hinta));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

        public function update($id){
      $query = DB::connection()->prepare('UPDATE Tuote SET nimi = :nimi, kuvaus = :kuvaus, hinta = :hinta) WHERE id = :id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'hinta' => $this->hinta));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
  }
