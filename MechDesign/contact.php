<?php

/*
    Author: Nathan Thurmond
    Date: 7/12/2014
    Site Name: N8Home
    Description: The contact me page for my site. Am currently using it to try out a comments sections.
*/

require_once("config/config.php");
include("php/sqlPrepare.php");
include("classes/login.php");

$login = new Login();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>MechDesign</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel='stylesheet' type='text/css' href='CSS/style.css' />
        <script type='text/javascript' src='JS/jquery.js'></script>
        <script type='text/javascript' src='JS/jscriptMain.js'></script>
    </head>
    <body>
        
        <!-- BEGIN HEADER SECTION -->
        <div id="navBar">
            <table>
                <tr>
                    <td>
                        <div class="navButtons highlighted nav0" style="box-shadow: 0 0 8px #FFD700;">
                            <a href="#" style="text-decoration: none; color: white; "> Home </a>
                        </div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav1"><a class="navBarLink" href="mechDesign.php">Mech Design <img src="images/arrowSmall.png" alt="none"/> </a> </div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav2"> Resources <img src="images/arrowSmall.png" alt="none"/></div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav4"><a class="navBarLink" href="contact.php"> Contact </a></div>
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
                                <li class="tabLinks" ><a href="http://camospecs.com/" target="_blank">Camo-Specs</a></li>
                                <li class="tabLinks" ><a href="http://www.solarisskunkwerks.com/" target="_blank">Skunk-Werks</a></li>
                                <li class="tabLinks" ><a href="http://www.battletech.com/" target="_blank">Battletech.com</a></li>
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
            <?php include("containers/sideBar.php"); ?>
        </div>
        
        <!-- BEGIN MAIN SECTION -->
        <div id="main">
            
            <?php include("containers/registerForm.php") ?>
            
            <h2 class="head1">Comments Section</h2>
                <textarea name="comments" id="commentBox" placeholder="Enter comments here"></textarea>
                <input type="submit" id="commentSubmit" style="display: block; margin : 0 auto; margin-top: 8px;"/>
                <div id="commentArea" style="margin-top: 40px;"></div>
        </div>
        
        <!-- BEGIN FOOTER SECTION -->
        <div id="footer">
            <img src="images/copyright.png" alt="none">
            <p class="footerTabs">Privacy Policy  &nbsp&nbsp&nbsp  <strong>|</strong></p>
            <p class="footerTabs">About me  &nbsp&nbsp&nbsp  <strong>|</strong></p>
        </div>
    </body>
</html>