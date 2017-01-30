<?php

  class UserController extends Controller{
    public function __construct(){}

    public function show_settings($firstArg){
        $this->view('controlpanel');
    }
  }
