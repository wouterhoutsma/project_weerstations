<?php

  class UserController extends WeatherAppController{
    public function __construct(){}

    public function show_settings($firstArg){
        $this->view('controlpanel');
    }
  }
