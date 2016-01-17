
<script>
    function pickMechs() {

         if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
           xmlhttp=new XMLHttpRequest();
         }
         xmlhttp.onreadystatechange=function() {
           if (xmlhttp.readyState==4 && xmlhttp.status==200) {
             document.getElementById("mechSelect").innerHTML=xmlhttp.responseText;
           }
         }
         xmlhttp.open("GET","php/pickMechs.php", true);
         xmlhttp.send();
    }
    
    function displayCrits(idToMod, mechPart, leftRight, xmlhttpNum, numUnmovable) {
        
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
           xmlhttpNum=new XMLHttpRequest();
         }
         xmlhttpNum.onreadystatechange=function() {
            if (xmlhttpNum.readyState==4 && xmlhttpNum.status==200) {
               
                var critDetails = JSON.parse(xmlhttpNum.response);
             
                var myNode = document.getElementById(idToMod);
                while (myNode.firstChild) {
                    myNode.removeChild(myNode.firstChild);
                }
                
                counter = numUnmovable;
                for (var key in critDetails) {
                    
                    var TR = document.createElement("tr")
                    TR.className = "dropSlots";
                    var TD = document.createElement("td");
                    TD.className = "dropSlotsTD";
                    //TD.text = critDetails[key];
                    //TD.value = critDetails[key];
                    TD.innerHTML = critDetails[key];
                    
                    if (critDetails[key] == "overflow") {
                        TD.innerHTML = '&#8595'+'&nbsp&nbsp&nbsp'+'&#8595'+'&nbsp&nbsp&nbsp'+'&#8595';
                        TD.className = "dropSlotsUnmovable";
                        /*TR.style.marginTop = "0px";
                        TD.style.marginTop = "0px";
                        TR.style.borderTopWidth = "0px";
                        TD.style.borderTopWidth = "0px";*/
                        
                    }
                    if (critDetails[key] == "") {
                        TD.className = "dropSlotsUnmovable";
                    }
                    if (counter > 0) {
                        TD.className = "dropSlotsUnmovable";
                        TD.style.backgroundColor = "#FFAC30";
                    }
                    
                    TD.style.textOverflow="visible";
                    TD.style.whiteSpace="nowrap";
                    
                    document.getElementById(idToMod).appendChild(TR).appendChild(TD);
                    counter--;
                }
                // This function has to be called here bc it can only be made
                // droppable after being created.
                makeDroppable();
            }
         }
         xmlhttpNum.open("GET","php/displayCrits.php?mechPart="+mechPart+"&leftRight="+leftRight, true);
         xmlhttpNum.send();
    }
    
    function updateCrits(mechPart, leftRight, critToAdd, addRemove, containerID) {
        
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
           xmlhttpNum2=new XMLHttpRequest();
         }
         xmlhttpNum2.onreadystatechange=function() {
            if (xmlhttpNum2.readyState==4 && xmlhttpNum2.status==200) {
                
                critDetails = JSON.parse(xmlhttpNum2.response);
                //prompt(critDetails.slotsRequired);
                //prompt(critDetails.numUnmovable);
                
                    
                //$( "#leftArmCritTable:nth-child(7)" ).style.background="purple";
                
                if (addRemove == "remove") {
                    clearBlanks(mechPart, leftRight, containerID, critDetails.numUnmovable);
                }
                else {
                    displayCrits(containerID, mechPart, leftRight, "seven", critDetails.numUnmovable);
                    updateTonnage();
                }
            }
        }
         xmlhttpNum2.open("GET","php/updateCrits.php?mechPart="+mechPart+"&leftRight="+leftRight+"&critToAdd="+critToAdd+"&addRemove="+addRemove, true);
         xmlhttpNum2.send();
    }
    
    function clearBlanks(mechPart, leftRight, containerID, numUnmove) {
        
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
           xmlhttpNum3=new XMLHttpRequest();
         }
         xmlhttpNum3.onreadystatechange=function() {
            if (xmlhttpNum3.readyState==4 && xmlhttpNum3.status==200) {
                
                displayCrits(containerID, mechPart, leftRight, "eight", numUnmove);
                updateTonnage();
            }
        }
         xmlhttpNum3.open("GET","php/clearWeaponBlanks.php?mechPart="+mechPart+"&leftRight="+leftRight, true);
         xmlhttpNum3.send();
    }
    
