<?php

  use Model\User;
  use Model\Auth;

  class StationController extends Controller{
    public function __construct(){}

    public function index($station){
      if(!Auth::isLoggedIn()){
        $title = "Sign in";
        $this->view('signin', compact('title'));
        exit();
      }
      $admin = Auth::isAdmin();
      $title = "Weer station";
      $this->view('station', compact('title', 'admin', 'station'));
    }
  }
?>
