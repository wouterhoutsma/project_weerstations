<?php
namespace Model;

use Model\User;

class Auth extends Model {

  protected $table = 'user_sessions';
  protected static $instance;
  private static $minutes = 30;
  protected $id;
  private $admin_id = [
    1,
  ];
  protected $fillable = [
    'timestamp',
    'hash',
    'user_id'
  ];

  public function __construct(){}

  public static function getInstance(){
    if( !self::$instance ) {
        self::$instance = new Auth();
    }
    return self::$instance;
  }
  public static function isLoggedIn(){
    $auth = self::getInstance();
    //return [self::calculateHash(1, time()), time()];
    if(isset($auth->id))
      return $auth->id;
    if(isset($_SESSION['user'])){
        $hash = $_SESSION['user'];
        $hash_data = $auth->select(['user_id', 'timestamp'])
                          ->where('hash', '=', $hash, 1)
                          ->first();
        if($hash_data){  // There is a record
          $calculated_hash = self::calculateHash($hash_data->user_id, $hash_data->timestamp);
          if($calculated_hash == $hash){  // At least the user was logged in
            $timestamp = time();
            if($timestamp > ((int)$hash_data->timestamp + (self::$minutes * 60))){
              $auth->delete()
                   ->where('hash', '=', $calculated_hash, 1)
                   ->delete(1);
              unset($_SESSION['user']);
              return false;
            }
            else{
              $new_hash = self::calculateHash($hash_data->user_id, $timestamp);
              $auth->update(['hash' => $new_hash, 'timestamp' => $timestamp])
                   ->where('hash', '=', $calculated_hash, 1)
                   ->update();
              $auth->id = $hash_data->user_id;
              $_SESSION['user'] = $new_hash;
              return $auth->id;
            }
          }
          else{
            return false;
          }
        }
        else{
          return false;
        }
    }
  }

  public static function calculateHash($userid, $timestamp){
    return hash_hmac('sha1', $timestamp, $userid . 'weerstationsession'. $timestamp);
  }

  public static function isAdmin(){
    if(self::isLoggedIn()){
      $auth = self::getInstance();
      $user = new User();
      $user_role = $user->select(['role'])
                        ->where('user_id', '=', $auth->id)
                        ->first();
      if(!$user_role)
        return false;
      if(in_array($user_role->role, $auth->admin_id))
        return true;
    }
    else{
      return false;
    }
  }
}
?>
