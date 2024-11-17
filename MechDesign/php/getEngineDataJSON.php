<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");

    $mechID = $_SESSION['mechID'] ?? 1;
    
    
    $queryEngineRating = "SELECT engineRating FROM mechengine WHERE mechID = $mechID AND activeEngine = 1";
    $queryMechTonnage = "SELECT maxTonnage FROM mechs WHERE mechID = $mechID";
    $queryMechInternals = "SELECT * FROM mechinternals WHERE mechID = $mechID";
    
    $engineRating = mysqli_query($conn, $queryEngineRating)->fetch_object()->engineRating;
    $mechTonnage = mysqli_query($conn, $queryMechTonnage)->fetch_object()->maxTonnage;
    $mechInternals = mysqli_query($conn, $queryMechInternals);
    
    $internalsArray = array();
    if( $mechInternals ) {
        $internalsArray = mysqli_fetch_array($mechInternals);
    }
    else {
        die('Could not fetch data: ' . mysqli_error($conn)); 
    }
   

    $EngineDataArray = array(
    "engineRating" => $engineRating,
    "mechTonnage" => $mechTonnage,
    "internalsTonnage" => $internalsArray['internalStructureTonnage'],
    "internalsCriticals" => $internalsArray['internalStructureCriticals'],
    "engineTonnage" => $internalsArray['engineTonnage'],
    "engineCriticals" => $internalsArray['engineCriticals'],
    "gyroTonnage" => $internalsArray['gyroTonnage'],
    "gyroCriticals" => $internalsArray['gyroCriticals'],
    "cockpitTonnage" => $internalsArray['cockpitTonnage'],
    "cockpitCriticals" => $internalsArray['cockpitCriticals'],
    "heatSinksTonnage" => $internalsArray['heatSinksTonnage'],
    "heatSinksCriticals" => $internalsArray['heatSinksCriticals'],
    "enhancementsTonnage" => $internalsArray['enhancementsTonnage'],
    "enhancementsCriticals" => $internalsArray['enhancementsCriticals'],
    "jumpJetsTonnage" => $internalsArray['jumpJetsTonnage'],
    "jumpJetsCriticals" => $internalsArray['jumpJetsCriticals']
    );

echo json_encode($EngineDataArray);

