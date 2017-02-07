<?php

class butt extends Controller{
    public function __construct(){}

    public function index(){
        $this->view('dickbutt', compact('title'));
    }
}
?>