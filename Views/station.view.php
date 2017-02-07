<?php
$sources = ['jquery.min.js', 'jquery.flot.js'];
$this->view('header', compact('title', 'sources')); ?>
<?php
$this->view('sidebar', compact('admin'));
?>
    <div id="content">
        Hier komt station <?php echo $station; ?>
        <div id="stationdata" style='width:500px;height:400px;'></div>
        <script type='text/javascript'>
        <?php
          $points = '[]';
        ?>
        $(function () {
          var points = <?php echo $points; ?>;
          var i = 0;
          var random;
          var options = {
      			lines: {
      				show: true
      			}
      		};
          setInterval(function(){
            random = Math.floor((Math.random() * 10) + 1);
            points.push([i, random])
            if(i > 120){   // Make the line sliding, as opposed to just filling
              points.reverse();
              points.pop();
              points.reverse();
            }
            $.plot($("#stationdata"), [points], options);
            i++;
          },300);
        });
        </script>
    </div>

<?php
    $this->view('footer');
?>
