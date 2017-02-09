<?php
  use Model\Station;
  use Core\Database;
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

    public function get_package(){
      if(!Auth::isLoggedIn()){
        $title = "Sign in";
        $this->view('signin', compact('title'));
        exit();
      }
      // Could be generated in the cron but this works as well, got enough CPU
      // The model isn't advanced enough to cover our needs here, so will write queries by hand
      $sql = "SELECT day, month, year FROM averages ORDER BY year DESC, month DESC, day DESC LIMIT 1";
      $db = Database::getInstance();
      $res = $db->query($sql);
      if(!$res){
        die("There is absolutely no data yet.");
      }
      $res = $res->fetch_assoc();
      $h_month = $res['month'];
      $h_year = $res['year'];
      $day = $res['day'];
      $l_month = ($h_month == 1) ? 12 : $h_month - 1;
      $l_year = ($h_month == 1) ? $h_year - 1 : $h_year;
      $h_sql = "SELECT * FROM averages
                WHERE year = $h_year
                AND month = $h_month
                AND day <= $day";
      $l_sql = "SELECT * FROM averages
                WHERE year = $l_year
                AND month = $l_month
                AND day >= $day";
      $high_avg = $db->query($h_sql);
      $low_avg = $db->query($l_sql);
      // Now we have the results from this month in $high_avg
      // And the results from last month in $low_avg. This wont span more that 31 days, ever.
      $data = array();
      while($measurement = $high_avg->fetch_object()){
        if(!array_key_exists($measurement->stn,$data))
          $data[$measurement->stn] = []; // Make array, will hold arrays with measurements
        $this_day = [
          'day'   => $measurement->day,
          'month' => $measurement->month,
          'year'  => $measurement->year,
          'weight'=> $measurement->weight,
          'temp'  => $measurement->temp
        ];
        array_push($data[$measurement->stn], $this_day);
      }
      while($measurement = $low_avg->fetch_object()){
        if(!array_key_exists($measurement->stn,$data))
          $data[$measurement->stn] = []; // Make array, will hold arrays with measurements
        $this_day = [
          'day'   => $measurement->day,
          'month' => $measurement->month,
          'year'  => $measurement->year,
          'weight'=> $measurement->weight,
          'temp'  => $measurement->temp
        ];
        array_push($data[$measurement->stn], $this_day);
      }
      header('Content-Type: application/json');
      header('Content-Disposition: attachment; filename="package_'.time().'.json"');
      die(json_encode($data));
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
