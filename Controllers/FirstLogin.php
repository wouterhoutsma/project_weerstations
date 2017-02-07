<?php

class FirstLogin extends Controller{
    public function __construct(){}

    public function index(){
        $this->view('firstLogin', compact('title'));
    }
}
?>
