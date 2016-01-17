<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["user_name"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        require_once("config/gv.php");

        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                
                $sql = mysqli_prepare($this->db_connection, "SELECT * FROM members WHERE username = ? OR email = ?");
                $result_of_login_check = bindFetch($sql, [$user_name, $user_name]);
                
                // if this user exists
                if (count($result_of_login_check) == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check[0];
                    $loginCount = $result_row['loginCount'];
                    
                    if ($loginCount < MAX_PASS_LOGIN) {
                        
                        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                        
                        // using PHP 5.5's password_verify() function to check if the provided password fits
                        // the hash of that user's password
                        if (password_verify($_POST['user_password'], $result_row['pwHash'])) {

                            $globalVars = new stdClass();
                            $globalVars->user_name = $result_row['username'];
                            $globalVars->timeStamp = time();
                            $globalVars->user_email = $result_row['email'];
                            $globalVars->user_login_status = 1;
                            $globalVars->user_id = $result_row['id'];
                            $globalVars->firstName = $result_row['firstName'];
                            $globalVars->lastName = $result_row['lastName'];

                            foreach ($globalVars as $key => $val) {
                                $GLOBALS[$key] = $val;
                            }

                            $cook = getUUID();
                            setcookie("UUID", $cook, time() + TIMEOUT);

                            $updateLoginQuery = mysqli_prepare($conn, "UPDATE `members` SET `loginCount`=0, `timeStamp`=now(), `gv`=?, `uuid`=?  WHERE `username`=?");
                            $resultUpdate = bindExecute($updateLoginQuery, [json_encode($globalVars), $cook, $user_name]);
                            mysqli_stmt_close($updateLoginQuery);

                            header("Location: index.php");
                        } else {
                            // Increment the login_count
                            $loginCount++;
                            $updateLoginQuery = mysqli_prepare($conn, "UPDATE `members` SET `loginCount`=? WHERE `username`=?");
                            $resultUpdate = bindExecute($updateLoginQuery, [$loginCount, $user_name]);
                            mysqli_stmt_close($updateLoginQuery);
                            
                            if ($loginCount == MAX_PASS_LOGIN) {
                                $this->errors[] = "Account locked, too many attempts. Contact support for assitance";
                            } else {
                                $this->errors[] = "Wrong username or password.";
                            }
                        }
                    } else {
                        // Log the attempt, account is locked out due to many attempts
                        $this->errors[] = "Account locked, too many attempts. Press the help button for assistance";
                    }
                } else {
                    $this->errors[] = "Wrong username or password.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        require_once("config/gv.php");
        
        date_default_timezone_set("UTC");
        $now = date('Y-m-d H:i:s');

        $conn2 = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

        if (isset($_COOKIE["UUID"])) {
            if ($_COOKIE["UUID"] != "") {

                $updateLoginQuery = mysqli_prepare($conn2, "UPDATE `members` SET `gv`='', `uuid`=''  WHERE `uuid`=?");
                $resultUpdate = bindExecute($updateLoginQuery, [$_COOKIE['UUID']]);
                mysqli_stmt_close($updateLoginQuery);
            }
        }

        $conn2->close();
        unsetGV();
        setcookie("UUID", "", time()-99999);
        
        // return feeedback message
        $this->messages[] = "You have been logged out.";
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        require_once("config/gv.php");
        
        if (isset($_COOKIE["UUID"])) {
            
            if ($_COOKIE["UUID"] != "") {

                $userConn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

                $getUUIDsql = mysqli_prepare($userConn, "SELECT uuid, gv FROM members WHERE uuid = ?");
                $result = bindFetch($getUUIDsql, [$_COOKIE["UUID"]]);

                if (count($result) <= 0) {
                    // UUID's do not match.
                    return false;
                }
                else {
                    $gvs = json_decode($result[0]['gv']);

                    // create time was over 4 hours ago
                    if ($gvs->timeStamp <= time() - TIMEOUT) {

                        $delete_UUID_query = mysqli_prepare($userConn, "UPDATE `members` SET `gv`='', `uuid`=''  WHERE `uuid`=?");
                        $resultDelete = bindExecute($delete_UUID_query, [$_COOKIE['UUID']]);
                        mysqli_stmt_close($delete_UUID_query);

                        unsetGV();
                        setcookie("UUID", "", time()-99999);
                        return false;
                    }
                    // create time is recent
                    else {
                        $gvs->timeStamp = time();

                        foreach ($gvs as $key => $val) {
                            $GLOBALS[$key] = $val;
                        }

                        $update_GV_Query = mysqli_prepare($userConn, "UPDATE `members` SET `gv`=?, `timeStamp`=now() WHERE `uuid`=?");
                        $resultUpdate = bindExecute($update_GV_Query, [json_encode($gvs), $_COOKIE["UUID"]]);
                        mysqli_stmt_close($update_GV_Query);

                        return true;
                    }
                }

                $userConn->close();
            }
        }
        return false;
    }
}
