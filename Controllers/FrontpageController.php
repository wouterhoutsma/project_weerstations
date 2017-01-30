<?php
  use Core\Database;

  use Model\User;

  class FrontpageController extends Controller{
    public function __construct(){}

    public function index(){
      //Database::getInstance();
      $title = 'Welcome m8';
      $user = new User();
      $users = $user->select()
            ->where('email', '=', $email, 1)
            ->where('password', '=', User::make_password($password), 1)
            ->first();
      var_dump($user);
      //var_dump($users);
      //$this->view('frontpage', compact('title', 'user_id'));
    }

    public function submit(){

    }
  }
