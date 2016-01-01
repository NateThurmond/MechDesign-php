<!DOCTYPE html>
<!--
Author: Nathan Thurmond
Date: 9/14/2014
Site Name: MechDesign
Description: This is a work in progress that is meant to make it easier to design mechs for Battletech.
-->

<?php
    
    include("c:\MechDesignConfig\php_Global_Vars_and_DB_Conn.php");
    
    $_SESSION['pageOn']=2;
    
    $MechID;
    
    if(isset($_GET['mechIDPassed'])){    // Check to see if a mechID was passed to this page in the URL
        $MechID = $_GET['mechIDPassed'];
        $_SESSION['mechID'] = $MechID;
    }
    else if (!isset($MechID)){    // If a mech ID wasn't passed this is the 1st this page loaded, select 1st mech.
        $MechID = 1;
        $_SESSION['mechID'] = $MechID;
    }
    
    /*The following three lines fetch mech details that are static variables that are uneditable by the user.
      If the user creates a new mech, they will be set as custom values.   */
    $queryMechDetails = "SELECT * FROM mechdetails WHERE mechID = $MechID;";
    $dataMechDetails = mysqli_query($conn, $queryMechDetails);
    $mechDetails = mysqli_fetch_array($dataMechDetails);

    
    $query = "SELECT * FROM mechs WHERE mechID = $MechID"; 
    $data = mysqli_query($conn, $query);
    
    $mech = mysqli_fetch_assoc($data);
    
    if (isset($_POST['mechChangeSubmit'])) {
    
        $newName = $_POST['mechName'];
        
        if ($newName != "") {  
            $retval = mysqli_query($conn, "UPDATE mechs SET mechName = '$newName' WHERE mechID = $MechID");        
            if(! $retval ) { die('Could not update data: ' . mysqli_error($conn)); } echo "Updated data successfully\n";
        }
        else { echo "Error - name cannot be left blank"; }    // NEED TO ADD ERROR CHECKING SO THEY CANNOT LEAVE FIELD BLANK.
        
        header("Location: mechDesign.php?mechIDPassed=$MechID");
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
        <link rel='stylesheet' type='text/css' href='CSS/mechWeaponsSideBar.css' />
        <script type='text/javascript' src='JS/jquery.js'></script>
        <script type='text/javascript' src='JS/jscriptMain.js'></script>
        <script type='text/javascript' src='JS/jscriptMechDesign.js'></script>
        
        <!-- Needed for Jquery Drag and Drop -->
        <!--script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        
    <script>

        $(document).ready(function() {


        var heatSinkNumOptions2 = [];
        for (var i = 10; i <= 65; i++) {
            heatSinkNumOptions2[i] = document.createElement("option");
            heatSinkNumOptions2[i].text = i;
            heatSinkNumOptions2[i].value = i;
            heatSinkNumOptions2[i].id = i;
            document.getElementById("heatSinkNumDropDown").appendChild(heatSinkNumOptions2[i]);
        }
        });


        function updateHeatSinksJSON(changeHeatSink, newHeatSinkNums) {

            if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp5=new XMLHttpRequest();
                }
                xmlhttp5.onreadystatechange=function() {
                if (xmlhttp5.readyState===4 && xmlhttp5.status===200) {
                    var heatSinkDataJSON = JSON.parse(xmlhttp5.response);

                    var heatSinkTypeOptions = document.createElement("option");
                        heatSinkTypeOptions.text = heatSinkDataJSON.heatSinkType;
                        heatSinkTypeOptions.value = heatSinkDataJSON.heatSinkType;
                        heatSinkTypeOptions.id = heatSinkDataJSON.heatSinkType;
                        heatSinkTypeOptions.selected = true;

                    var altHeatSinkOption = document.createElement("option");
                    altHeatSinkOption.id = "altHeatSink";

                    if (heatSinkDataJSON.heatSinkType == "Singles") {
                        altHeatSinkOption.text = "Doubles";
                    }
                    else {
                        altHeatSinkOption.text = "Singles";
                    }

                    $('#heatSinkTypeDropDown').find('option').remove().end();
                    document.getElementById("heatSinkTypeDropDown").appendChild(heatSinkTypeOptions);
                    document.getElementById("heatSinkTypeDropDown").appendChild(altHeatSinkOption);
                    document.getElementById("heatDissipation").innerHTML = '&nbsp' + heatSinkDataJSON.heatDissipation;

                    //document.getElementById("heatSinkNumDropDown").option[0].value = '&nbsp' + heatSinkDataJSON.heatDissipation;
                    //$('#heatSinkNumDropDown').val("val2");
                    //var e = document.getElementById("heatSinkNumDropDown");
                    //e.options[e.selectedIndex].value = heatSinkDataJSON.heatSinksNum;
                    $("#heatSinkNumDropDown").val(heatSinkDataJSON.heatSinksNum);
                    
                    updateTonnage();
                }
            };

            if ((changeHeatSink == false) || (changeHeatSink == null)) {
                xmlhttp5.open("GET","phpIncludes/getHeatSinkDataJSON.php",true);
            }
            else if (changeHeatSink == 'changeNum') {
                xmlhttp5.open("GET","phpIncludes/getHeatSinkDataJSON.php?newHeatSinkNums="+newHeatSinkNums, true);
                //prompt(newHeatSinkNums);
            }
            else if (changeHeatSink == true) {

                xmlhttp5.open("GET","phpIncludes/getHeatSinkDataJSON.php?changeHeatSink=true", true);
            }
            xmlhttp5.send();
        }
        
        
        function changeMechTotalTonnage(mechWeight) {
            
            if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp12=new XMLHttpRequest();
            }
            
            xmlhttp12.onreadystatechange=function() {
                if (xmlhttp12.readyState===4 && xmlhttp12.status===200) {
                    //document.getElementById('TEST2').innerHTML=xmlhttp12.responseText;
                    
                    //updateArmor("mechArmor");
                    //updateHeatSinksJSON(false);
                    updateTonnage();
                    updateEngine(1);
                    
                    var docID = 'mechTonnageSelect_' + mechWeight;
                    document.getElementById(docID).selected = true;
                }
            };

            xmlhttp12.open("GET","phpIncludes/changeMechTotalTonnage.php?tons="+mechWeight, true);
            xmlhttp12.send();
        }

    </script>
        
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
                                <li class="tabLinks" ><a href="http://camospecs.com/" >Camo-Specs</a></li>
                                <li class="tabLinks" ><a href="http://www.solarisskunkwerks.com/" >Skunk-Werks</a></li>
                                <li class="tabLinks" ><a href="http://www.battletech.com/" >Battletech.com</a></li>
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
            <?php include("mechsideBar.php"); ?> 
        </div>
        
        <!-- BEGIN MAIN SECTION -->
        <div id="main">
            
            <!-- THIS IS THE REGISTER FORM THAT IS HIDDEN UNTIL THE REGISTER BUTTON IS CLICKED -->
            <?php include("registerForm.php") ?>
            
            <div id="mechHeader" >
                <form method="post" id="mechDetailsColumn">
                    <h1 class='mechFormHeaders'>Mech Name</h1>
                    <h1 class='mechFormHeaders mechModelInputHeader'>Model</h1>
                    <input type="text" class='mechDataInputBox' name="mechName" placeholder="<?php echo $mech['mechName']; ?>">
                    <input type="text" class='mechDataInputBox' name="mechModel" placeholder="<?php echo $mech['modelNum']; ?>">
                    
                    <div id = mechHeaderLeftCol>
                        
                        <h4>Historical Data</h4>
                        <div class="detailsTextDisplay" id="mechDetails1">
                            <p><strong>Era: </strong> <?php echo $mechDetails['era']; ?></p>
                            <p><strong>Tech Base: </strong> <?php echo $mechDetails['techBase']; ?></p>
                            <p><strong>Production Year: </strong> <?php echo $mechDetails['productionYear']; ?></p>
                        </div>
                        
                        <h4>Engine Details</h4>
                        <div class="detailsTextDisplay" id="mechEngineDetails"></div>
                        
                        <h4>Tonnage</h4>
                        <div class="detailsTextDisplay" id="mechTonnage">
                            <p style="display: inline-block;"><strong>Tonnage:</p>
                            <select class="dropDownSelectors" id="mechTonnageDropDown" name="mechTonnageDropDown" onchange="changeMechTotalTonnage($(this).val()); "></select>
                            <p style="font-weight: normal; margin-top: -4px;"><strong>Mech Type:</strong> BattleMech</p>
                            <p id="totalWeight" style="font-weight: normal; margin-top: -6px;"></p>
                        </div>
                        
                        <h4>Heat Sinks</h4>
                        <div class="detailsTextDisplay" id="heatSinkContainer">
                            <p style="display: inline-block;">Heat Sink Type:</p>
                            <select class="dropDownSelectors" id="heatSinkTypeDropDown" name="heatSinkTypeDropDown" onchange="updateHeatSinksJSON(true)"></select>
                            <p style="display: inline-block;">Heat Sinks Total:</p>
                            <select class="dropDownSelectors" id="heatSinkNumDropDown" name="heatSinkNumDropDown" onchange="updateHeatSinksJSON('changeNum', this.value)">
                            </select>
                            <p style="display: inline-block;">Heat Dissipation:</p>
                            <p id="heatDissipation" style="display: inline-block; font-weight: normal;"><p>
                        </div>
                        
                    </div>
                    
                    <div class="detailsTextDisplay" id="mechDetails">
                        <img src='<?php echo $mech['mechLogoSrc']; ?>' onerror="this.src='images/customMechLogo.jpg'" alt="Custom Mech"/>
                    </div>
                    
                    <div id="internalsCriticals">                       
                        <!-- BEGIN MECH INTERNALS AND CRITICALS TABLE -->    
                        <?php include("mechInternalsCriticalsTable.php"); ?> 
                    </div>
                    
                    <input type="submit" class="submitChanges" name="mechChangeSubmit" value='Save Changes'/>
                    <!--<input type="button" class="submitChanges" name="testing" value='test user Log in' onclick="checkLogin()"/>-->
                    <!--<p id="TEST2">TESTING</p>-->
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
