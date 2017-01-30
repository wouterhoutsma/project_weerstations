<?php

class AssetController extends Controller{
  public function __construct(){}

  public function asset($filename){
    $file = explode('.', $filename);
    $fileType = $file[1];
    header("Content-type: text/css");
    die(file_get_contents(__DIR__ . '/../views/assets/' . $filename));
  }
}
?>
