<?php

  session_start();
  error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
  ini_set('display_errors', 1);
  require("autoloader.php");
  // Get either GET or POST
  require("Core/Routes/" . strtolower(htmlentities($_SERVER['REQUEST_METHOD'])) . ".php");
  //var_dump($request);

?>
