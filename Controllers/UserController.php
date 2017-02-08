<?php

  class UserController extends Controller{
    public function __construct(){}

    public function show_settings($firstArg){
        $title = "Settings";
        $this->view('controlpanel', compact('title'));
    }
  }
