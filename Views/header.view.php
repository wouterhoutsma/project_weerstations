
<html>
  <head>
      <title><?php echo $title; ?></title>
      <?php
        $http = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];
        $base_url = $http . "://" . $host;
        ?>
      <link rel='stylesheet' href="<?php echo $base_url; ?>/assets/blub.css" type="text/css" />
  </head>
  <body>
  <div id="header">
      SA Weather
      <div class="slogan">
          Slogan placeholder
      </div>
  </div>
