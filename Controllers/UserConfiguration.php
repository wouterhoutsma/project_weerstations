<?php

class UserConfiguration extends Controller{
    public function __construct(){}

    public function index(){
        $this->view('userConfiguration', compact('title'));
    }
}
?>
