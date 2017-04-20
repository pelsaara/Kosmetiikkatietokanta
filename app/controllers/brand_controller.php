<?php

class BrandController extends BaseController {

    public static function listAll() {
        $brands = Brand::all();
        View::make('brand/list.html', array('brands' => $brands));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
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
        View::make('brand/new.html');
    }
    
    public static function show($id){
        $brand = Brand::find($id);
        View::make('brand/show.html', array('brand' => $brand));
    }

}

