<?php
namespace Core;

use \mysqli;
class Database extends mysqli{

  protected static $instance;

  public function __construct($database = null){

    $settings = json_decode(file_get_contents('settings.json'));
    if(!isset($database))
      $database = $settings->database;
    @parent::__construct($settings->host, $settings->user, $settings->password, $database);

    if(mysqli_connect_errno()){
        die("Couldn't connect to the database. Please try again with an internet connection.") ;
    }

  }
  public static function getInstance() {
        if( !self::$instance ) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}
?>
