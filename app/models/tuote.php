<?php

  class Tuote extends BaseModel{

  	public $id, $kategoria_id, $nimi, $kuva, $kuvaus, $hinta;

  	public function __construct($attributes) {
  		parent::__construct($attributes);
  	}

  	public static function listaaKaikki() {
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

  	public static function nayta($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Tuote WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$rows = $query->fetch();

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
  }
