<?php
$this->view('header', compact('title'));
?>

<?php
$this->view('sidebar', compact('admin'));
?>

<div id="content">
<div id="accountsettings">


    <a href ="/createnewaccount" class="button createacc">Create new account</a>


    <div>
        <?php
        foreach($details as $user_id=>$detail){
            ?>
        <button class="accordion"><?php echo "<div id='ids'>ID: <i>" . $user_id . "</i></div> Name: <i>" . $detail['name'] . "</i>"; ?></button>
        <div class="panel">
            <p>Phonenumber: <?php echo $detail['phone'];?></p>
            <p>Email: <?php echo $detail['email'];?></p>
            <a href="/confirmdelete/<?php echo $user_id ?>" class="button">Delete Account </a>
        </div>
        <?php
        }
        ?>
    </div>
    <br>
    <br>
    <?php if(isset($message)){ ?>
        <div class="noerror">
            <?php echo $message; ?>
        </div>
    <?php } ?>
</div>
</div>

<script>//source w3schools
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight){
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }
    }
</script>

<?php
$this->view('footer', compact('title'));
?>
