<?php

class Consumer extends BaseModel {

    public $id, $name, $password, $age;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Consumer');
        $query->execute();
        $rows = $query->fetchAll();
        $consumer = array();

        foreach ($rows as $row) {
            $consumer[] = new Consumer(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password'],
                'age' => $row['age']
            ));
        }
        return $consumer;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Consumer WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $consumer = new Consumer(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password'],
                'age' => $row['age']
            ));
        }
        return $consumer;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Consumer (name, password, age) VALUES (:name, :password, :age) RETURNING id');
        $query->execute(array('name' => $this->name, 'password' => $this->password, 'age' => $this->age));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Consumer WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            $consumer = new Consumer(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password'],
                'age' => $row['age']
            ));
            return $consumer;
        } else {
            return null;
        }
    }
    
        public function delete() {
        $first = DB::connection()->prepare('DELETE FROM Comment WHERE consumer = :id');
        $first->execute(array('id' => $this->id));    
        $query = DB::connection()->prepare('DELETE FROM Consumer WHERE id = :id');
        $query->execute(array('id' => $this->id));      
    }

}
