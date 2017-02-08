<?php

use Model\User;
use Model\Auth;

class UserConfiguration extends Controller{
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

        //Get all details from all users
        $objdetails = $user->select(['user_id', 'firstname', 'lastname', 'phone', 'email'])->get();

        //Put all details as a string in an array
        $details = [];
        foreach($objdetails as $objdetail){
            $details[$objdetail->user_id] = ['name'=>$objdetail->firstname . " " . $objdetail->lastname, 'email'=>$objdetail->email,'phone'=>$objdetail->phone];

        }

        $this->view('userConfiguration', compact('title', 'admin', 'details'));


    }

    public function delete_account($user_id){
        echo "Delete " . $user_id . "?";
        
    }
}
?>
