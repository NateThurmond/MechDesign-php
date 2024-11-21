<?php

/*
    Author: Nathan Thurmond
    Date: 9/14/2014
    Site Name: MechDesign
    Description: This is a work in progress that is meant to make it easier to design mechs for Battletech.
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
        <link rel='stylesheet' type='text/css' href='CSS/mechDesignPage.css' />
        <link rel='stylesheet' type='text/css' href='CSS/mechArmorDivs.css' />
        <link rel='stylesheet' type='text/css' href='CSS/mechDesignSideBar.css' />
        <link rel='stylesheet' type='text/css' href='CSS/mechWeaponsSideBar.css' />
        <link rel="icon" href="images/btAtlasSkull.png">
        <script type='text/javascript' src='JS/jquery.js'></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
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
                            <a class="navBarLink" href="index.php"> Home </a>
                        </div>
                    </td>
                    <td>
                        <div class="navButtons highlighted nav1" style="box-shadow: 0 0 8px #FFD700;">
                            <a href="#" style="text-decoration: none; color: white;">Mech Design <img src="images/arrowSmall.png" alt="none"/> </a> 
                        </div>
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
                                <li></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- BEGIN SIDE-BAR SECTION -->
        <div id="sidebar">
            <?php include("containers/mechsideBar.php"); ?> 
        </div>
        
        <!-- BEGIN MAIN SECTION -->
        <div id="main">
            
            <!-- THIS IS THE REGISTER FORM THAT IS HIDDEN UNTIL THE REGISTER BUTTON IS CLICKED -->
            <?php include("containers/registerForm.php") ?>
            
            <div id="mechHeader" >
                <form method="post" id="mechDetailsColumn">
                    <h1 class='mechFormHeaders'>Mech Name</h1>
                    <h1 class='mechFormHeaders mechModelInputHeader'>Model</h1>
                    <input type="text" class='mechDataInputBox' name="mechName" placeholder="">
                    <input type="text" class='mechDataInputBox' name="mechModel" placeholder="">
                    
                    <div id = mechHeaderLeftCol>
                        
                        <h4>Historical Data</h4>
                        <div class="detailsTextDisplay" id="mechDetails1">
                            <p><strong id="indMechEra">Era: </strong></p>
                            <p><strong id="indMechTechBase">Tech Base: </strong></p>
                            <p><strong id="indMechProdYear">Production Year: </strong></p>
                        </div>
                        
                        <h4>Engine Details</h4>
                        <div class="detailsTextDisplay" id="mechEngineDetails">
                            <p style="display: inline-block;"><strong>Engine: </strong> </p>
                            <select name="engineType" id="engineDropDown" onchange="updateEngine(this.value);">
                                <option value="XL Engine">XL Engine</option>
                                <option value="Fusion Engine">Fusion Engine</option>
                            </select>
                            <div style="margin-top: -6px; height: 15px;">
                                <p style="display: inline-block;">
                                    <strong>Engine Rating: &nbsp</strong>
                                </p>
                                <p id="mechEngineRating" style="display: inline-block;"></p>
                            </div>

                            <div id=mechWalk>Walk:
                                <p style="display: inline-block; font-weight: normal;"></p>
                                <input type="text" class="movementValues" style="margin-left: 2px;" value="5" readonly/>
                                <img src="images/upArrow2.png" class="upMovementArrow" id="upArrowWalk" />
                                <img src="images/downArrow2.png" class="downMovementArrow" id="downArrowWalk" />
                            </div>
                            <div id=mechRun>Run:&nbsp
                                <p style="display: inline-block; font-weight: normal;"></p>
                                <input type="text" style="margin-left: 4px;"class="movementValues" value="8" readonly/>
                            </div>
                            <div id=mechJump>Jump:
                                <p style="display: inline-block; font-weight: normal;"></p>
                                <input type="text" class="movementValues" value="5" readonly/>
                                <img src="images/upArrow2.png" class="upMovementArrow" id="upArrowJump" />
                                <img src="images/downArrow2.png" class="downMovementArrow" id="downArrowJump" />
                            </div>
                        </div>
                        
                        <h4>Tonnage</h4>
                        <div class="detailsTextDisplay" id="mechTonnage">
                            <p style="display: inline-block;">Tonnage:</p>
                            <select class="dropDownSelectors" id="mechTonnageDropDown" name="mechTonnageDropDown" onchange="changeMechTotalTonnage($(this).val()); "></select>
                            <p style="font-weight: normal; margin-top: -4px;"><strong>Mech Type:</strong> BattleMech</p>
                            <p id="totalWeight" style="font-weight: normal; margin-top: -6px;"></p>
                        </div>
                        
                        <h4>Heat Sinks</h4>
                        <div class="detailsTextDisplay" id="heatSinkContainer">
                            <p style="display: inline-block;">Heat Sink Type:</p>
                            <select class="dropDownSelectors" id="heatSinkTypeDropDown" name="heatSinkTypeDropDown" onchange="updateHeatSinksJSON(true)">
                                <option>Singles</option>
                                <option>Doubles</option>
                            </select>
                            <p style="display: inline-block;">Heat Sinks Total:</p>
                            <select class="dropDownSelectors" id="heatSinkNumDropDown" name="heatSinkNumDropDown" onchange="updateHeatSinksJSON('changeNum', this.value)">
                            </select>
                            <p style="display: inline-block;">Heat Dissipation:</p>
                            <p id="heatDissipation" style="display: inline-block; font-weight: normal;"><p>
                        </div>
                        
                    </div>
                    
                    <div class="detailsTextDisplay" id="mechDetails">
                        <img src='' onerror="this.src='images/customMechLogo.jpg'" alt="Custom Mech"/>
                    </div>
                    
                    <div id="internalsCriticals">                       
                        <!-- BEGIN MECH INTERNALS AND CRITICALS TABLE -->    
                        <?php include("containers/mechInternalsCriticalsTable.php"); ?> 
                    </div>
                    
                    <input type="submit" class="submitChanges" name="mechChangeSubmit" value='Save Changes'/>
                </form>
            </div>
            
            <!-- THIS SECTION IS FILLED IN DYNAMICALLY FROM THE GET MECH ARMOR.PHP PAGE -->
            <div id="mechArmor">
                <div id="arm">
                    <div id="leftArmArmor"></div>
                    <div id="rightArmArmor"></div>
                    <div id="leftArmArmorNumeric"></div>
                    <div id="rightArmArmorNumeric"></div>
                </div>
                <div id="head">
                    <div id="mechHeadArmor"></div>
                    <div id="mechHeadArmorNumeric"></div>
                </div>
                <div id="center">
                    <div id="centerArmorNumeric"></div>
                    <div id="centerRearArmorNumeric"></div>
                    <div id="centerArmor"></div>
                    <div id="centerRearArmor"></div>
                </div>
                <div id="torso">
                    <div id="leftTorsoArmorNumeric"></div>
                    <div id="rightTorsoArmorNumeric"></div>
                    <div id="leftRearTorsoArmorNumeric"></div>
                    <div id="rightRearTorsoArmorNumeric"></div>
                    <div id="leftTorsoArmorTop"></div>
                    <div id="leftTorsoArmorMiddle"></div>
                    <div id="leftTorsoArmorBottom"></div>
                    <div id="rightTorsoArmorTop"></div>
                    <div id="rightTorsoArmorMiddle"></div>
                    <div id="rightTorsoArmorBottom"></div>
                    <div id="leftRearTorsoArmor"></div>
                    <div id="rightRearTorsoArmor"></div>
                </div>
                <div id="leg">
                    <div id="leftLegArmorNumeric"></div>
                    <div id="rightLegArmorNumeric"></div>
                    <div id="leftLegArmor"></div>
                    <div id="rightLegArmor"></div>
                </div>
            </div>
            
        </div>
        
        <!-- BEGIN FOOTER SECTION -->
        <div id="footer">
            <img src="images/copyright.png" alt="none">
            <p class="footerTabs">Privacy Policy  &nbsp&nbsp&nbsp  <strong>|</strong></p>
            <p class="footerTabs">About me  &nbsp&nbsp&nbsp  <strong>|</strong></p>
        </div>
        
    </body>
</html>