</script>

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
        }
        else {
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
            <hr class='dividerBar'/>

            <div id="mechSelect"></div>
        </div>
        
        <p class='selector' id='armorSelector' >Armor</p>
        <div class='popoutClass popoutTab2'>Increase External Armor
            <hr class='dividerBar' style="margin-top: -2px;"/>
            <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftTorsoInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'torsoLeftArmor', 'increase', 'torso');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftTorsoDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'torsoLeftArmor', 'decrease', 'torso');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="RightTorsoInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'torsoRightArmor', 'increase', 'torso');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="RightTorsoDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'torsoRightArmor', 'decrease', 'torso');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftRearTorsoInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'rearLeftTorsoArmor', 'increase', 'torso');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftRearTorsoDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'rearLeftTorsoArmor', 'decrease', 'torso');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="RightRearTorsoInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'rearRightTorsoArmor', 'increase', 'torso');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="RightRearTorsoDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'rearRightTorsoArmor', 'decrease', 'torso');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="centerRearTorsoInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'rearCenterArmor', 'increase', 'center');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="centerRearTorsoDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'rearCenterArmor', 'decrease', 'center');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="RightLegInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'legRightArmor', 'increase', 'leg');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="RightLegDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'legRightArmor', 'decrease', 'leg');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftLegInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'legLeftArmor', 'increase', 'leg');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftLegDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'legLeftArmor', 'decrease', 'leg');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="centerTorsoInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'centerArmor', 'increase', 'center');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="centerTorsoDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'centerArmor', 'decrease', 'center');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="headInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'headArmor', 'increase', 'head');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="headDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'headArmor', 'decrease', 'head');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="LeftArmInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'armLeftArmor', 'increase', 'arm');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="LeftArmDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'armLeftArmor', 'decrease', 'arm');"/>
            
            <img src="images/upRedArrow.png" class="downMovementArrow" id="RightArmInc" onclick="changeMechStats(<?php echo $MechID; ?>, 'armRightArmor', 'increase', 'arm');"/>
            <img src="images/downRedArrow.png" class="downMovementArrow" id="RightArmDec" onclick="changeMechStats(<?php echo $MechID; ?>, 'armRightArmor', 'decrease', 'arm');"/>
            
            <h4><input type="checkbox" id="mirrorArmorBox" name="mirrorArmorBox" checked>Link armor locations</h4>
            <h4><p id="totalWeightArmorPage" style="font-weight: normal; margin-top: 9px;"></p></h4>
        </div>
        
        <p class='selector' id='weaponSelector'>Weapons/Criticals</p>
        <div class='popoutClass popoutTab3'>Weapons / Criticals
            <hr class='dividerBar'/>
            <div id="weaponAccordion" >
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
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            </table>
            
        </div>
        
        <p class='selector' id='criticalSelector'>Save Mech</p>
        <div class='popoutClass popoutTab4'>

        </div>
        
    </div>



<!-- THIS CODE is for a static button that loads the grid of all mechs available.
I may re-add this grid back in later. For now the gris is loaded with the mechSelectot button-->
<?php 
/*
    // THIS IS THE PHP DATABASE ACCESS CODE AT BEGINNING OF THE PAGE
    $result2 = mysqli_query($conn, "SELECT * FROM mechs");
    
    $arrayIndex = 0;
    $mechNameDisplay = array();
    while($row = mysqli_fetch_array($result2)) {
    
        $mechNameDisplay[$arrayIndex] = $row['mechName']; 
        $mechArmorDisplay[$arrayIndex] = $row['armor'];
        $arrayIndex++;
    }
 
 
    // THIS IS THE BUTTON  - THE CODE BELOW WOULD BE IN THE HTML
    for ($arrayCounter=0; $arrayCounter < sizeof($mechNameDisplay); $arrayCounter++) {                                
        echo "<tr> 
            <td> <a href='mechDesign.php?mechIDPassed=$arrayCounter'> $mechNameDisplay[$arrayCounter] </a> </td>
            <td> $mechArmorDisplay[$arrayCounter] </td>
            </tr>";
    }
*/
 ?>
