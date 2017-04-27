<?php

class CategoryController extends BaseController {

    public static function listAll() {
        $categories = Category::all();
        View::make('category/list.html', array('categories' => $categories));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
        );
        $category = new Category($attributes);
        $errors = $category->errors();
        if (count($errors) == 0) {
        $category->save();
        Redirect::to('/category', array('message' => 'Kategorian lisäys onnistunut'));
        } else {
            View::make('/category/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        self::check_logged_in();
        View::make('category/new.html');
    }
    
    public static function show($id){
        $category = Category::find($id);
        View::make('category/show.html', array('category' => $category));
    }

}
