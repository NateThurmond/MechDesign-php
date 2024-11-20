<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");
    
    $mechID = filter_input(INPUT_GET, 'mechIDPassed', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;
    
    if ( isset($_GET['updatedEngine']) ) {
        $newEngine = $_GET['updatedEngine'];
        
        /*$updateEngineQuery = mysqli_query($conn, "UPDATE mechengine SET activeEngine = '1' WHERE engineName = '$newEngine' AND mechID = $mechID");
            if(! $updateEngineQuery ) { die('Could not update data: ' . mysqli_error($conn)); }
        */    
        /*$deselectOtherEngines = mysqli_query($conn, "UPDATE mechengine SET activeEngine = '0' WHERE engineName != '$newEngine' AND mechID = $mechID");
            if(! $updateEngineQuery ) { die('Could not update data: ' . mysqli_error($conn)); }
        */    
        $updateEngineName = mysqli_query($conn, "UPDATE mechengine SET engineName = '$newEngine' WHERE mechID = $mechID");
            if(! $updateEngineName ) { die('Could not update data: ' . mysqli_error($conn)); }
            
        unset($newEngine);
    }      
       
    /* This query determines what type of engine this mech can carry. Usually, under introductory rules only one
    engine type is allowed but expansion of this site later will need to be able to handle different engine types. */
    $queryEngineTypes = "SELECT * FROM mechengine WHERE mechID = $mechID";
    //$currentMechEngine = "SELECT * FROM mechengine WHERE mechID = $mechID AND activeEngine = 1";
    
    $dataEngineType = mysqli_query($conn, $queryEngineTypes);
    $engineType = mysqli_query($conn, $queryEngineTypes)->fetch_object()->engineName;
    $mechWalk = mysqli_query($conn, $queryEngineTypes)->fetch_object()->mechWalk;
    $mechRun = mysqli_query($conn, $queryEngineTypes)->fetch_object()->mechRun;
    $mechJump = mysqli_query($conn, $queryEngineTypes)->fetch_object()->mechJump;
    
    $engineSelectOptions = array();

    if ($engineType == 'XL Engine') {
        $altEngine = "Fusion Engine";
    }
    else if ($engineType == 'Fusion Engine') {
        $altEngine = "XL Engine";
    }
    
    //$count = 0;
    //while( $count < 2 ) {
        $engineSelectOptions[0] = '<option selected style="display:none; value="' . $engineType . '">' . $engineType . '</option>';
        //$count++;
        $engineSelectOptions[1] = '<option value="' . $engineType . '">' . $engineType . '</option>';
        $engineSelectOptions[2] = '<option value="' . $altEngine . '">' . $altEngine . '</option>';
    //}
    
    echo '<p style="display: inline-block;"><strong>Engine: </strong> </p>' 
              . '<select name="engineType" id="engineDropDown" onchange="updateEngine(this.value);">';
              //. '<option value="" disabled selected style="display:none;">' . $engineType . '</option>'
              //. '<option value="">Fusion Engine</option>'
              //. '<option value="">XL Engine</option>';
    
                    for($x = 0; $x < count($engineSelectOptions); $x++) {
                        echo $engineSelectOptions[$x]; 
                    }
    echo '</select>';
    echo '<div style="margin-top: -6px; height: 15px;"><p style="display: inline-block;"><strong>Engine Rating: &nbsp</strong></p><p id="mechEngineRating" style="display: inline-block;"></p></div>';
    
    echo '<div id=mechWalk>Walk: &nbsp<p style="display: inline-block; font-weight: normal;"></p><input type="text" class="movementValues" style="margin-left: 2px;" value="' . $mechWalk . '" READONLY /><img src="images/upArrow2.png" class="upMovementArrow" id="upArrowWalk" /><img src="images/downArrow2.png" class="downMovementArrow" id="downArrowWalk" /></div>';
    echo '<div id=mechWalk>Run: &nbsp&nbsp<p style="display: inline-block; font-weight: normal;"></p><input type="text" style="margin-left: 4px;"class="movementValues" value="' . $mechRun . '" READONLY /></div>';
    echo '<div id=mechWalk>Jump: &nbsp<p style="display: inline-block; font-weight: normal;"></p><input type="text" class="movementValues" value="' . $mechJump . '" READONLY /><img src="images/upArrow2.png" class="upMovementArrow" id="upArrowJump" /><img src="images/downArrow2.png" class="downMovementArrow" id="downArrowJump" /></div>';

    $conn->close();
