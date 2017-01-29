<?php
namespace Model;

class User extends Model {
  public function __construct(){}
  public function get(){
    return $this->getTable();
  }
}
?>
