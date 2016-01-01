<?php

    include("php_Global_Vars_and_DB_Conn.php");

    // I NEED TO CHANGE ALL GET AND POST PHP VARIABLE GETS INTO THIS FORMAT TO PROTECT AGAINST CERTAIN ATTACKS
    $newName = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
    $newPass = filter_input(INPUT_GET, 'pass', FILTER_SANITIZE_STRING);
    $newConfirmPass = filter_input(INPUT_GET, 'confirmPass', FILTER_SANITIZE_STRING);
    $newEmail = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_STRING);
    
    if (empty($newName)) {
        $nameError = "Error, name cannot be left blank.";
    }
    else { $nameError = ""; }
    
    if (empty($newPass)) {
        $passError = "Error, password cannot be left blank.";
    }
    else { $passError = ""; }
    
    if (empty($newConfirmPass)) {
        $passConfirmError = "Error, please confirm password.";
    }
    else { $passConfirmError = ""; }
    
    if ( ($newPass !== $newConfirmPass) && (!empty($newConfirmPass)) && (!empty($newPass)) ) {
        $passError = "Error, Passwords do not match.";
        $passConfirmError = "";
    }
    
    $query = "SELECT * FROM members WHERE username = '$newName'";
    $isUser = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($isUser) > 0) {
        $nameError = "There is already a user with that name.";
    }
    
    if ( ($nameError == "") && ($passError == "") && ($passConfirmError == "") && (mysqli_num_rows($isUser) == 0) ) {

        $retval = mysqli_query($conn, "INSERT INTO members (`id`, `username`, `password`, `email`) VALUES (NULL, '$newName', '$newPass', '$newEmail')");
            if(! $retval ) { die('Could not update data: ' . mysqli_error($conn)); }
            else {
                echo '
                    <form method="post" id="registerSuccess" name="form1" action="c:\MechDesignConfig\php_Global_Vars_and_DB_Conn.php">
                    <p>Registration successfull.</p><br>
                    <input type="hidden" id="myusername" name="myusername" value="'.$newName.'"/>
                        <input type="hidden" id="mypassword" name="mypassword" value="'.$newPass.'"/>
                    <input type="submit" value="Continue"/>
                    </form>
                ';
            }
    }
    
    
    else {
       echo '
        <form method="post" id="registerForm">
        <ul>
            <li>
                <input type="text" id="registerName" name="registerName" value="'.$newName,'"/> <p>Username</p>         
            </li>
            <li id="registerNameError" class="registerError">'.$nameError.'</li>
            <li>
                <input type="text" id="registerEmail" name="registerEmail" value="'.$newEmail,'"/> <p>Email</p>         
            </li>
            <li class="registerError"></li>
            <li>
                <input type="text" id="registerPassword" name="registerPassword" /> <p>Password</p>         
            </li>
            <li id="passwordError" class="registerError">'.$passError.'</li>
            <li>
                <input type="text" id="confirmPassword" name="confirmPassword" /> <p>Confirm Password</p>         
            </li>
            <li id="confirmPasswordError" class="registerError">'.$passConfirmError.'</li>
            
        </ul>
    </form>
        <input type="submit" class="submitRegistration" name="registerSubmit" value="Register" onclick="checkFormData()"/>
        <button class="registerButton2" onclick="clearForm()">Cancel</button>
    ';
    }
    
    $conn->close();
