<?php
$this->view('header', compact('title')); ?>



<?php
$this->view('sidebar', compact('admin'));
?>
    <div id="content">
        <div id="accountsettings">
            <div style="font-size:x-large;"
                 <p>
                    Welcome to SAweather.
                 </p>
            </div>
            <div style="font-size:medium">
                <p>
                    For information about the windspeed you can look at
                    the weatherstations.
                </p>
                <p>
                    For the average temperature per day there is a button
                    to download the package.
                </p>
            </div>
        </div>
    </div>

<?php
    $this->view('footer');
?>
