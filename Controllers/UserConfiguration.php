<?php

class UserConfiguration extends WeatherAppController{
    public function __construct(){}

    public function index(){
        $this->view('userConfiguration', compact('title'));
    }
}
?>
