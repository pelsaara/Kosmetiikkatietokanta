<?php

class BrandController extends BaseController {

    public static function listAll() {
        $brands = Brand::all();
        View::make('brand/list.html', array('brands' => $brands));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'name' => trim($params['name'])
        );
        $brands = new Brand($attributes);
        $errors = $brands->errors();
        if (count($errors) == 0) {
            $brands->save();
            Redirect::to('/brand', array('message' => 'Merkin lisäys onnistunut'));
        } else {
            View::make('/brand/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        self::check_logged_in();
        View::make('brand/new.html');
    }

    public static function listProductsByBrand($id) {
        $products = Product::findByBrand($id);
        $brand = Brand::find($id);
        if ($brand != NULL) {
            View::make('brand/show.html', array('products' => $products, 'brand' => $brand));
        } else {
            Redirect::to('/brand', array('error' => 'Merkkiä ei löydy!'));
        }
    }

}
