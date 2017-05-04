<?php

class Consumer extends BaseModel {

    public $id, $name, $password, $age;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password', 'validate_age');
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

    public function update() {
        $query = DB::connection()->prepare('UPDATE Consumer SET name = :name, password = :password, age = :age WHERE ID = :id');
        $query->execute(array('name' => $this->name, 'password' => $this->password, 'age' => $this->age, 'id' => $this->id));
        $row = $query->fetch();
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

    public function validate_name() {
        $errors = array();
        $errors[] = parent::validate_not_null('Nimi', $this->name);
        $errors[] = parent::validate_string_length('Nimen', $this->name, 3);
        $errors[] = parent::validate_string_max('Nimen', $this->name, 30);
        if ($this->name == 'Yllapitaja') {
            $errors[] = ('Nimi ei voi olla Yllapitaja');
        }
        return $errors;
    }

    public function validate_password() {
        $errors = array();
        $errors[] = parent::validate_not_null('Salasana', $this->password);
        $errors[] = parent::validate_string_length('Salasanan', $this->password, 5);
        $errors[] = parent::validate_string_max('Salasanan', $this->password, 30);
        return $errors;
    }

    public function validate_age() {
        $errors = array();
        $errors[] = parent::validate_not_null('Ikä', $this->age);
        if (!is_numeric($this->age)) {
            $errors[] = 'Ikä tulee ilmoittaa numeroina';
        }
        if ($this->age > 200 || $this->age < 0){
            $errors[] = 'Iän tulee olla väliltä 0-199';
        }

        return $errors;
    }

}
