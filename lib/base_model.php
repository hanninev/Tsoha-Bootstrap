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

    public function validate_string_length($string, $name, $maxLength) {
        $errors = array();
        if($string == '' || $string == null) {
        $errors[] = $name . ' ei saa olla tyhjä!';
        }
        elseif(strlen($string) > $maxLength) {
        $errors[] = $name . ' ei voi olla yli ' . $maxLength . ' merkkiä pitkä!';
        }
        return $errors;
    }

    public function validate_forename() {
    return self::validate_string_length($this->forename, 'Etunimi', 15);
    }

    public function validate_surname() {
    return self::validate_string_length($this->surname, 'Sukunimi', 20);
    }

    public function validate_email() {
      $errors = array();
      if(!strpos($this->email, '@') || !strpos($this->email, '.')) {
      $errors[] = 'Sähköpostiosoite on virheellinen!';
      }else{
      $errors = array_merge(self::validate_string_length($this->email, 'Sähköposti', 20), $errors);
      }
      return $errors;
    }

    public function validate_postoffice() {
    return self::validate_string_length($this->surname, 'Postitoimipaikka', 15);
    }

    public function validate_positive_number_value($int, $name, $maxLength) {
      $errors = array();
      if($int == '' || $int == null) {
        $errors[] = $name . ' ei voi olla tyhjä!';
      }
      elseif($int < 0) {
        $errors[] = $name . ' ei voi olla negatiivinen!';
      }
      elseif(!is_numeric($int)) {
        $errors[] = $name . ' pitää ilmoittaa numeroarvona!';
      }
      elseif(strlen($int) > $maxLength) {
        $errors[] = $name . ' ei voi olla yli ' . $maxLength . ' merkkiä pitkä!';
    }
    return $errors;
  }

    public function validate_phonenumber() {
      return self::validate_positive_number_value($this->phonenumber, 'Puhelinnumero', 10);
    }

    public function validate_zipcode() {
      return self::validate_positive_number_value($this->zipcode, 'Postinumero', 5);
    }

  }
