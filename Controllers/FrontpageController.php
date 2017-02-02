<?php
  use Core\Database;

  use Model\User;
  use Model\Auth;

  class FrontpageController extends Controller{
    public $hoi = "blub";
    public function __construct(){}

    public function index(){
      $title = 'Welcome m8';
      $this->view('frontpage', compact('title'));
    }

    public function login(){
      echo "Hello";
      $hoi = $this->hoi;
      $this->view('frontpage', compact('hoi'));
    }
  }
?>
