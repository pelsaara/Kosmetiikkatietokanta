<?php

class Brand extends BaseModel {

    public $id, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Brand');
        $query->execute();
        $rows = $query->fetchAll();
        $brands = array();

        foreach ($rows as $row) {
            $brands[] = new Brand(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $brands;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Brand WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $brand = new Brand(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $brand;
    }

    public function save() {
     
        $query = DB::connection()->prepare('INSERT INTO Brand (name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}