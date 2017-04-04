<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            var_dump($this->{$validator}());
//            if (!empty($this->{$validator}())){
//                $errors = array_merge($errors, $this->{$validator}());
//            }
            
        }

        return $errors;
    }

    public function validate_string_length($string, $length) {
        $error = null;
        if (strlen($this->name) < $length) {
            $error = 'Tekstin pituuden tulee olla vähintään ' . $length . ' merkkiä!';
        }
        return $error;
    }

    public function validate_not_null($string) {
        $error = null;
        if ($this->name == '' || $this->name == null) {
            $error = 'Tekstikenttä ei saa olla tyhjä!';
            return $error;
        }
    }

}
