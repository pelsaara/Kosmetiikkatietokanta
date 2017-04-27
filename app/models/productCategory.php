<?php

class ProductCategory extends BaseModel {
    public $product_id, $category_id, $categoryname;
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO ProductCategory (product, category) VALUES (:product_id, :category_id)');
        $query->execute(array(
            'product_id' => $this->product_id,
            'category_id' => $this->category_id
        ));
        
        $row = $query->fetch();
    }
    
    public function destroy() {
        
        $query = DB::connection()->prepare('DELETE FROM ProductCategory WHERE product_id = :product_id');
        $query->execute(array('product_id' => $this->product_id));
    }
    
    
}
