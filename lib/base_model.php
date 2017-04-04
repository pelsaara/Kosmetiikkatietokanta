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

            $errors = array_merge($errors, $this->{$validator}());
        }

        return array_filter($errors);
    }

    public function validate_string_length($string, $length) {
        $errors = array();
        if (strlen($this->name) < $length) {
            $errors[] = 'Tekstin pituuden tulee olla vähintään ' . $length . ' merkkiä!';
        }
        return $errors;
    }

    public function validate_not_null($string) {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Tekstikenttä ei saa olla tyhjä!';
        }
        return $errors;
    }

}
