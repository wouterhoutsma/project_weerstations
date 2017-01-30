<?php
  use Core\Database;

  use Model\User;

  class FrontpageController extends Controller{
    public function __construct(){}

    public function index(){
      //Database::getInstance();
      $title = 'Welcome m8';
      $user = new User();
      $users = $user->select()->where('user_id', '=', 2)->first();
      $user_id = $users->user_id;
      //var_dump($users);
      $this->view('frontpage', compact('title', 'user_id'));
    }
  }
