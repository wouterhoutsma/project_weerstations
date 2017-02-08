<?php
  use Model\Station;

  class WeatherAppController extends Controller{
    public function generateWeatherStations(){
      $stations = new Station();
      $stations = $stations->select()
                           ->where('country', '=', 'PARAGUAY', 1)
                           ->get();
      return $stations;
    }
  }
?>
