<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");

    $mechID = $_SESSION['mechID'] ?? 1;
    
    $queryHeatSinkData = "SELECT * FROM mechinternals WHERE mechID = $mechID";
    $heatSinkType = mysqli_query($conn, $queryHeatSinkData)->fetch_object()->heatSinkType;
    $currentHeatWeight = mysqli_query($conn, $queryHeatSinkData)->fetch_object()->heatSinksTonnage;
    
    if ($heatSinkType == "Singles") {
        $newHeatSinkType = "Doubles";
    }
    else { $newHeatSinkType = "Singles"; }
    
    if ( isset($_GET['changeHeatSink']) ) {
        $change = $_GET['changeHeatSink'];
        
        if ($change == true) {
        
            $updateHeatSink = mysqli_query($conn, "UPDATE mechinternals SET heatSinkType = '$newHeatSinkType' WHERE mechID = $mechID");
                if(! $updateHeatSink ) { die('Could not update data: ' . mysqli_error($conn)); }
        }
        unset($change);
    }
    
    if ( isset($_GET['newHeatSinkNums']) ) {
        $changeHeatSinkNum = $_GET['newHeatSinkNums'];
        $newSinkWeight = $changeHeatSinkNum-10;
        $newInternalsWeight = $newSinkWeight - $currentHeatWeight;
        
        $updateHeatSinkNum = mysqli_query($conn, "UPDATE mechinternals SET totalInternalTonnage = (totalInternalTonnage + $newInternalsWeight), heatSinksNum = $changeHeatSinkNum, heatSinksCriticals = $newSinkWeight-1, heatSinksTonnage = $newSinkWeight WHERE mechID = $mechID");
            if(! $updateHeatSinkNum ) { die('Could not update data: ' . mysqli_error($conn)); }
        
        unset($changeHeatSinkNum);
    }
    
    $heatSinkData = mysqli_query($conn, $queryHeatSinkData);
    
    $heatSinkDataArray = array();
    if ($heatSinkData) {
        $heatSinkDataArray = mysqli_fetch_array($heatSinkData);
    }
    else {   
        die('Could not fetch data: ' . mysqli_error($conn));
    }
    
    if ($heatSinkDataArray['heatSinkType'] == "Singles") {
        $heatDissipation = $heatSinkDataArray['heatSinksNum'];
    }
    else { $heatDissipation = ($heatSinkDataArray['heatSinksNum'] * 2); }
    
    $heatSinkDataArrayJSON = array(
      "heatSinkType" => $heatSinkDataArray['heatSinkType'],
      "heatSinksNum" => $heatSinkDataArray['heatSinksNum'],
      "heatSinksTonnage" => $heatSinkDataArray['heatSinksTonnage'],
      "heatSinksCriticals" => $heatSinkDataArray['heatSinksCriticals'],
      "heatDissipation" => $heatDissipation
    );
    
    echo json_encode($heatSinkDataArrayJSON);
    