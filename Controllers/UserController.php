<?php

use Model\User;
use Model\Auth;

class UserController extends WeatherAppController{
    public function __construct(){}

    public function show_settings(){
        $title = "Account Settings";

        //Check if user is logged in and if the timer has reached 30min
        if(!Auth::isLoggedIn()){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Is current user admin?
        $admin = Auth::isAdmin();

        //Current hash value of user
        $thing = $_SESSION['user'];

        $auth = Auth::getInstance();
        $user = new User();

        //Select userID from the user_sessions table,
        // to get the details from current user
        $user_id = $auth->select(['user_id'])
            ->where('hash', '=', $thing, 1)
            ->first();

        //Get details from current user
        $result = $user->select(['firstname', 'lastname', 'phone', 'email'])
            ->where('user_id', '=', $user_id->user_id)
            ->first();
        $firstname = $result->firstname;
        $lastname = $result->lastname;
        $phone = $result->phone;
        $email = $result->email;

        $this->view('controlpanel', compact('title', 'admin','firstname', 'lastname', 'phone', 'email'));
    }

    public function save_settings(){
        $title = "Account Settings";
        $user = new User();
        $auth = Auth::getInstance();
        $thing = $_SESSION['user'];
        $user_id = $auth->select(['user_id'])
            ->where('hash', '=', $thing, 1)
            ->first();

        //Check if user is logged in and if the timer has reached 30min
        if(!Auth::isLoggedIn()){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Is current user admin?
        $admin = Auth::isAdmin();

        //Error message
        $error = "";

        //Details in variables
        $newfirstname = $_POST['firstname'];
        $newlastname = $_POST['lastname'];
        $newphonenumber = $_POST['phone'];
        $newemail = $_POST['email'];
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];

        //Check if all values still exist
        if(!isset($newfirstname)
            || !isset($newlastname)
            || !isset($newphonenumber)
            || !isset($newemail)
            || !isset($oldpassword)
            || !isset($newpassword)
            || !isset($confirmpassword)) {
            $error .= "<li>Something went wrong, try refreshing the page</li>";
        }

        //Check if neccessary fields are filled in
        if($newfirstname == ""
            || $newlastname == ""
            || $newphonenumber == ""
            || $newemail == "") {
            $error .= "<li>First name, last name, phonenumber and email have to be filled in</li>";
        }

        //Check if the old password is filled in, when new password or confirmed password is
        if(($oldpassword == "" || $newpassword == "" || $confirmpassword == "")
            && ($oldpassword != "" || $newpassword != "" || $confirmpassword != "")) {
            $error .= "<li>You have to fill in your old password, new password and confirm the new password for setting a new password.</li>";
        }

        //Check Password, first: get current password
        if($oldpassword != "") {
            $password = $user->select(['password'])
                ->where('user_id', '=', $user_id->user_id)
                ->first();
            //Now check if it's the same as oldpassword
            if (User::make_password($oldpassword) != $password->password) {
                //oldpassword isn't correct
                $error .= "<li>Your old password isn't correct.</li>";
            } else {
                //oldpassword is correct
                //Check if new password is the same as the confirmed password
                if($newpassword != $confirmpassword){
                    $error .= "<li>Your new password isn't the same as the confirmed password.</li>";
                } elseif(!preg_match('/[A-Z]+[a-z]+[0-9]+/', $newpassword)){
                    $error .= "<li>Password needs to contain a combination of uppercase, lowercase and number characters</li>";
                }
                if($newpassword == $oldpassword){
                    $error .= "<li>For changing your password, don't use your old password as new password.</li>";
                }
            }
        }

        //Check if phonenumber consists of only numbers
        $acceptnumbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $arrayphone = str_split($newphonenumber);
        foreach($arrayphone as $value) {
            if(in_array($value, $acceptnumbers)) {
                continue;
            }
            else {
                $error .= "<li>Phonenumber should only consists of numbers</li>";
            }
        }

        //Check if email is already in use
        $emails = $user->select(['user_id'])
            ->where('email', '=', $newemail, 1)
            ->where('user_id', '<>', $user_id->user_id)
            ->first();
        if($emails){
            $error .= "<li>Email address already in use by another user.</li>";
        }

        //Check if email is valid
        if(!filter_var($newemail, FILTER_VALIDATE_EMAIL)){
            $error .= "<li>Email address isn't a valid email.</li>";
        }

        //Make it nice
        $newfirstname = ucfirst(strtolower($newfirstname));
        $newlastname = ucfirst(strtolower($newlastname));

        //Check if there were any errors to view
        if($error != "") {
            $error = sprintf("<ul>%s</ul>", $error);
            $this->view('controlpanel', compact('title', 'admin', 'error', 'newfirstname', 'newlastname', 'newphonenumber', 'newemail'));
        }

        //Encrypt the new password
        $newpassword = User::make_password($newpassword);

        //Update the user table with the new details
        $user->update([
            'firstname' => $newfirstname,
            'lastname' => $newlastname,
            'phone' => $newphonenumber,
            'email' => $newemail,
            'password' => $newpassword
        ])  ->where('user_id', '=', $user_id->user_id)
            ->execute();

        $message = "Your account details are updated!";
        $this->view('controlpanel', compact('title', 'admin', 'message', 'newfirstname', 'newlastname', 'newphonenumber', 'newemail'));
    }
  }
