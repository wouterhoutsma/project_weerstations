<?php

  include(__DIR__ . '/../autoloader.php');

  use Model\Measurement;
  use Model\Station;
  use Model\Average;

  $minutes = 10;
  $m = new Measurement();
  $s = new Station();
  $a = new Average();

  // Get the latest entry. We'll use this timestamp as 'now'.
  $latest_entry = $m->select(['timedate'])->order('timedate')->first()->timedate;
  // We need to subtract 10 ($minutes) minutes from now, to keep the records needed for the real time graph.
  $latest_entry = $latest_entry - ($minutes * 60);
  // We want all the entries between 'now' minus 10 minutes and 24 hours before that.
  // Per station, that is 86400 records max. With error correction it should be less but not by much.
  // First we need to get all station id's from South America.

  $day = date('d', $latest_entry);
  $month =  date('m', $latest_entry);
  $year = date('Y', $latest_entry);

  $countries = [
    "ARGENTINA",
    "BOLIVIA",
    "BRAZIL",
    "CHILE",
    "COLOMBIA",
    "ECUADOR",
    "FALKLAND ISLANDS (ISLAS MALVINAS)",
    "FRENCH GUIANA",
    "GUYANA",
    "PARAGUAY",
    "PERU",
    "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
    "SURINAME",
    "URUGUAY",
    "VENEZUELA"
  ];
  $stations = $s->select(['stn'])->where('country', 'in', $countries, 1)->get();
  // Now we need to loop over all the stations in South america.
  $time = time();
  $records = 0;
  foreach($stations as $stn){
    $measurements = $m->select(['temp'])
                      ->where('stn', '=', $stn->stn)
                      ->where('timedate', '<', $latest_entry)
                      ->get();
    // Amount of results, weight for in json
    $weight = count($measurements);
    $total_temp = 0;
    foreach($measurements as $measure){
      $total_temp += $measure->temp;
      $records++;
    }
    if($weight > 0){
      $total_temp /= $weight;
      $temp = round($total_temp,2); // 2 decimal places for temp
      // Insert into averages
      $insert = [
        'day'     =>  (int)$day,
        'month'   =>  (int)$month,
        'year'    =>  (int)$year,
        'stn'     =>  (int)$stn->stn,
        'weight'  =>  (int)$weight,
        'temp'    =>  (double)$temp
      ];

      $a->insert($insert);
    }
  }
  $m->delete()->where('timedate', '<', $latest_entry)->delete(1);

  $newtime = time();
  die("Total execution time: ". ($newtime - $time) . "\nRecords parsed: $records \n");
?>
