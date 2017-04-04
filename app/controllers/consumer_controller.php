<?php

class UserController extends BaseController {

    public static function login() {
        View::make('consumer/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = Consumer::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('consumer/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
        }
    }

}
