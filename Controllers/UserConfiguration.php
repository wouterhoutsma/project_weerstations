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
        if(!$admin){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Get all details from all users
        $objdetails = $user->select(['user_id', 'firstname', 'lastname', 'phone', 'email'])->get();
        $details = $this->getdetails($objdetails);

        $this->view('userconfiguration', compact('title', 'admin', 'details'));


    }

    public function getdetails($objdetails){
        //Put all details as a string in an array
        $details = [];
        foreach($objdetails as $objdetail){
            $details[$objdetail->user_id] = ['name'=>$objdetail->firstname . " " . $objdetail->lastname, 'email'=>$objdetail->email,'phone'=>$objdetail->phone];

        }

        foreach($details as $user_id=>$detail){
            if($detail['name']==""){
                $details[$user_id]['name']=="Not yet activated";
            }
        }
        foreach($details as $user_id=>$detail){
            if($detail['phone']==""){
                $details[$user_id]['phone']=="Not yet activated";
            }
        }

        return $details;
    }

    public function confirm_delete_account($user_id){
        $title = "Delete Account";

        //Check if user is logged in and if the timer has reached 30min
        if(!Auth::isLoggedIn()){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Is current user admin?
        $admin = Auth::isAdmin();
        if(!$admin){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        $user = new User();

        //Get details about the user that is going to be deleted
        $objdetails = $user->select(['firstname', 'lastname', 'phone', 'email'])
            ->where('user_id', '=', $user_id)
            ->first();

        $firstname = $objdetails->firstname;
        $lastname = $objdetails->lastname;
        $phone = $objdetails->phone;
        $email = $objdetails->email;

        $this->view('confirmdelete', compact('title', 'admin', 'user_id', 'firstname', 'lastname', 'phone', 'email'));
    }

    public function delete_account($user_id){
        $title = "Configuration";
        $user = new User();

        //Check if user is logged in and if the timer has reached 30min
        if(!Auth::isLoggedIn()){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Is current user admin?
        $admin = Auth::isAdmin();
        if(!$admin){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Delete account
        $user->delete()->where('user_id', '=', $user_id)->execute();
        $message =  "User " . $user_id . " is deleted";

        //Get all details from all users
        $objdetails = $user->select(['user_id', 'firstname', 'lastname', 'phone', 'email'])->get();
        $details = $this->getdetails($objdetails);

        $this->view('userconfiguration', compact('title', 'message', 'admin', 'details'));

    }

    public function create_account_form(){
        $title = "New Account";

        //Check if user is logged in and if the timer has reached 30min
        if(!Auth::isLoggedIn()){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Is current user admin?
        $admin = Auth::isAdmin();
        if(!$admin){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        $this->view('createNewAccount', compact('title', 'admin'));
    }

    public function create_account(){
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
        if(!$admin){
            $title = "Sign in";
            $this->view('signin', compact('title'));
            exit();
        }

        //Get all from post
        $newaccemail = $_POST['inputEmail'];
        $newaccpassword = $_POST['inputPassword'];
        $newaccreppasword = $_POST['repeatPassword'];

        $error = "";

        //Check if all values still exist
        if(!isset($newaccemail)
            || !isset($newaccpassword)
            || !isset($newaccreppasword)) {
            $error .= "<li>Something went wrong, try refreshing the page</li>";
        }

        //Check if neccessary fields are filled in
        if($newaccemail == ""
            || $newaccpassword == ""
            || $newaccreppasword == "") {
            $error .= "<li>All fields need to be filled in.</li>";
        }

        //Check if password and repeated passwords are the same
        if($newaccpassword != $newaccreppasword){
            $error .= "<li>Password didn't match with repeat password</li>";
        }

        //Check if password has the right requiremments
        if(!preg_match('/[A-Z]+[a-z]+[0-9]+/', $newaccpassword)){
            $error .= "<li>Password needs to contain a combination of uppercase, lowercase and number characters</li>";
        }


        $emails = $user->select(['user_id'])
            ->where('email', '=', $newaccemail, 1)
            ->first();
        if($emails){
            $error .= "<li>Email address already in use.</li>";
        }

        if(!filter_var($newaccemail, FILTER_VALIDATE_EMAIL)){
            $error .= "<li>Email address isn't a valid email.</li>";
        }


        //Check if there were any errors to view
        if($error != "") {
            $error = sprintf("<ul>%s</ul>", $error);
            $this->view('createnewaccount', compact('title', 'admin', 'error', 'newaccemail'));
            return;
        }

        //Add new account to database
        $user->insert([
            'email' => $newaccemail,
            'password' => User::make_password($newaccpassword)
        ]);

        $message = "New account created.";

        //Get all details from all users
        $objdetails = $user->select(['user_id', 'firstname', 'lastname', 'phone', 'email'])->get();
        $details = $this->getdetails($objdetails);

        $this->view('userconfiguration', compact('title', 'message', 'admin', 'details'));
    }
}
?>
