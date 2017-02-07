<div id="SideNav" class ="sidenav">
    <a href = "/station/1" class ="button">Weather Station 1</a>
    <a href = "/station/2" class ="button">Weather Station 2</a>
    <a href = "/station/3" class ="button">Weather Station 3</a>
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
