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

}
