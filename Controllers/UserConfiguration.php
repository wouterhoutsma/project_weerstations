<?php
use Model\User;
use Model\Auth;

class UserConfiguration extends WeatherAppController{
    public function __construct(){}

    public function index(){
        $title = "Configuration";

        $user = new User();
        $auth = Auth::getInstance();

        //Check if user is logged in and if the timer has reached 30min
        if(!Auth::isLoggedIn()){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Is current user admin?
        $admin = Auth::isAdmin();

        $this->view('userConfiguration', compact('title', 'admin'));


    }
}
?>
