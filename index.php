<?php

  session_start();

  require("autoloader.php");
  // Get either GET or POST
  require("Core/Routes/" . strtolower(htmlentities($_SERVER['REQUEST_METHOD'])) . ".php");
  //var_dump($request);

?>
