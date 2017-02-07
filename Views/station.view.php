<?php
$this->view('header', compact('title')); ?>
<?php
$this->view('sidebar', compact('admin'));
?>
    <div id="content">
        Hier komt station <?php echo $station; ?>
    </div>

<?php
    $this->view('footer');
?>
