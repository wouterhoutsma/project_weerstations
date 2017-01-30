<?php
namespace Model;

use User;

class Auth extends Model {

  protected $table = 'user_sessions';
  protected static $instance;
  protected $id;

  public function __construct(){}

  public static function getInstance(){
    if( !self::$instance ) {
        self::$instance = new Auth();
    }
    return self::$instance;
  }
  public static function isLoggedIn(){
    $auth = self::getInstance();
    //$_SESSION['user'] = '3d2aa47a67e70b273cad1b8ad53529ff3990556d';
    if(isset($_SESSION['user'])){
        $hash = $_SESSION['user'];
        $hash_data = $auth->select(['user_id', 'timestamp'])
                          ->where('hash', '=', $hash, 1)
                          ->first();
        var_dump($auth);

    }
  }

  public static function isAdmin(){
    if(self::isLoggedIn()){
      $auth = self::getInstance();

    }
    else{
      return false;
    }
  }
}
?>
