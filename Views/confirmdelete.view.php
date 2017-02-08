<?php
    $this->view('header', compact('title'));
?>

<?php
    $this->view('sidebar', compact('admin'));
?>

<div id="content">
    <div id="accountsettings">
        <div style="font-size:x-large">
            Are you sure you want to delete user <?php echo $user_id; ?>?
        </div>
        <p>
            <div style="font-size:large">
                <table style="width:60%">
                    <tr>
                        <td> First name: </td>
                        <td> <?php echo $firstname; ?> </td>
                    </tr>
                    <tr>
                        <td> Last name: </td>
                        <td> <?php echo $lastname; ?>  </td>
                    </tr>
                    <tr>
                        <td> Phone: </td>
                        <td> <?php echo $phone; ?>  </td>
                    </tr>
                    <tr>
                        <td> Email: </td>
                        <td> <?php echo $email; ?>  </td>
                    </tr>
                    <tr>
                        <td><a href="/userconfiguration/<?php echo $user_id ?>/yes" class="button">Yes</a></td>
                        <td><a href="/userconfiguration" class="button">No</a></td>
                    </tr>
                </table>
            </div>
        </p>

    </div>
</div>

<?php
    $this->view('footer', compact('title'));
?>