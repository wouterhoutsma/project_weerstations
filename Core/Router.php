<?php
  namespace Core;

  class Router{
    public static function openController($controller, $arguments = null){
      require_once('Controllers/' . $controller[0] .'.php');
      $controller_object = new $controller[0]();
      if(isset($arguments))
        $controller_object->$controller[1](...$arguments);
      else
        $controller_object->$controller[1]();
    }
    public static function route($url, $controller){
      $currentUrl = $_SERVER['REQUEST_URI'];
      $controller = explode('.', $controller);
      if($url == $currentUrl){  // Done
        self::openController($controller);
      }
      else{
        $x = explode('/', $currentUrl);
        $y = explode('/', $url);
        $variables = [];
        if(count($x) != count($y))
          return false;
        foreach($y as $index => $subUrl){
          if(substr($subUrl,0,1) == "{" && substr($subUrl,0,-1)){
            $variables[] = $x[$index];
          }
          else{
            if($subUrl != $x[$index])
              return false;
          }
        }
        if(count($controller) == 2){ // Make object and call function
            self::openController($controller, $variables);
            return true;
        }
        else{
          die("A method must be called on the controller.");
        }
      }
      return false;
    }
  }
?>
