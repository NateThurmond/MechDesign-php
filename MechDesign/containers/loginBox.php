<div id="login">

    <?php
    if ($login->isUserLoggedIn() == false) {
        echo 
            '<form method="post" name="form1" action="index.php">
            <p><strong>Member Login</strong></p>

            <input type="text" id="user_name" name="user_name" placeholder="Username" />
            <input type="password" id="user_password" name="user_password" placeholder="Password" />
            <input type="image" name="login" src="images/login2.png" alt="none" style="margin-top: 10px;" />
            <img src="images/register3.png" class="registerButton" alt="none" style="cursor: pointer;" />';

        if (isset($login)) {
            if ($login->errors) {
                foreach ($login->errors as $error) {
                    echo '<p id="error">' . $error . '</p>';
                }
            }
            if ($login->messages) {
                foreach ($login->messages as $message) {
                    echo '<p id="error">' . $message . '</p>';
                }
            }
        }
        echo '</form>';
    }
    else {
        echo 
            '<p id="welcomeText"><strong>Welcome</strong></p>
            <p id="userNameShowing">
            <strong>' . $GLOBALS['user_name'] . '</strong>
            </p>
            <form method="post" name="form2" action="index.php">
            <br>
            <div id="logoutButton"> <a name="logout" href="index.php?logout"> <img src="images/logout3.png" /> </a> </div>
            </form>';
    }
    ?>

</div>
