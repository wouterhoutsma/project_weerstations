<?php
  class Controller {
    protected function view($name, $data = []){
      foreach($data as $key => $value){
        ${$key} = $value;
      }
      include('Views/' . $name . '.view.php');
    }
  }

?>
