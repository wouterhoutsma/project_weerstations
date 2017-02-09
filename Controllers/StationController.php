<?php

  use Model\User;
  use Model\Auth;
  use Model\Station;
  use Model\Measurement;

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

      $measurement_model = new Measurement();
      $base_measurement = $measurement_model->select()
                                            ->where('stn', '=', $station_nr)
                                            ->order('timedate')
                                            ->first();

      $minutes = 10;
      $interval = 5;
      $time_from = $base_measurement->timedate - ($minutes * 60);
      //die(var_dump($base_measurement));
      $measurements = $measurement_model->select()
                                        ->where('timedate', '>=', $time_from)
                                        ->where('stn', '=', $station_nr)
                                        ->order('timedate', true)
                                        ->get();

      //die(var_dump($measurements));
      if(empty($measurements)){
        die("No records... Last time " . $time_from);
      }
      //var_dump($measurements);
      $points = $this->make_json_from_weather_data($measurements);
      $this->view('station', compact('title', 'admin', 'points', 'station', 'station_nr'));
    }

    public function get_data($stn, $from){
      if(Auth::isLoggedIn(false)){
        $measurement_model = new Measurement();
        $measurements = $measurement_model->select()
                                          ->where('timedate', '>', $from)
                                          ->where('stn', '=', $stn)
                                          ->order('timedate', true)
                                          ->get();
        $points = $this->make_json_from_weather_data($measurements);
        die($points);
      }
      else{
        die("You need to login before using this call.");
      }
    }
    private function make_json_from_weather_data($weather_data){
      $points = '[';
      $i = 0;
      foreach($weather_data as $measurement){
        $comma = ($i == 0) ? '' : ',';
        $i++;
        $points .= sprintf('%s[%s,%d]',$comma,(string)($measurement->TIMEDATE * 1000),$measurement->WNSP);
      }
      $points .= ']';
      return $points;
    }
  }
?>
