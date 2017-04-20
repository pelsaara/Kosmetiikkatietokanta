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

}
