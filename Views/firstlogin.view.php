<?php
$this->view('header', compact('title')); ?>

<div id="content">
       <div id="accountsettings">
        <form action="/firstlogin" method="post">
            <table class="table-no-padding">
                <tr>
                    <td>First name:</td>
                    <td><input type="text" name="firstname" value="<?php if(isset($firstname)) { echo $firstname; } ?>"/></td>
                </tr>
                <tr>
                    <td>Last name:</td>
                    <td><input type="text" name="lastname" value="<?php if(isset($lastname)) { echo $lastname; } ?>"/></td>
                </tr>
                <tr>
                    <td>Phone number:</td>
                    <td><input type="text" name="phone" value="<?php if(isset($phonenumber)) { echo $phonenumber; } ?>"/></td>
                </tr>
                <tr>
                    <td>Email address:</td>
                    <td style="width:600px;"><input type="text" name="email" value="<?php if(isset($email)) { echo $email; } elseif(isset($oldemail)) { echo $oldemail; } ?>"/>
                        <div class="infobox"><img src="/assets/information-icon-3.png"/>
                            <span class="infoboxtext">You will have to log in using this emailaddress.</span></div></td>
                </tr>
            </table>
            <p style="width:370px;">
                For changing your current password,
                fill in your old password and a new password.
                A password needs to have a combination of uppercase, lowercase and number characters.
            </p>
            <table class="table-no-padding td-width">
                <tr>
                    <td>New password:</td>
                    <td><input type="password" name="newpassword"/></td>
                </tr>
                <tr>
                    <td>Confirm password:</td>
                    <td><input type="password" name="confirmpassword"/></td>
                </tr>
            </table>
            <br>
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