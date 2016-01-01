


    <div id="login">
  
        <?php 
            if ( !(isset($_SESSION['myusername'])) ) {
                
                echo '
                    <form method="post" name="form1" action="c:\MechDesignConfig\php_Global_Vars_and_DB_Conn.php">
                        <p><strong>Member Login</strong></p>

                        <input type="text" id="myusername" name="myusername" placeholder="Username" />
                        <input type="password" id="mypassword" name="mypassword" placeholder="Password"/>
                        <input type="image" name="Submit" src="images/login2.png" alt="none" style="margin-top: 10px;"/>
                        <img src="images/register3.png" class="registerButton" alt="none" style="cursor: pointer;"/>
                    </form>
                ';                
            }
            else {
                echo '<p id=welcomeText><strong>Welcome</strong></p>'
                . '<p id="userNameShowing"><strong>'
                . $_SESSION['myusername']
                . '</strong></p>'        
                . '<br> <div id="logoutButton"> <a href=phpIncludes/Logout.php> <img src="images/logout3.png" /> </a> </div>';
            }
        ?>
    </div>
    <div id="news">
        <h2>Latest News</h2>
        <img id="newsIcons" src="images/news.gif" alt="none" />
        <p class="navNews">Added functionality for changing loadouts on the fly. This includes the ability to modify mechs from the intro box set.</p>
        <img id="newsIcons" src="images/news.gif" alt="none" />
        <p class="navNews">Save mechs from your current edits or start from scratch with an intro box set mech. Fully customizable through star-league era.</p>
        <img id="newsIcons" src="images/news.gif" alt="none" />
        <p class="navNews">Added ability to save mechs or load from saved designs. Choose from any of the 24 loadouts included in the box-set.</p>
    </div>
