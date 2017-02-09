<?php
  use Model\Station;
  use Model\Auth;
  use Model\User;

  class WeatherAppController extends Controller{
    public function generateWeatherStations(){
      $stations = new Station();
      $stations = $stations->select()
                           ->where('country', '=', 'PARAGUAY', 1)
                           ->get();
      return $stations;
    }
    public function get_user(){
        $auth = Auth::getInstance();
        $user = new User();
        $user_id = $auth->select(['user_id'])->where('hash', '=', $_SESSION['user_id'], 1)->first();
        //die(var_dump($user_id));
        $firstlastname = $user-> select(['firstname','lastname'])->where('user_id','=',$user_id->user_id)->first();
       // die(var_dump($firstlastname));
        return $firstlastname;

    }
  }
?>
