<?php
$this->view('header', compact('title'));
?>

<?php
$this->view('sidebar');
?>



<!doctype html>
<html>
<head>
    <title>User Configuration - SAweather</title>
</head>

<body>



<div id="content">


    <div>
        <a href ="#" class="button">Create new account</a>
    </div>

    <div>
        <button class="accordion">person 1</button>
        <div class="panel">
            <p>test.....</p>
            <a href="#" class="button">Delete Account </a>
        </div>

        <button class="accordion">person 2</button>
        <div class="panel">
            <p>test....</p>
            <a href="#" class="button">Delete Account </a>
        </div>

        <button class="accordion">person 3</button>
        <div class="panel">
            <p>test....</p>
            <a href="#" class="button">Delete Account </a>
        </div>
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
