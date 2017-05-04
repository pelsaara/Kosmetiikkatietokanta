<?php


class CommentController extends BaseController {


    public static function store($id) {
        $consumer = self::get_user_logged_in();
        $params = $_POST;

        $attributes = array(
            'text' => trim($params['comment']),
            'product_id' => $params['product_id'],
            'writer_id' => $consumer->id
        ); 
        
        $comment = new Comment($attributes);
        $errors = $comment->errors();
        if (count($errors) == 0) {
        $comment->save();
        Redirect::to('/product/'. $id, array('message' => 'Kommentin lisäys onnistunut'));
        } else {
        $product = Product::find($id);
            View::make('/comment/new.html', array('errors' => $errors, 'product' => $product));
        }
    }

    public static function create($id) {
        self::check_logged_in();
        $product = Product::find($id);
        View::make('comment/new.html',array('product' => $product) );
    }
    


}
