<!DOCTYPE html>
<!--
Author: Nathan Thurmond
Date: 7/12/2014
Site Name: N8Home
Description: The contact me page for my site. Am currently using it to try out a comments sections.
-->

<?php

    require_once("config/config.php");
    include("php/DB_Conn.php");
    
    $_SESSION['pageOn']=3;
    
        
    $MechID;
    
    if(isset($_GET['mechIDPassed'])){    // Check to see if a mechID was passed to this page in the URL
        $MechID = $_GET['mechIDPassed'];
        $_SESSION['mechID'] = $MechID;
    }
    else if (!isset($MechID)){    // If a mech ID wasn't passed this is the 1st this page loaded, select 1st mech.
        $MechID = 1;
        $_SESSION['mechID'] = $MechID;
    }
    

    if(isset($_GET['wrongPass'])){    // Check to see if a login check was passed to this page in the URL
        $wrongPass = $_GET['wrongPass'];
        
        if ($wrongPass == 1) {
            echo "<div id='loginInfo' style='display: block'>Error - Invalid username or password</div>";
        }
        else if ($wrongPass == 0) {
            echo "<div id='loginInfo' style='display: block'>You have succesfully logged in</div>";
            unset($wrongPass);
        }
        else if ($wrongPass == 2) {
            echo "<div id='loginInfo' style='display: block'>You have been logged out</div>";
            unset($wrongPass);
        }
        else {
            unset($wrongPass);
        }
    }
    
    $conn->close();
?>


<html>
    <head>
        <title>MechDesign</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel='stylesheet' type='text/css' href='CSS/style.css' />
        <link rel='stylesheet' type='text/css' href='CSS/mechDesignPage.css' />
        <link rel='stylesheet' type='text/css' href='CSS/mechArmorDivs.css' />
        <link rel='stylesheet' type='text/css' href='CSS/mechDesignSideBar.css' />
        <script type='text/javascript' src='JS/jquery.js'></script>
        <script type='text/javascript' src='JS/jscriptMain.js'></script>
        <script type='text/javascript' src='JS/jscriptMechDesign.js'></script>    
    </head>
    <body>
        
        <!-- BEGIN HEADER SECTION -->
        <div id="navBar">
            <table>
                <tr>
                    <td>
                        <div class="navButtons highlighted nav0">
                            <a class="navBarLink" href="index.php?mechIDPassed=<?php echo $_SESSION['mechID']; ?>"> Home </a>
                        </div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav1"><a class="navBarLink" href="mechDesign.php?mechIDPassed=<?php echo $_SESSION['mechID']; ?>">Mech Design <img src="images/arrowSmall.png" alt="none"/> </a> </div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav2"> Resources <img src="images/arrowSmall.png" alt="none"/></div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav4" style="box-shadow: 0 0 8px #FFD700;" ><a class="navBarLink" href="#"> Contact </a></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center">
                        <div id="tabDiv">
                            <ul class="ul-1">
                                <li class="tabLinks" ><a href="#" style="text-decoration: none;">Design a mech now!</a></li>
                                <li class="tabLinks" ><a href="#" style="text-decoration: none;">See top rated mechs</a></li>
                                <li class="tabLinks" ><a href="#" style="text-decoration: none;">See Intro set mechs</a></li>
                            </ul>
                        </div>
                    </td>
                    <td align="center">
                        <div id="tabDiv">
                            <ul class="ul-2">
                                <li class="tabLinks" ><a href="http://camospecs.com/" >Camo-Specs</a></li>
                                <li class="tabLinks" ><a href="http://www.solarisskunkwerks.com/" >Skunk-Werks</a></li>
                                <li class="tabLinks" ><a href="http://www.battletech.com/" >Battletech.com</a></li>
                            </ul>
                        </div>
                    </td>
                    <td align="center">
                        <div id="tabDiv">
                            <ul class="ul-3">
                                <li>this</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- BEGIN SIDE-BAR SECTION -->
        <div id="sidebar">
            <?php include("sideBarMainPage.php"); ?> 
        </div>
        
        <div id="main">
            
            <?php include("containers/registerForm.php") ?>
            
            <h2 class="head1">Comments Section</h2>
                <textarea name="comments" id="commentBox" placeholder="Enter comments here"></textarea>
                <input type="submit" id="commentSubmit" style="display: block; margin : 0 auto; margin-top: 8px;"/>
                <div id="commentArea" style="margin-top: 40px;"></div>
        </div>
        
        <div id="footer">
            <img src="images/copyright.png" alt="none">
            <p class="footerTabs">Privacy Policy  &nbsp&nbsp&nbsp  <strong>|</strong></p>
            <p class="footerTabs">About me  &nbsp&nbsp&nbsp  <strong>|</strong></p>
        </div>
    </body>
</html>