<?php

class ProductController extends BaseController{
    public static function index(){
        $products = Product::all();
        View::make('product/index.html', array('products' => $products));
        
    }
    
    public static function show($id){
        $product = Product::find($id);
        View::make('product/show.html', array('product' => $product));
    }
}
