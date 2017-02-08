<?php

  use Model\User;
  use Model\Auth;
  use Model\Station;

  class StationController extends WeatherAppController{
    public function __construct(){}

    public function index($station){
      if(!Auth::isLoggedIn()){
        $title = "Sign in";
        $this->view('signin', compact('title'));
        exit();
      }
      $station_nr = $station;
      $this_station = (new Station())->select()->where('stn', '=', $station)->first();
      if(!$this_station)
        header("Location: /");
      $station = ucwords(strtolower($this_station->name), " \t\r\n\f\v/");
      $admin = Auth::isAdmin();
      $title = "Weer station";

      $time = time();
      $minutes = 10;
      $interval = 5;
      $points = '[';
      for($i = 0; $i < ($minutes * 60 / $interval); $i++){
        $comma = ($i == 0) ? '' : ',';
        $this_time = ($time - ($minutes*60) + ($interval * $i)) * 1000; // must be in ms
        $points .= sprintf('%s[%s,%d]',$comma,(string)$this_time,rand(1,100));
      }
      $points .= ']';
      $this->view('station', compact('title', 'admin', 'points', 'station', 'station_nr'));
    }
    public function get_data($stn){
      if(Auth::isLoggedIn(false)){
        $data = [time()  * 1000,rand(1,100)];
        // Zorg ervoor dat je hier measurements uit de database haalt
        die(json_encode($data));
      }
      else{
        die("You need to login before using this call.");
      }
    }
  }
?>
