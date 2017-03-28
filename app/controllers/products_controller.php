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

        $product = new Product(array(
            'name' => $params['name'],
            'brand' => $params['brand'],
            'description' => $params['description'],
            'ingredients' => $params['ingredients']
        ));

        $product->save();

        Redirect::to('/product/' . $product->id, array('message' => 'Tuote on lisätty tietokantaan!'));
    }

}
