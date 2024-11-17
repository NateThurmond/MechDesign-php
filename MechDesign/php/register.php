<?php

    require_once("../config/config.php");
    require_once("../php/sqlPrepare.php");

    session_start();
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error " . mysqli_error($conn));

    // I NEED TO CHANGE ALL GET AND POST PHP VARIABLE GETS INTO THIS FORMAT TO PROTECT AGAINST CERTAIN ATTACKS
    $newName = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newPass = filter_input(INPUT_GET, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newConfirmPass = filter_input(INPUT_GET, 'confirmPass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newEmail = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
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

    $query = mysqli_prepare($conn, "SELECT * FROM members WHERE username = ? or email = ?");
    $result_of_login_check = bindFetch($query, [$newName, $newEmail]);

    if (count($result_of_login_check) != 0) {
        $nameError = "There is already a user with that name.";
    }

    if ( ($nameError == "") && ($passError == "") && ($passConfirmError == "") && (count($result_of_login_check) == 0) ) {

        $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);

        $insertQuery = mysqli_prepare($conn, "INSERT INTO members (`username`, `pwHash`, `email`) VALUES (?, ?, ?)");
        $result_of_insert_check = bindExecute($insertQuery, [$newName, $newPassHash, $newEmail]);

        //$retval = mysqli_query($conn, "INSERT INTO members (`id`, `username`, `password`, `email`) VALUES (NULL, '$newName', '$newPass', '$newEmail')");
        if(! $result_of_insert_check ) { die('Could not update data: ' . mysqli_error($conn)); }
            else {
                echo '
                    <form method="post" id="registerSuccess" name="form3" action="index.php">
                    <p>Registration successfull.</p><br>
                    <input type="hidden" id="myusername" name="user_name" value="'.$newName.'"/>
                        <input type="hidden" id="mypassword" name="user_password" value="'.$newPass.'"/>
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
