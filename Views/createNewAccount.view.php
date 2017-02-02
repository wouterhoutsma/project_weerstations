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
        <form class="form-signin" action="Login.php" method="post">
            <h2 class="form-signin-heading">Create new account</h2>

            <br/>

            <div>

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="text" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="text" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>

                <label for="repeatPassword" class="sr-only">Repeat password</label>
                <input type="text" id="repeatPassword" name="repeatPassword" class="form-control" placeholder="Repeat password" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                <br/>
            </div>
    </div>

<?php
$this->view('footer', compact('title'));
?>