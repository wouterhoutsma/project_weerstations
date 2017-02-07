<?php
$this->view('header', compact('title')); ?>

<div id="content">
       <div id="accountsettings">
        <form action="/firstlogin" method="post">
            <label>First name:</label> <input type="text" name="firstname" value="<?php if(isset($firstname)) { echo $firstname; } ?>"/><br>
            <label>Last name:</label> <input type="text" name="lastname" value="<?php if(isset($lastname)) { echo $lastname; } ?>"/><br>
            <label>Phone number:</label> <input type="text" name="phonenumber" value="<?php if(isset($phonenumber)) { echo $phonenumber; } ?>"/><br>
            <label>Email address:</label> <input type="text" name="emailaddress" value="<?php if(isset($email)) { echo $email; } ?>"/><br>

            <br>
            Your new password can't be the same as
            <br>the password provided by the admin.
            <br><br>

            <label>New password:</label> <input type="password" name="newpassword"/><br>
            <label>Confirm password:</label> <input type="password" name="confirmpassword"/><br>
            <br>
            <input type="file" name="profilepicture"/><br>
            <input type="hidden" name="oldemail" value="<?php if(isset($oldemail)) { echo $oldemail; } else { echo $email; } ?>"/>
            <input type="hidden" name="oldpassword" value="<?php if(isset($oldpassword)) { echo $oldpassword; } ?>"/>
            <input type="submit" class="button" value="Save"/>
        </form>
           <?php if(isset($error)){ ?>
           <div class="error">

               <?php echo $error; ?>
           </div>
           <?php } ?>
    </div>
    </div>
</div>

<?php
$this->view('footer');
?>