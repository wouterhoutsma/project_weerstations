
<html>
  <head>
      <title><?php echo $title; ?></title>
      <?php
        $http = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];
	$http = ($http == '') ? 'http' : $http;
        $base_url = $http . "://" . $host;

        ?>
      <link rel='stylesheet' href="<?php echo $base_url; ?>/assets/blub.css" type="text/css" />
      <?php
        // Extra sources
        if(isset($sources)){
          foreach($sources as $source){
            $s = explode('.', $source);
            $s = array_reverse($s);
            $type = $s[0];
            switch($type){
              case "js":
                echo "<script type='text/javascript' src='". $base_url ."/assets/". $source ."'></script>\n";
                break;
              case "css":
                echo "<link rel='stylesheet' href='". $base_url ."/assets/". $source ."'/>\n";
                break;
            }
          }
        }
      ?>
  </head>
  <body>
  <div id="header">
     <a href="/" class="title"> SA Weather </a>
      <div class="slogan">
          <?php if(isset($_SESSION['user'])) { $name = $this->get_user(); echo $name->firstname; echo $name->lastname; ?> <a href='/logout'>Logout</a><br/> <?php } ?>
          Slogan placeholder
      </div>
  </div>
