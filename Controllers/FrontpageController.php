<?php
  use Core\Database;

  use Model\User;
  use Model\Auth;

  class FrontpageController extends Controller{
    public $hoi = "blub";
    public function __construct(){}

    public function index(){

      if(!Auth::isLoggedIn()){
        $title = "Sign in";
        $this->view('signin', compact('title'));
        exit();
      }
      $admin = Auth::isAdmin();
      $title = "welkom buddy";
      $this->view('frontpage', compact('title', 'admin'));
    }

    public function login(){
      $title = 'Sign in';
      if(!isset($_POST['inputEmail']) || !isset($_POST['inputPassword'])){
          $this->view('signin', compact('title'));
          return;
      }
      if($_POST['inputEmail'] == "" || $_POST['inputPassword'] == ""){
          $this->view('signin', compact('title'));
          return;
      }

      $user = new User();
      $result = $user->select()->where('email', '=', $_POST['inputEmail'], 1)->where('password', '=', User::make_password($_POST['inputPassword']),1)->first();
      if($result == false){
          $error = 'Password is incorrect or user does not exist';
          $this->view('signin', compact('title', 'error'));
          return;
      }

      $auth = Auth::getInstance();
      $tijd = time();
      $hash = Auth::calculateHash($result->user_id, $tijd);
      $auth->insert([
          'hash' => $hash,
          'user_id' => $result->user_id,
          'timestamp' => $tijd
      ]);
      $_SESSION['user'] = $hash;
      header("Location: /");  # Redirect to host (weather.app ie)
    }

    public function logout(){
      unset($_SESSION['user']);
      header("Location: /");
    }
  }
?>
