<?php
namespace Model;

class User extends Model {

  //protected $table = 'user_table';

  public function __construct(){}
  
  public static function make_password($password){
    return hash_hmac('sha1', $password, 'weatherstations1234hoi' . $password); // DO NOT MESS WITH KEY
  }
}
?>
