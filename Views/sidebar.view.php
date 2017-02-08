<div id="SideNav" class ="sidenav">
    <?php
      $stations = $this->generateWeatherStations();
      foreach($stations as $s){
        $name = strtolower($s->name);
        $name = ucwords($name, " \t\r\n\f\v/");
        echo '<a href = "/station/'.$s->stn.'" class ="button">Weather Station <br/>'.$name.'</a>';
      }
    ?>
    <a href = "#" class ="button">Account</a>
    <?php
        //if user = admin then:
        if(isset($admin)){
          if($admin){
            ?> <a href = "#" class ="button">User configuration</a> <?php
          }
        }
    ?>

    <a href ="#" class ="button" id="package">Download package</a>
</div>
