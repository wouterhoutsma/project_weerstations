<?php
$this->view('header', compact('title'));
?>

<!doctype html>
<html>
<head>
    <title>Sign in - SAweather</title>
</head>

<body>

<div class="container">
    <form class="form-signin" action="login" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>

        <br/>

        <div>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <br/>
            <?php if(isset($error)){ ?>
            <div class="error">

                <?php echo $error; ?>
            </div>
            <?php } ?>

        </div>
</div>

        <?php
        $this->view('footer', compact('title'));
        ?>
