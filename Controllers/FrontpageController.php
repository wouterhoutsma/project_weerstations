<?php
  use Core\Database;

  use Model\User;
  use Model\Auth;

  class FrontpageController extends Controller{
    public function __construct(){}

    public function index(){
      $title = 'Welcome m8';
      $user = new User();
      var_dump(Auth::isAdmin());
      $this->view('frontpage', compact('title'));
    }

    public function submit(){

    }
  }
?>
