<?php
  use Core\Database;

  use Model\User;
  use Model\Auth;

  class FrontpageController extends Controller{
    public function __construct(){}

    public function index(){
      //Database::getInstance();
      $title = 'Welcome m8';
      //$user = new User();
      //var_dump(Auth::isLoggedIn());
    /*  $users = $user->select()
            ->where('email', '=', $email, 1)
            ->where('password', '=', User::make_password($password), 1)
            ->first();*/

      $this->view('frontpage', compact('title'));
    }

    public function submit(){

    }
  }
?>
