<?php

class NewAccount extends Controller{
    public function __construct(){}

    public function index(){
        $this->view('createNewAccount', compact('title'));
    }
  }
?>
