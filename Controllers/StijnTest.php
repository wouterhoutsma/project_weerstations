<?php

class StijnTest extends Controller{
    public function __construct(){}

    public function index(){
        $this->view('createNewAccount', compact('title'));
    }
  }
?>
