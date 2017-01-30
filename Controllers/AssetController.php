<?php

class FrontpageController extends Controller{
  public function __construct(){}

  public function asset($filename){
    die(file_get_contents("../$filename"));
  }
}
?>
