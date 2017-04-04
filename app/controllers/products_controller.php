<?php

class ProductController extends BaseController {

    public static function index() {
        $products = Product::all();
        View::make('product/index.html', array('products' => $products));
    }

    public static function show($id) {
        $product = Product::find($id);
        View::make('product/show.html', array('product' => $product));
    }

    public static function create() {
        $brands = Brand::all();
        View::make('product/new.html', array('brands' => $brands));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
            'brand' => $params['brand'],
            'description' => $params['description'],
            'ingredients' => $params['ingredients']
        );
        $product = new Product($attributes);
        $errors = $product->errors();
        if (count($errors) == 0){
            $product->save();
            Redirect::to('/product/' . $product->id, array('message' => 'Tuote on lisätty tietokantaan!'));
        } else {
            var_dump($errors);
            die();
            Redirect::to('/product/new', array('errors' => $errors, 'attributes' => $attributes));
        }
        

        
    }

}
