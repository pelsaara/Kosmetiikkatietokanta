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

    public function validate_string_length($nimi, $string, $length) {
        $error = null;
        if (strlen($string) < $length) {
            $error = ($nimi . ' pituuden tulee olla vähintään ' . $length . ' merkkiä!');
        }
        return $error;
    }

    public function validate_not_null($nimi, $string) {
        $error = null;
        if ($string == '' || $string == null) {
            $error = ($nimi . ' ei saa olla tyhjä!');
        }
        return $error;
    }

}
