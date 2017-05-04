<?php

class Comment extends BaseModel {

    public $id, $text, $product_id, $writer_id, $writername;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_text', 'validate_product', 'validate_writer');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Comment');
        $query->execute();
        $rows = $query->fetchAll();
        $comment = array();

        foreach ($rows as $row) {
            $comment[] = new Comment(array(
                'id' => $row['id'],
                'text' => $row['comment'],
                'product_id' => $row['product'],
                'writer_id' => $row['consumer']
            ));
        }
        return $comment;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Comment WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $comment = new Comment(array(
            'id' => $row['id'],
            'text' => $row['comment'],
            'product_id' => $row['product'],
            'writer_id' => $row['consumer']
            ));
        }
        return $comment;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Comment (product, consumer, comment) VALUES (:product_id, :writer_id, :text) RETURNING id');
        $query->execute(array('product_id' => $this->product_id, 'writer_id' => $this->writer_id, 'text' => $this->text));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validate_text() {
        $errors = array();
        $errors[] = parent::validate_not_null('Kommentti', $this->text);
        $errors[] = parent::validate_string_length('Kommentin', $this->text, 5);
        $errors[] = parent::validate_string_max('Kommentin', $this->text, 500);
        return $errors;
    }

    public function validate_product() {
        $errors = array();
        $errors[] = parent::validate_not_null('Tuote', $this->product_id);
        if (!is_numeric($this->product_id)) {
            $errors[] = 'Tuotetta ei valittu oikein!';
        }

        return $errors;
    }

    public function validate_writer() {
        $errors = array();
        $errors[] = parent::validate_not_null('Kommentoija', $this->writer_id);
        if (!is_numeric($this->writer_id)) {
            $errors[] = 'Kommentoijaa ei valittu oikein!';
        }

        return $errors;
    }

}
