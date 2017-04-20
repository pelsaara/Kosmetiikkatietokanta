<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['consumer'])) {
            $consumer_id = $_SESSION['consumer'];
            $consumer = Consumer::find($consumer_id);

            return $consumer;
        }
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['consumer'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }



}
