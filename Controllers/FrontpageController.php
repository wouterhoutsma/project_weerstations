<?php
  use Core\Database;

  use Model\User;
  use Model\Auth;

  class FrontpageController extends Controller{
    public $hoi = "blub";
    public function __construct(){}

    public function index(){

      if(Auth::isLoggedIn()){
        $title = "Sign in";
        $this->view('signin', compact('title'));
        exit();
      }
      $admin = Auth::isAdmin();
      $title = "welkom buddy";
      $this->view('frontpage', compact('title', 'admin'));
    }

    public function login(){
      echo "Hier moet talitha login spul maken";
      $title = $this->hoi;
      $this->view('signin', compact('title'));
    }
  }
?>
