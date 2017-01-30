<?php
  require_once("Core/Router.php");
  require_once("Core/Database.php");

  # Load all models

  $models = scandir("Models/");
  include_once("Models/Model.php"); // Core Model
  foreach($models as $model){
    if(!in_array($model, ['.','..'])){
      include_once("Models/" . $model);
    }
  }

  require('Controllers/Controller.php');

?>
