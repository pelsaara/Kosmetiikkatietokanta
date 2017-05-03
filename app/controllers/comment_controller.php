<?php


class CommentController extends BaseController {


    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'text' => $params['comment'],
            'product_id' => $params['product_id']
        ); 
        $comment = new Comment($attributes);
        $errors = $comment->errors();
        if (count($errors) == 0) {
        $comment->save();
        Redirect::to('/category', array('message' => 'Kategorian lisäys onnistunut'));
        } else {
            View::make('/category/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        self::check_logged_in();
        View::make('comment/new.html');
    }
    


}
