<?php
    $this->view('header', compact('title'));
?>

<?php
    $this->view('sidebar', compact('admin'));
?>
    <div id="content">
        <div id="accountsettings">
            <form action="/controlpanel" method="post">
                <label>First name:</label> <input type="text" name="firstname" value="<?php if(isset($newfirstname)) { echo $newfirstname; } elseif(isset($firstname)) { echo $firstname; } ?>"/><br>
                <label>Last name:</label> <input type="text" name="lastname" value="<?php if(isset($newlastname)) { echo $newlastname; } elseif(isset($lastname)) { echo $lastname; } ?>"/><br>
                <label>Phone number:</label> <input type="text" name="phone" value="<?php if(isset($newphonenumber)) { echo $newphonenumber; } elseif(isset($phone)) { echo $phone; } ?>"/><br>
                <label>Email address:</label> <input type="text" name="email" value="<?php if(isset($newemail)) { echo $newemail; } elseif(isset($email)) { echo $email; } ?>"/><br>
                <br>
                For changing your current password, <br>
                fill in your old password and a new password.<br>
                A password needs to have a combination of <br>uppercase, lowercase and number characters.<br>
                <br>
                <label>Old password:</label> <input type="password" name="oldpassword"/><br>
                <label>New password:</label> <input type="password" name="newpassword"/><br>
                <label>Confirm password:</label> <input type="password" name="confirmpassword"/><br>
                <br>
                <input type="file" name="profilepicture"/><br>
                <input type="submit" class="button" value="Save"/>
            </form>
            <?php if(isset($error)){ ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
            <?php if(isset($message)){ ?>
                <div class="noerror">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
        </div>
    </div>

<?php
    $this->view('footer');
?>