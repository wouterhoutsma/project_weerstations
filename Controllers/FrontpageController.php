<?php
  use Core\Database;

  use Model\User;

  class FrontpageController extends Controller{
    public function __construct(){}

    public function index(){
      //Database::getInstance();
      $title = 'Welkom';
      $user = new User();
      $user->get();
      $this->view('frontpage', compact('title'));
    }
  }
