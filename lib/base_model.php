<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $error = $this->{$validator}();
        $errors = array_merge($errors, $error);
      }

      return $errors;
    }

    public function validate_string_length($string, $name, $minLength, $maxLength) {
        $errors = array();
        if($string == '' || $string == null) {
        $errors[] = $name . ' ei saa olla tyhjä!';
        }
        elseif(strlen($string) > $maxLength) {
        $errors[] = $name . ' ei voi olla yli ' . $maxLength . ' merkkiä pitkä!';
        }
        elseif(strlen($string) < $minLength) {
        $errors[] = $name . ' ei voi olla alle ' . $minLength . ' merkkiä pitkä!';
        }
        return $errors;
    }

    public function validate_forename() {
    return self::validate_string_length($this->forename, 'Etunimi', 3, 20);
    }

    public function validate_surname() {
    return self::validate_string_length($this->surname, 'Sukunimi', 3, 30);
    }

    public function validate_email() {
      $errors = array();
      if(!strpos($this->email, '@') || !strpos($this->email, '.')) {
      $errors[] = 'Sähköpostiosoite on virheellinen!';
      }else{
      $errors = array_merge(self::validate_string_length($this->email, 'Sähköposti', 5, 30), $errors);
      }
      return $errors;
    }

    public function validate_postoffice() {
    return self::validate_string_length($this->surname, 'Postitoimipaikka', 3, 15);
    }

    public function validate_positive_number_value($int, $name, $minLength, $maxLength) {
      $errors = array();
      if($int == '' || $int == null) {
        $errors[] = $name . ' ei voi olla tyhjä!';
      }
      elseif($int < 0) {
        $errors[] = $name . ' ei voi olla negatiivinen!';
      }
      elseif((!is_numeric($int) || !preg_match('/[0-9]/', $int))) {
        $errors[] = $name . ' pitää ilmoittaa numeroarvona!';
      }
      elseif(strlen($int) > $maxLength) {
        $errors[] = $name . ' ei voi olla yli ' . $maxLength . ' merkkiä pitkä!';
      }
      elseif(strlen($int) < $minLength) {
        $errors[] = $name . ' ei voi olla alle ' . $minLength . ' merkkiä pitkä!';
    }
    return $errors;
  }

    public function validate_phonenumber() {
      return self::validate_positive_number_value($this->phonenumber, 'Puhelinnumero', 10, 10);
    }

    public function validate_zipcode() {
      return self::validate_positive_number_value($this->zipcode, 'Postinumero', 5, 5);
    }

        public function validate_name()
    {
        return self::validate_string_length($this->name, 'Nimi', 1, 30);
    }

    public function validate_description()
    {
        return $this->validate_string_length($this->description, 'Kuvaus', 0, 500);
    }

    public function validate_no_dublicate_value($name, $database_table, $database_attribute)
    {
        $errors = array();

        if (isset($this->id)) {
        $query = DB::connection()->prepare('SELECT * FROM ' . $database_table .' WHERE '. $database_attribute . '= :name AND id <> :id LIMIT 1');
        $query->execute(array(
            'name' => $this->{$database_attribute},
            'id' => $this->id
        ));
        $row = $query->fetch();
    } else {
        $query = DB::connection()->prepare('SELECT * FROM ' . $database_table .' WHERE '. $database_attribute . '= :name LIMIT 1');
        $query->execute(array(
            'name' => $this->{$database_attribute}
        ));
        $row = $query->fetch();  
    }
        
        if ($row) {
            $errors[] = 'Saman niminen ' . $name .' on jo olemassa!';
            }
    return $errors;
    }

  }
