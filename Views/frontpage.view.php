<?php
$this->view('header', compact('title')); ?>



<?php
$this->view('sidebar', compact('admin'));
?>
    <div id="content">
        Welkom buddy
    </div>

<?php
    $this->view('footer');
?>
