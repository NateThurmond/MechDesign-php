<!DOCTYPE html>
<!--
Author: Nathan Thurmond
Date: 7/12/2014
Site Name: N8Home
Description: This site is used to edit mechs for the board game battletech. You can customize
        your mechs according to the introductory rules and then print out the mech sheet
        or save the mech to your profile.
-->

<?php

    require_once("config/config.php");
    include("php/sqlPrepare.php");
    include("classes/login.php");

    $login = new Login();
?>

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
            <?php include("containers/sideBar.php"); ?> 
        </div>
        
        <!-- BEGIN MAIN SECTION -->
        <div id="main">
            
            <?php include("containers/registerForm.php") ?>
            
            <img src="images/madcatblueprint.jpg" id="madcatPic" alt="none"/>
            <h1 class="head1"><em>"I can't work miracles, sir! If you want an extra two tons of armor, you gotta lose two medium lasers." </em></h1>
            <h1 class="head1" style="font-size: 15px;"><em>- Sergeant Marty Rumble, 10th Lyran Guards</em></h1>         
        </div>
        
        <!-- BEGIN FOOTER SECTION -->
        <div id="footer">
            <img src="images/copyright.png" alt="none">
            <p class="footerTabs">Privacy Policy  &nbsp&nbsp&nbsp  <strong>|</strong></p>
            <p class="footerTabs">About me  &nbsp&nbsp&nbsp  <strong>|</strong></p>
        </div>
    </body>
</html>
