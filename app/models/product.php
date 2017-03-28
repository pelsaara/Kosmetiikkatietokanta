<?php

class Product extends BaseModel {

    public $id, $name, $brand, $description, $ingredients;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

}
