<?php
    $this->view('header', compact('title'));
?>

<?php
    $this->view('sidebar', compact('admin'));
?>
    <div id="content">
        <div id="accountsettings">
            <form action="/controlpanel" method="post">
                <table class="table-no-padding">
                    <tr>
                        <td>First name:</td>
                        <td><input type="text" name="firstname" value="<?php if(isset($newfirstname)) { echo $newfirstname; } elseif(isset($firstname)) { echo $firstname; } ?>"/></td>
                    </tr>
                    <tr>
                        <td>Last name:</td>
                        <td><input type="text" name="lastname" value="<?php if(isset($newlastname)) { echo $newlastname; } elseif(isset($lastname)) { echo $lastname; } ?>"/></td>
                    </tr>
                    <tr>
                        <td>Phone number:</td>
                        <td><input type="text" name="phone" value="<?php if(isset($newphonenumber)) { echo $newphonenumber; } elseif(isset($phone)) { echo $phone; } ?>"/></td>
                    </tr>
                    <tr>
                        <td>Email address:</td>
                        <td style="width:600px;"><input type="text" name="email" value="<?php if(isset($newemail)) { echo $newemail; } elseif(isset($email)) { echo $email; } ?>"/>
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
                        <td>Old password:</td>
                        <td><input type="password" name="oldpassword"/></td>
                    </tr>
                    <tr>
                        <td>New password:</td>
                        <td><input type="password" name="newpassword"/></td>
                    </tr>
                    <tr>
                        <td>Confirm password:</td>
                        <td><input type="password" name="confirmpassword"/></td>
                    </tr>

                </table>
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