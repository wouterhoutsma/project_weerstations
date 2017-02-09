<?php

  use Model\User;
  use Model\Auth;

  class FrontpageController extends WeatherAppController{
    public $hoi = "blub";
    public function __construct(){}

    public function index(){

      if(!Auth::isLoggedIn()){
        $title = "Sign in";
        $this->view('signin', compact('title'));
        exit();
      }
      $admin = Auth::isAdmin();
      $title = "Welcome";
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

      if(!isset($result->firstname)
          || !isset($result->lastname)
          || !isset($result->phone)){
            $email = $result->email;
            $title = "First login";
            $oldpassword = $result->password;
            $this->view('firstlogin', compact('title', 'email', 'oldpassword'));
            return;
      }


      $this->make_session($result->user_id);
      if(isset($_POST['redirect'])){
        if($_POST['redirect'] != '' && !in_array($_POST['redirect'], ['/login', '/firstlogin'])){
          header("Location: " . $_POST['redirect']);
          return;
        }
      }
      header("Location: /");  # Redirect to host (weather.app ie)
    }
    private function make_session($user_id){
        $auth = Auth::getInstance();
        $tijd = time();
        $hash = Auth::calculateHash($user_id, $tijd);
        $auth->insert([
            'hash' => $hash,
            'user_id' => $user_id,
            'timestamp' => $tijd
        ]);
        $_SESSION['user'] = $hash;
    }

    public function firstlogin(){
      $title = "First login";
      $error = "";

      //Put post in variables
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['emailaddress'];
        $oldemail = $_POST['oldemail'];
        $oldpassword = $_POST['oldpassword'];
        //Check if all fields still exist
        if(!isset($firstname)
            || !isset($lastname)
            || !isset($phonenumber)
            || !isset($email)
            || !isset($_POST['newpassword'])
            || !isset($_POST['confirmpassword'])) {
            $error .= "<li>Something went wrong, please try to refresh the page.</li>";
        }

        //Check if all neccessary fields are filled in
      if($firstname == ""
          || $lastname == ""
          || $phonenumber == ""
          || $email == ""
          || $_POST['newpassword'] == ""
          || $_POST['confirmpassword'] == "") {
        $error .= "<li>All fields have to be filled in</li>";
      }

      //Check if the password and confirmpassword are the same and if the password has the requirements
      if($_POST['newpassword'] != $_POST['confirmpassword']){
          $error .= "<li>The passwords don't match</li>";
      }
      elseif(!preg_match('/[A-Z]+[a-z]+[0-9]+/', $_POST['newpassword'])){
          $error .= "<li>Password needs to contain a combination of uppercase, lowercase and number characters</li>";
      }

      //Make things nice
      $firstname = ucfirst(strtolower($firstname));
      $lastname = ucfirst(strtolower($lastname));

      //Check if the phonenumber only consists numbers
      $acceptnumbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
      $arrayphone = str_split($phonenumber);
      foreach($arrayphone as $value) {
        if(in_array($value, $acceptnumbers)) {
            continue;
          }
          else {
            $error .= "<li>Phonenumber should only consists of numbers</li>";
          }
      }

        //Check if new password isn't the same as the password given by admin
        if($oldpassword == User::make_password($_POST['newpassword'])){
          $error .= "<li>Your new password can't be the same as the password given by the admin.</li>";
        }


      //Get the user_id to get the right user
      $user = new User();
      $user_id = $user->select(['user_id'])
          ->where('email', '=', $oldemail, 1)
          ->where('password', '=', $oldpassword, 1)
          ->first();

      //Check if its right
      if(!$user_id)
        $error .= "<li>Don't mess with the HTML please. Try going back and logging in again.</li>";


      //Check if there were any errors to view
      if($error != ""){
          $error = sprintf("<ul>%s</ul>", $error);
          $this->view('firstlogin', compact('title', 'error', 'firstname', 'lastname', 'phonenumber', 'email', 'oldemail', 'oldpassword'));
          return;
      }
      //$this->view('firstlogin', compact('title', 'firstname', 'lastname', 'phonenumber', 'email', 'oldemail', 'oldpassword'));
      //return;


      $password = User::make_password($_POST['newpassword']);
      $user->update([
          'firstname' => $firstname,
          'lastname' => $lastname,
          'phone' => $phonenumber,
          'email' => $email,
          'password' => $password
      ])->where('user_id', '=', $user_id->user_id)->execute();

      $this->make_session($user_id->user_id);
      header("Location: /");  # Redirect to host (weather.app ie)
    }

    public function logout(){
      unset($_SESSION['user']);
      header("Location: /");
    }
  }
?>
