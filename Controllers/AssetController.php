<?php

class AssetController extends Controller{
  public function __construct(){}

  public function asset($filename){
    $file = explode('.', $filename);
    $file = array_reverse($file);
    $fileType = $file[0];
    switch($file[0]){
      case 'css':
        header("Content-type: text/css");
        die(file_get_contents(__DIR__ . '/../Views/Assets/' . $filename));
      case 'js':
        header("Content-type: text/javascript");
        die(file_get_contents(__DIR__ . '/../Views/Assets/Scripts/' . $filename));
    }
  }
}
?>
