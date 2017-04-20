<?php

class ConsumerController extends BaseController {

    public static function login() {
        View::make('consumer/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $consumer = Consumer::authenticate($params['username'], $params['password']);

        if (!$consumer) {
            View::make('consumer/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['consumer'] = $consumer->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $consumer->name . '!'));
        }
    }

    public static function logout() {
        $_SESSION['consumer'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function register() {
        View::make('consumer/register.html');
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
            'password' => $params['password'],
            'age' => $params['age']
        );
        $consumer = new Consumer($attributes);
        //$errors = $consumer->errors();
        //if (count($errors) == 0) {
        $consumer->save();
        Redirect::to('/login', array('message' => 'Rekisteröityminen onnistunut'));
        //} else {
        //    View::make('/register.html', array('errors' => $errors, 'attributes' => $attributes));
        //}
    }

    public static function show() {
        self::check_logged_in();
        $consumer = self::get_user_logged_in();
        View::make('consumer/mypage.html', array('consumer' => $consumer));
    }

    public static function edit($id) {
        self::check_logged_in();
        $consumer = self::get_user_logged_in();
        View::make('consumer/edit.html', array('attributes' => $consumer));
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'password' => $params['password'],
            'age' => $params['age']
        );

        $consumer = new Consumer($attributes);
//        $errors = $consumer->errors();
//       if (count($errors) > 0) {
//            View::make('consumer/edit.html', array('errors' => $errors, 'attributes' => $attributes));
//        } else {
        $consumer->update();
        Redirect::to('/mypage', array('message' => 'Tietoja on muokattu onnistuneesti!'));
//        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $consumer = self::get_user_logged_in();
        $_SESSION['consumer'] = null;
        $consumer->delete();
        Redirect::to('/', array('message' => 'Käyttäjä on poistettu onnistuneesti!'));
    }

}
