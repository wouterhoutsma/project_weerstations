<?php
namespace Core;

use \mysqli;
class Database {

  private $conn;

  public function __construct($database = null){
    $settings = json_decode(file_get_contents('settings.json'));
    if(!isset($database))
      $database = $settings->database;
    $this->conn = new mysqli($settings->host, $settings->user, $settings->password, $database);
    if(!$this->conn){
      die(  mysqli_connect_error() );
    }
    $GLOBALS['db'] = $this;
  }
  public static function getInstance(){
      if(array_key_exists('db',$GLOBALS))
        return $GLOBALS['db'];

      $db = new Database();
      return $GLOBALS['db'];
  }

  public function execute($sql, $params){
    $index = 1;
    foreach($params as $param){
      $sql = str_replace('($' . $index . ')', htmlentities($param));
      $index++;
    }
  }
}
?>
