<?php
$sources = ['jquery.min.js', 'jquery.flot.js', 'jquery.flot.time.js'];
$this->view('header', compact('title', 'sources')); ?>
<?php
$this->view('sidebar', compact('admin'));
?>
    <div id="content">
        Hier komt station <?php echo $station; ?>
        <div id="stationdata" style='width:50%;height:400px;'></div>
        <script type='text/javascript'>
        $(function () {
          var points = <?php echo $points; ?>;
          var random;
          var date = new Date();
          var i = 120;
          var options = {
            xaxis: {
              mode: 'time'
            },
      			lines: {
      				show: true
      			},
            grid:{
              backgroundColor: { colors: [ "#fff", "#ddf" ] },
              //borderWidth: { top: 1, right: 1, bottom: 2, left: 2 }
            }
      		};
          var highest_time = 0;
          points.forEach(function(e){
            if(e[0] > highest_time)
              highest_time = e[0];
          });
          $.plot($("#stationdata"), [{label:'Windspeed', color: '#66e', data:points}], options);
          var timer = setInterval(function(){
            // Random data

            // random = Math.floor((Math.random() * 100) + 1);
            // points.push([new Date().getTime(), random]);
            // points.reverse();
            // points.pop();
            // points.reverse();
            // $.plot($("#stationdata"), [{label:'Windspeed', color: '#66e', data:points}], options);
            // Actual data
            //alert(highest_time);
            $.ajax({
              url: "/getweatherdata/<?php echo $station_nr; ?>/" + (highest_time / 1000),
            }).done(function(data) {
              if(data == "You need to login before using this call."){
                clearInterval(timer);
                alert("You have been logged out. Refresh the page to login again and continue using this application.");
              }
              //alert(data);
              data = JSON.parse(data);
              data.forEach(function(e){
                if(e[0] > highest_time)
                  highest_time = e[0];
                points.push(e);
              });
              console.log(data);
              console.log(points.length);
              if(points.length > 600){
                console.log(points.length);
                points.reverse();
                points.pop();
                points.reverse();
              }
              $.plot($("#stationdata"), [{label:'Windspeed', color: '#66e', data:points}], options);
            });
          },5000);
        });
        </script>
    </div>

<?php
    $this->view('footer');
?>
