<?php

/*
    Author: Nathan Thurmond
    Date: 9/14/2014
    Updated: 11/22/2024
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
                        <a href="#" style="text-decoration: none; color: white;">Mech Design <img
                                src="images/arrowSmall.png" alt="none" /> </a>
                    </div>
                </td>
                <td>
                    <div class="navButtons highlighted nav2"> Resources <img src="images/arrowSmall.png" alt="none" />
                    </div>
                </td>
                <td>
                    <div class="navButtons highlighted nav4"><a class="navBarLink" href="contact.php"> Contact </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="center">
                    <div id="tabDiv">
                        <ul class="ul-1">
                            <li class="tabLinks"><a href="#" style="text-decoration: none;">Design a mech now!</a></li>
                            <li class="tabLinks"><a href="#" style="text-decoration: none;">See top rated mechs</a></li>
                            <li class="tabLinks"><a href="#" style="text-decoration: none;">See Intro set mechs</a></li>
                        </ul>
                    </div>
                </td>
                <td align="center">
                    <div id="tabDiv">
                        <ul class="ul-2">
                            <li class="tabLinks"><a href="http://camospecs.com/" target="_blank">Camo-Specs</a></li>
                            <li class="tabLinks"><a href="http://www.solarisskunkwerks.com/"
                                    target="_blank">Skunk-Werks</a></li>
                            <li class="tabLinks"><a href="http://www.battletech.com/" target="_blank">Battletech.com</a>
                            </li>
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
        <div id="login">

            <?php
            if ($login->isUserLoggedIn() == false) {

                echo '<form method="post" name="form1" action="index.php">
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
            } else {
                echo '<p id="welcomeText"><strong>Welcome</strong></p>
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
        <div id="mechsideBar">
            <p class='selector' id='mechSelector' onclick="pickMechs()">Select a different mech</p>
            <div class='popoutClass popoutTab'>Select a Mech
                <hr class='dividerBar' />

                <div id="mechSelect"></div>
            </div>

            <p class='selector' id='armorSelector'>Armor</p>
            <div class='popoutClass popoutTab2'>Increase External Armor
                <hr class='dividerBar' style="margin-top: -2px;" />

                <span id="torsoLeftInt" class="internalStructurePoints"
                    style="margin-top: 95px; margin-left: -63px;">25</span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftTorsoInc"
                    onclick="changeMechStats('torsoLeftArmor', 'increase', 'torso');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftTorsoDec"
                    onclick="changeMechStats('torsoLeftArmor', 'decrease', 'torso');" />

                <span id="torsoRightInt" class="internalStructurePoints"
                    style="margin-top: 95px; margin-left: 42px;">25</span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="RightTorsoInc"
                    onclick="changeMechStats('torsoRightArmor', 'increase', 'torso');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="RightTorsoDec"
                    onclick="changeMechStats('torsoRightArmor', 'decrease', 'torso');" />

                <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftRearTorsoInc"
                    onclick="changeMechStats('rearLeftTorsoArmor', 'increase', 'torso');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftRearTorsoDec"
                    onclick="changeMechStats('rearLeftTorsoArmor', 'decrease', 'torso');" />

                <img src="images/upRedArrow.png" class="downMovementArrow" id="RightRearTorsoInc"
                    onclick="changeMechStats('rearRightTorsoArmor', 'increase', 'torso');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="RightRearTorsoDec"
                    onclick="changeMechStats('rearRightTorsoArmor', 'decrease', 'torso');" />

                <img src="images/upRedArrow.png" class="downMovementArrow" id="centerRearTorsoInc"
                    onclick="changeMechStats('rearCenterArmor', 'increase', 'center');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="centerRearTorsoDec"
                    onclick="changeMechStats('rearCenterArmor', 'decrease', 'center');" />

                <span id="legRightInt" class="internalStructurePoints"
                    style="margin-top: 287px; margin-left: 47px;"></span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="RightLegInc"
                    onclick="changeMechStats('legRightArmor', 'increase', 'leg');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="RightLegDec"
                    onclick="changeMechStats('legRightArmor', 'decrease', 'leg');" />

                <span id="legLeftInt" class="internalStructurePoints"
                    style="margin-top: 286px; margin-left: -71px;"></span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftLegInc"
                    onclick="changeMechStats('legLeftArmor', 'increase', 'leg');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftLegDec"
                    onclick="changeMechStats('legLeftArmor', 'decrease', 'leg');" />

                <span id="centerArmorInt" class="internalStructurePoints"
                    style="margin-top: 129px; margin-left: -12px;"></span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="centerTorsoInc"
                    onclick="changeMechStats('centerArmor', 'increase', 'center');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="centerTorsoDec"
                    onclick="changeMechStats('centerArmor', 'decrease', 'center');" />

                <span id="headArmorInt" class="internalStructurePoints"
                    style="margin-top: 88px; margin-left: -12px;"></span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="headInc"
                    onclick="changeMechStats('headArmor', 'increase', 'head');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="headDec"
                    onclick="changeMechStats('headArmor', 'decrease', 'head');" />

                <span id="armLeftInt" class="internalStructurePoints"
                    style="margin-top: 94px; margin-left: -116px;"></span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftArmInc"
                    onclick="changeMechStats('armLeftArmor', 'increase', 'arm');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftArmDec"
                    onclick="changeMechStats('armLeftArmor', 'decrease', 'arm');" />

                <span id="armRightInt" class="internalStructurePoints"
                    style="margin-top: 94px; margin-left: 95px;"></span>
                <img src="images/upRedArrow.png" class="downMovementArrow" id="RightArmInc"
                    onclick="changeMechStats('armRightArmor', 'increase', 'arm');" />
                <img src="images/downRedArrow.png" class="downMovementArrow" id="RightArmDec"
                    onclick="changeMechStats('armRightArmor', 'decrease', 'arm');" />

                <h4><input type="checkbox" id="mirrorArmorBox" name="mirrorArmorBox" checked>Link armor locations</h4>
                <h4>
                    <p id="totalWeightArmorPage" style="font-weight: normal; margin-top: 9px;"></p>
                </h4>
            </div>

            <p class='selector' id='weaponSelector'>Weapons/Criticals</p>
            <div class='popoutClass popoutTab3'>Weapons / Criticals
                <hr class='dividerBar' />
                <div id="weaponAccordion">
                    <ul class="weaponAccordionTabs">
                        <li class="weaponAccordionLI">Energy
                            <ul id="weaponChild">
                                <li class="weaponChildLI" name="Small Laser">Small Laser</li>
                                <li class="weaponChildLI" name="Medium Laser">Medium Laser</li>
                                <li class="weaponChildLI" name="Large Laser">Large Laser</li>
                                <li class="weaponChildLI" name="PPC">PPC</li>
                                <li class="weaponChildLI" name="Flamer">Flamer</li>
                                <li class="weaponChildLI" name="Vehicle Flamer">Vehicle Flamer</li>
                            </ul>
                        </li>
                        <li class="weaponAccordionLI">Ballistics
                            <ul id="weaponChild">
                                <li class="weaponChildLI" name="Machine Gun">Machine Gun</li>
                                <li class="weaponChildLI" name="Autocannon 2">Autocannon 2</li>
                                <li class="weaponChildLI" name="Autocannon 5">Autocannon 5</li>
                                <li class="weaponChildLI" name="Autocannon 10">Autocannon 10</li>
                                <li class="weaponChildLI" name="Autocannon 20">Autocannon 20</li>
                            </ul>
                        </li>
                        <li class="weaponAccordionLI">Missiles
                            <ul id="weaponChild">
                                <li class="weaponChildLI" name="SRM-2">SRM-2</li>
                                <li class="weaponChildLI" name="SRM-4">SRM-4</li>
                                <li class="weaponChildLI" name="SRM-6">SRM-6</li>
                                <li class="weaponChildLI" name="LRM-5">LRM-5</li>
                                <li class="weaponChildLI" name="LRM-10">LRM-10</li>
                                <li class="weaponChildLI" name="LRM-15">LRM-15</li>
                                <li class="weaponChildLI" name="LRM-20">LRM-20</li>
                            </ul>
                        </li>
                        <li class="weaponAccordionLI">Ammunition
                            <ul id="weaponChild">
                                <li class="weaponChildLI" name="SRM-2 Ammo">SRM-2 Ammo</li>
                                <li class="weaponChildLI" name="SRM-4 Ammo">SRM-4 Ammo</li>
                                <li class="weaponChildLI" name="SRM-6 Ammo">SRM-6 Ammo</li>
                                <li class="weaponChildLI" name="LRM-5 Ammo">LRM-5 Ammo</li>
                                <li class="weaponChildLI" name="LRM-10 Ammo">LRM-10 Ammo</li>
                                <li class="weaponChildLI" name="LRM-15 Ammo">LRM-15 Ammo</li>
                                <li class="weaponChildLI" name="LRM-20 Ammo">LRM-20 Ammo</li>
                                <li class="weaponChildLI" name="Machine Gun Ammo">Machine Gun Ammo</li>
                                <li class="weaponChildLI" name="Autocannon 2 Ammo">Autocannon 2 Ammo</li>
                                <li class="weaponChildLI" name="Autocannon 5 Ammo">Autocannon 5 Ammo</li>
                                <li class="weaponChildLI" name="Autocannon 10 Ammo">Autocannon 10 Ammo</li>
                                <li class="weaponChildLI" name="Autocannon 20 Ammo">Autocannon 20 Ammo</li>
                                <li class="weaponChildLI" name="Vehicle Flamer Ammo">Vehicle Flamer Ammo</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="critContainers" id="leftArmCrits">Left Arm
                    <table class="critSlots" id="leftArmCritTable"></table>
                </div>

                <div class="critContainers" style="background-color: grey;">
                    <div id="leftTorsoCrits" style="display: block;">Left Torso
                        <table class="critSlots" id="leftTorsoCritTable"></table>
                    </div>
                    <div id="leftLegCrits" style="display: block;">Left Leg
                        <table class="critSlots" id="leftLegCritTable"></table>
                    </div>
                </div>

                <div class="critContainers" style="background-color: grey;">
                    <div id="headCrits" style="display: block;">Head
                        <table class="critSlots" id="headCritTable"></table>
                    </div>
                    <div id="torsoCrits" style="display: block;">Center Torso
                        <table class="critSlots" id="centerCritTable"></table>
                    </div>
                </div>

                <div class="critContainers" style="background-color: grey;">
                    <div id="rightTorsoCrits">Right Torso
                        <table class="critSlots" id="rightTorsoCritTable"></table>
                    </div>
                    <div id="rightLegCrits">Right Leg
                        <table class="critSlots" id="rightLegCritTable"></table>
                    </div>
                </div>

                <div class="critContainers" id="rightArmCrits">Right Arm
                    <table class="critSlots" id="rightArmCritTable"></table>
                </div>

                <table id="weaponInfo">
                    <tr id="weaponDetailsHeader">
                        <td>Weapon Name</td>
                        <td>Damage</td>
                        <td>Heat</td>
                        <td>Min. Range</td>
                        <td>Short Range</td>
                        <td>Med. Range</td>
                        <td>Long Range</td>
                        <td>Tons</td>
                        <td>Slots Required</td>
                        <td>Ammo Needed</td>
                        <td>Weapon Type</td>
                        <td>Avail. Date</td>
                    </tr>
                    <tr id="weaponDetails">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>

            </div>

            <p class='selector' id='criticalSelector'>Save Mech</p>
            <!-- This pop-out isn't fully thought out so just tie it to the other save button -->
            <!-- <div class='popoutClass popoutTab4'> -->

        </div>

    </div>

    </div>

    <!-- BEGIN MAIN SECTION -->
    <div id="main">

        <!-- THIS IS THE REGISTER FORM THAT IS HIDDEN UNTIL THE REGISTER BUTTON IS CLICKED -->
        <?php include("containers/registerForm.php") ?>

        <div id="mechHeader">
            <form method="post" id="mechDetailsColumn">
                <h1 class='mechFormHeaders'>Mech Name</h1>
                <h1 class='mechFormHeaders mechModelInputHeader'>Model</h1>
                <input type="text" class='mechDataInputBox' name="mechName" placeholder="">
                <input type="text" class='mechDataInputBox' name="mechModel" placeholder="">

                <div id=mechHeaderLeftCol>

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
                            <input type="text" class="movementValues" style="margin-left: 2px;" value="5" readonly />
                            <img src="images/upArrow2.png" class="upMovementArrow" id="upArrowWalk" />
                            <img src="images/downArrow2.png" class="downMovementArrow" id="downArrowWalk" />
                        </div>
                        <div id=mechRun>Run:&nbsp
                            <p style="display: inline-block; font-weight: normal;"></p>
                            <input type="text" style="margin-left: 4px;" class="movementValues" value="8" readonly />
                        </div>
                        <div id=mechJump>Jump:
                            <p style="display: inline-block; font-weight: normal;"></p>
                            <input type="text" class="movementValues" value="5" readonly />
                            <img src="images/upArrow2.png" class="upMovementArrow" id="upArrowJump" />
                            <img src="images/downArrow2.png" class="downMovementArrow" id="downArrowJump" />
                        </div>
                    </div>

                    <h4>Tonnage</h4>
                    <div class="detailsTextDisplay" id="mechTonnage">
                        <p style="display: inline-block;">Tonnage:</p>
                        <select class="dropDownSelectors" id="mechTonnageDropDown" name="mechTonnageDropDown"
                            onchange="changeMechInternalTonnage($(this).val()); "></select>
                        <p style="font-weight: normal; margin-top: -4px;"><strong>Mech Type:</strong> BattleMech</p>
                        <p id="totalWeight" style="font-weight: normal; margin-top: -6px;"></p>
                    </div>

                    <h4>Heat Sinks</h4>
                    <div class="detailsTextDisplay" id="heatSinkContainer">
                        <p style="display: inline-block;">Heat Sink Type:</p>
                        <select class="dropDownSelectors" id="heatSinkTypeDropDown" name="heatSinkTypeDropDown"
                            onchange="updateHeatSinksJSON(true)">
                            <option>Singles</option>
                            <option>Doubles</option>
                        </select>
                        <p style="display: inline-block;">Heat Sinks Total:</p>
                        <select class="dropDownSelectors" id="heatSinkNumDropDown" name="heatSinkNumDropDown"
                            onchange="updateHeatSinksJSON('changeNum', this.value)">
                        </select>
                        <p style="display: inline-block;">Heat Dissipation:</p>
                        <p id="heatDissipation" style="display: inline-block; font-weight: normal;">
                        <p>
                    </div>

                </div>

                <div class="detailsTextDisplay" id="mechDetails">
                    <img src='' onerror="this.src='images/customMechLogo.jpg'" alt="Custom Mech" />
                </div>

                <div id="internalsCriticals">
                    <!-- BEGIN MECH INTERNALS AND CRITICALS TABLE -->
                    <h4 style="margin-left: -7px;">Internals/Criticals</h4>
                    <div id="internalsCriticalsContainer">
                        <table id="internalsTable">
                            <tr style="padding-left: -20px;">
                                <td style="border: none;"></td>
                                <td><strong>Tons</td>
                                <td><strong>Crits</td>
                            </tr>
                            <tr>
                                <td><strong>Internals</td>
                                <td id="internalsTonnage"></td>
                                <td id="InternalsCriticalsTableData"></td>
                            </tr>
                            <tr>
                                <td><strong>Engine</td>
                                <td id="engineTonnage"></td>
                                <td id="engineCriticals">this</td>
                            </tr>
                            <tr>
                                <td><strong>Gyro</td>
                                <td id="gyroTonnage"></td>
                                <td id="gyroCriticals">this</td>
                            </tr>
                            <tr>
                                <td><strong>Cockpit</td>
                                <td id="cockpitTonnage"></td>
                                <td id="cockpitCriticals">this</td>
                            </tr>
                            <tr>
                                <td><strong>Heat Sinks</td>
                                <td id="heatSinksTonnage"></td>
                                <td id="heatSinksCriticals">this</td>
                            </tr>
                            <tr>
                                <td><strong>Enhancements</td>
                                <td id="enhancementsTonnage"></td>
                                <td id="enhancementsCriticals">this</td>
                            </tr>
                            <tr>
                                <td><strong>JumpJets</td>
                                <td id="jumpJetsTonnage"></td>
                                <td id="jumpJetsCriticals">this</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <input type="submit" class="submitChanges" name="mechChangeSubmit" value='Save Changes' />
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
        <p class="footerTabs">Privacy Policy &nbsp&nbsp&nbsp <strong>|</strong></p>
        <p class="footerTabs">About me &nbsp&nbsp&nbsp <strong>|</strong></p>
    </div>

</body>

</html>