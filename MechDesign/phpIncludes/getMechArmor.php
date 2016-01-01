<?php

    include("php_Global_Vars_and_DB_Conn.php");

    $mechID = $_SESSION['mechID'];
    $displayLocale = "mechArmor";
    
    if ( isset($_GET['displayLocation']) ) {
        $displayLocale = $_GET['displayLocation'];
    }

    // The following queries get the number of armor points for each location
    $queryMechArmor = "SELECT * FROM mechexternalarmor WHERE mechID = $mechID";
        
    // FETCH THE DATA
    $data = mysqli_query($conn, $queryMechArmor);
    
    // GIVE ERROR IF THERE IS PROBLEM ACCESSING DATA
    if(! $data ) { die('Could not fetch data: ' . mysqli_error($conn)); }
    
    // THE FOLLOWING MATH FUNCTIONS DETERMINE THE NUMBER OF ARMOR POINTS TO
    // DISPLAY AS WELL AS HOME MANY LINES TO PUT THE ARMOR POINTS ON.
    $row = mysqli_fetch_assoc($data);   
    
    // FUNCTION TO DISPLAY ARMOR POINTS DYNAMICALLY AND EVENLY ACROSS THE MULTIPLE ROWS
    function armorDisplayCircles($classToMod, $idToMod, $armorCircles, $divLines) {
        $divCounter = 0;
        echo '<div class="' . $classToMod . '" id="' . $idToMod . '">';
        for ($count = 0; $count < $armorCircles; $count++) {
            echo '<p class="circle"></p>';
            $divCounter++;
            if ($divCounter % $divLines == 0) {
                echo '<br>';
                }
            }
        echo '</div>';
    }

    
    // DISPLAY THE ACTUAL NUMERIC VALUE FOR THAT ARMOR SECTION
    if (($displayLocale == "arm") || ($displayLocale == "mechArmor")) {
        $armorCirclesLeftArm = $row['armLeftArmor'];
        $armorCirclesRightArm = $row['armRightArmor'];
        $numDivsLeftArm = ceil($armorCirclesLeftArm/10);
        $numDivsRightArm = ceil($armorCirclesRightArm/10);
        
        echo '<div id="arm">';
        armorDisplayCircles("armorDisplayLayout", "leftArmArmor", $armorCirclesLeftArm, $numDivsLeftArm);
        armorDisplayCircles("armorDisplayLayout", "rightArmArmor", $armorCirclesRightArm, $numDivsRightArm);
        
        echo '<div id="leftArmArmorNumeric"><p>' . $armorCirclesLeftArm . '</p></div>';
        echo '<div id="rightArmArmorNumeric"><p>' . $armorCirclesRightArm . '</p></div>';
        echo '</div>';
    }
    if (($displayLocale == "head") || ($displayLocale == "mechArmor")) {
        $armorCirclesHead = $row['headArmor'];
        $numDivsHead = ceil($armorCirclesHead/3);
        
        echo '<div id="head">';
        armorDisplayCircles("armorDisplayLayout", "mechHeadArmor", $armorCirclesHead, $numDivsHead);
        
        echo '<div id="mechHeadArmorNumeric"><p>' . $armorCirclesHead . '</p></div>';
        echo '</div>';
    }
    
    if (($displayLocale == "center") || ($displayLocale == "mechArmor")) {
        $armorCirclesCenter = $row['centerArmor'];
        $armorCirclesRearCenter = $row['rearCenterArmor'];
        $numDivsCenter = ceil($armorCirclesCenter/9);
        $numDivsRearCenter = ceil($armorCirclesRearCenter/9);
        
        echo '<div id="center">';
        armorDisplayCircles("armorDisplayLayout", "centerArmor", $armorCirclesCenter, $numDivsCenter);
        armorDisplayCircles("armorDisplayLayout", "centerRearArmor", $armorCirclesRearCenter, $numDivsRearCenter);
        
        echo '<div id="centerArmorNumeric"><p>' . $armorCirclesCenter . '</p></div>';
        echo '<div id="centerRearArmorNumeric"><p>' . $armorCirclesRearCenter . '</p></div>';
        echo '</div>';
    }
    if (($displayLocale == "torso") || ($displayLocale == "mechArmor")) {
        $armorCirclesLeftTorso = $row['torsoLeftArmor'];
        $armorCirclesRightTorso = $row['torsoRightArmor'];
        $armorCirclesLeftRear = $row['rearLeftTorsoArmor'];
        $armorCirclesRightRear = $row['rearRightTorsoArmor'];

        $armorTorsoLeftTop = round($armorCirclesLeftTorso *.57);
        $numDivsTorsoLeftTop = ceil($armorTorsoLeftTop/4);
        $armorTorsoRightTop = round($armorCirclesRightTorso *.57);
        $numDivsTorsoRightTop = ceil($armorTorsoRightTop/4);
        $armorTorsoLeftBottom = round($armorCirclesLeftTorso *.285);
        $numDivsTorsoLeftBottom = ceil($armorTorsoLeftBottom/2);
        $armorTorsoRightBottom = round($armorCirclesRightTorso *.285);
        $numDivsTorsoRightBottom = ceil($armorTorsoRightBottom/2);
        $armorTorsoLeftMiddle = $armorCirclesLeftTorso-($armorTorsoLeftTop+$armorTorsoLeftBottom);
        $numDivsTorsoLeftMiddle = ceil($armorTorsoLeftMiddle/3); 
        $armorTorsoRightMiddle = $armorCirclesRightTorso-($armorTorsoRightTop+$armorTorsoRightBottom);
        $numDivsTorsoRightMiddle = ceil($armorTorsoRightMiddle/3);
        $numDivsTorsoLeftRear = ceil($armorCirclesLeftRear/4);
        $numDivsTorsoRightRear = ceil($armorCirclesRightRear/4);
        
        echo '<div id="torso">';
        armorDisplayCircles("armorDisplayLayout", "leftTorsoArmorTop", $armorTorsoLeftTop, $numDivsTorsoLeftTop);
        armorDisplayCircles("armorDisplayLayout", "leftTorsoArmorMiddle", $armorTorsoLeftMiddle, $numDivsTorsoLeftMiddle);
        armorDisplayCircles("armorDisplayLayout", "leftTorsoArmorBottom", $armorTorsoLeftBottom, $numDivsTorsoLeftBottom);

        armorDisplayCircles("armorDisplayLayout", "rightTorsoArmorTop", $armorTorsoRightTop, $numDivsTorsoRightTop);
        armorDisplayCircles("armorDisplayLayout", "rightTorsoArmorMiddle", $armorTorsoRightMiddle, $numDivsTorsoRightMiddle);
        armorDisplayCircles("armorDisplayLayout", "rightTorsoArmorBottom", $armorTorsoRightBottom, $numDivsTorsoRightBottom);

        armorDisplayCircles("armorDisplayLayout", "leftRearTorsoArmor", $armorCirclesLeftRear, $numDivsTorsoLeftRear);
        armorDisplayCircles("armorDisplayLayout", "rightRearTorsoArmor", $armorCirclesRightRear, $numDivsTorsoRightRear);
        
        echo '<div id="leftTorsoArmorNumeric">' . $armorCirclesLeftTorso . '</div>';
        echo '<div id="rightTorsoArmorNumeric">' . $armorCirclesRightTorso . '</div>';
        echo '<div id="leftRearTorsoArmorNumeric">' . $armorCirclesLeftRear . '</div>';
        echo '<div id="rightRearTorsoArmorNumeric">' . $armorCirclesRightRear . '</div>';
        echo '</div>';
    }
    if (($displayLocale == "leg") || ($displayLocale == "mechArmor")) {
        $armorCirclesLeftLeg = $row['legLeftArmor'];
        $armorCirclesRightLeg = $row['legRightArmor'];
        $numDivsLeftLeg = ceil($armorCirclesLeftLeg/12);
        $numDivsRightLeg = ceil($armorCirclesRightLeg/12);
        
        echo '<div id="leg">';
        armorDisplayCircles("armorDisplayLayout", "leftLegArmor", $armorCirclesLeftLeg, $numDivsLeftLeg);
        armorDisplayCircles("armorDisplayLayout", "rightLegArmor", $armorCirclesRightLeg, $numDivsRightLeg);
        
        echo '<div id="leftLegArmorNumeric">' . $armorCirclesLeftLeg . '</div>';
        echo '<div id="rightLegArmorNumeric">' . $armorCirclesRightLeg . '</div>';
        echo '</div>';
    }

    $conn->close();
