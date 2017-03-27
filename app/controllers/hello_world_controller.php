<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
      
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $rip = Product::find(1);
        $tuot = Product::all();
        
        Kint::dump($tuot);
        Kint::dump($rip);
        //View::make('helloworld.html');
    }

    public static function tuote_list() {
        View::make('suunnitelmat/tuote_list.html');
    }

    public static function tuote_show() {
        View::make('suunnitelmat/tuote_show.html');
    }
    
    public static function tuote_edit() {
        View::make('suunnitelmat/tuote_edit.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

}
