<?php

class test extends Controller{
    public function __construct(){}

    public function index(){
        $this->view('graph', compact('title'));
    }
}
?>
