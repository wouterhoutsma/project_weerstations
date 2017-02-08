<?php

class NewAccount extends WeatherAppController{
    public function __construct(){}

    public function index(){
        $this->view('createNewAccount', compact('title'));
    }
  }
?>
