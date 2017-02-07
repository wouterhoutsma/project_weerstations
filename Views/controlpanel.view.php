<?php
$title = "controlpanel";
$this->view('header', compact('title')); ?>



<?php
$this->view('sidebar');
?>
    <div id="content">
        <div id="accountsettings">
            <form>
                <label>Name:</label> <input type="text" name="name"/><br>
                <label>Address:</label> <input type="text" name="address/"><br>
                <label>Phone number:</label> <input type="text" name="phonenumber"/><br>
                <label>Email address:</label> <input type="text" name="emailaddress"/><br>
                <br>
                For changing your current password, <br>
                fill in your old password and a new password.<br>
                <br>
                <label>Old password:</label> <input type="password" name="oldpassword"/><br>
                <label>New password:</label> <input type="password" name="newpassword"/><br>
                <label>Confirm password:</label> <input type="password" name="confirmpassword"/><br>
                <input type="file" name="profilepicture"/><br>
                <input type="submit" class="button" value="Save"/>
            </form>
        </div>
    </div>

<?php
    $this->view('footer');
?>