<?php

class Product extends BaseModel {

    public $id, $name, $brand, $description, $ingredients, $brandname, $categories, $comments, $commentAmount;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_brand', 'validate_description', 'validate_ingredients');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT Product.id AS id, Product.name AS name, Product.brand AS brand, Product.description AS description, Product.ingredients AS ingredients, Brand.name AS brandname FROM Product, Brand WHERE Product.brand = Brand.id');
        $query->execute();
        $rows = $query->fetchAll();
        $products = array();

        foreach ($rows as $row) {
            $products[] = new Product(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'brand' => $row['brand'],
                'description' => $row['description'],
                'ingredients' => $row['ingredients'],
                'brandname' => $row['brandname'],
                'categories' => Product::findCategories($row['id']),
                'comments' => Product::findComments($row['id']),
                'commentAmount' => count(Product::findComments($row['id']))
            ));
        }
        return $products;
    }

    public static function findByBrand($id) {
        if (!is_numeric($id)) {
            return NULL;
        }
        $query = DB::connection()->prepare('SELECT Product.id AS id, Product.name AS name, Product.brand AS brand, Product.description AS description, Product.ingredients AS ingredients, Brand.name AS brandname FROM Product, Brand WHERE Product.brand = Brand.id AND Brand.id=:id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        if ($rows) {
            $products = array();

            foreach ($rows as $row) {
                $products[] = new Product(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'brand' => $row['brand'],
                    'description' => $row['description'],
                    'ingredients' => $row['ingredients'],
                    'brandname' => $row['brandname'],
                    'categories' => Product::findCategories($row['id']),
                    'comments' => Product::findComments($row['id']),
                    'commentAmount' => count(Product::findComments($row['id']))
                ));
            }
            return $products;
        }
        return NULL;
    }

    public static function findByCategory($id) {
        if (!is_numeric($id)) {
            return NULL;
        }
        $query = DB::connection()->prepare('SELECT Product.id AS id, Product.name AS name, Product.brand AS brand, Product.description AS description, Product.ingredients AS ingredients, Brand.name AS brandname FROM Product, Brand, ProductCategory, Category WHERE Product.brand = Brand.id AND ProductCategory.product = Product.id AND ProductCategory.category = Category.id AND Category.id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        if ($rows) {
            $products = array();
            foreach ($rows as $row) {
                $products[] = new Product(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'brand' => $row['brand'],
                    'description' => $row['description'],
                    'ingredients' => $row['ingredients'],
                    'brandname' => $row['brandname'],
                    'categories' => Product::findCategories($row['id']),
                    'comments' => Product::findComments($row['id']),
                    'commentAmount' => count(Product::findComments($row['id']))
                ));
            }
            return $products;
        }
        return NULL;
    }

    public static function find($id) {
        if (!is_numeric($id)) {
            return NULL;
        }
        $query = DB::connection()->prepare('SELECT Product.id AS id, Product.name AS name, Product.brand AS brand, Product.description AS description, Product.ingredients AS ingredients, Brand.name AS brandname FROM Product, Brand WHERE Product.id = :id AND Product.brand = Brand.id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $categoryFinder = Product::findCategories($id);
            $product = new Product(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'brand' => $row['brand'],
                'description' => $row['description'],
                'ingredients' => $row['ingredients'],
                'brandname' => $row['brandname']
            ));
            $product->categories = $categoryFinder;
            $product->comments = Product::findComments($id);
            return $product;
        }
        return NULL;
    }

    public static function findComments($id) {
        $query = DB::connection()->prepare('SELECT * FROM Comment INNER JOIN Consumer ON Comment.consumer = Consumer.id WHERE product = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $list = array();
        foreach ($rows as $row) {
            $list[] = new Comment(array(
                'text' => $row['comment'],
                'product_id' => $row['product'],
                'writer_id' => $row['consumer'],
                'writername' => $row['name']
            ));
        }
        return $list;
    }

    public static function findCategories($id) {
        $query = DB::connection()->prepare('SELECT * FROM ProductCategory INNER JOIN Category ON ProductCategory.category = Category.id WHERE ProductCategory.product = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $list = array();
        foreach ($rows as $row) {
            $list[] = new ProductCategory(array(
                'product_id' => $row['product'],
                'category_id' => $row['category'],
                'categoryname' => $row['name']
            ));
        }
        return $list;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Product (name, brand, description, ingredients) VALUES (:name, :brand, :description, :ingredients) RETURNING id');
        $query->execute(array('name' => $this->name, 'brand' => $this->brand, 'description' => $this->description, 'ingredients' => $this->ingredients));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Product SET name = :name, brand = :brand, description = :description, ingredients = :ingredients WHERE ID = :id');
        $query->execute(array('name' => $this->name, 'brand' => $this->brand, 'description' => $this->description, 'ingredients' => $this->ingredients, 'id' => $this->id));
        $row = $query->fetch();
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Comment WHERE product = :id');
        $query->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM ProductCategory WHERE product = :id');
        $query->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM Product WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_name() {
        $errors = array();
        $errors[] = parent::validate_not_null('Nimi', $this->name);
        $errors[] = parent::validate_string_length('Nimen', $this->name, 3);
        $errors[] = parent::validate_string_max('Nimen', $this->name, 30);
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
            $errors[] = parent::validate_string_length('Kuvauksen', $this->description, 5);
            $errors[] = parent::validate_string_max('Kuvauksen', $this->description, 500);
        }
        return $errors;
    }

    public function validate_ingredients() {
        $errors = array();
        if (!empty($this->ingredients)) {
            $errors[] = parent::validate_string_length('INCI-luettelon', $this->ingredients, 5);
            $errors[] = parent::validate_string_max('INCI-luettelon', $this->ingredients, 500);
        }
        return $errors;
    }

}
