<?php

class Product extends BaseModel {

    public $id, $name, $brand, $description, $ingredients;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_brand', 'validate_description', 'validate_ingredients');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Product');
        $query->execute();
        $rows = $query->fetchAll();
        $products = array();

        foreach ($rows as $row) {
            $products[] = new Product(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'brand' => $row['brand'],
                'description' => $row['description'],
                'ingredients' => $row['ingredients']
            ));
        }
        return $products;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Product WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $product = new Product(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'brand' => $row['brand'],
                'description' => $row['description'],
                'ingredients' => $row['ingredients']
            ));
        }
        return $product;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Product (name, brand, description, ingredients) VALUES (:name, :brand, :description, :ingredients) RETURNING id');
        $query->execute(array('name' => $this->name, 'brand' => $this->brand, 'description' => $this->description, 'ingredients' => $this->ingredients));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validate_name() {
        $errors = array();
        $errors[] = parent::validate_not_null('Nimi',$this->name);
        $errors[] = parent::validate_string_length('Nimen',$this->name, 3);

        return $errors;
    }

    public function validate_brand() {
        $errors = array();
        $errors[] = parent::validate_not_null('Merkki', $this->brand);
        if (!is_numeric($this->brand)) {
            $errors[] = 'Brändiä ei valittu oikein!';
        }

        return $errors;
    }

    public function validate_description() {
        $errors = array();
        if (!empty($this->description)) {
            $errors[] = parent::validate_string_length('Kuvauksen',$this->description, 5);
        }
        return $errors;
    }

    public function validate_ingredients() {
        $errors = array();
        if (!empty($this->ingredients)) {
            $errors[] = parent::validate_string_length('INCI-luettelon',$this->ingredients, 5);
        }
        return $errors;
    }

}
