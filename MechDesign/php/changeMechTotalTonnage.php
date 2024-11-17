<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");

    $mechID = $_SESSION['mechID'] ?? 1;
    
    if ( isset($_GET['tons']) ) {
        $tons = $_GET['tons'];
    }
    
    $queryMechEngine = "SELECT * FROM mechengine WHERE mechID = $mechID";
    $mechEngine = mysqli_query($conn, $queryMechEngine);
    $engineData = mysqli_fetch_array($mechEngine);
    $mechWalk = $engineData['mechWalk'];
    $mechEngineType = $engineData['engineName'];
    
    $newEngineRating = $mechWalk * $tons;
    
    
    $Queryinternals = "SELECT * FROM mechinternals WHERE mechID = $mechID";
    $findInternalTonnage = mysqli_query($conn, $Queryinternals);
    $internalTonnage2 = mysqli_fetch_array($findInternalTonnage);
    
    
    $queryEngineRating = "SELECT * FROM engineratingweights WHERE engineRating = $newEngineRating";
    $mechInternals = mysqli_query($conn, $queryEngineRating);
    $internalsData = mysqli_fetch_array($mechInternals);
    
    
    //$queryNewInternalWeight = "SELECT * FROM mechinternals WHERE mechID = $mechID";
    
    $internalStructureTonnage = $tons/10;
    echo $internalStructureTonnage;
    //$engineTonnage = $internalsData['regEngWeight'];
    
    if ($mechEngineType == "Fusion Engine") {
        $engineTonnage = $internalsData['regEngWeight'];
    }
    else if ($mechEngineType == "XL Engine") {
        $engineTonnage = $internalsData['xlEngWeight'];
    }
    
    $gyroTonnage = $internalsData['gyroWeight'];
    $jumpJetsNum = $internalTonnage2['jumpJetsNum'];
    
    if ($tons <= 55) {
        $jumpJetsTon = $jumpJetsNum * 0.5;
    }
    else if ($tons <= 85) {
        $jumpJetsTon = $jumpJetsNum * 1;
    }
    else {
        $jumpJetsTon = $jumpJetsNum * 2;
    }
    
    $updateQuery = "UPDATE mechinternals SET `internalStructureTonnage`=$internalStructureTonnage, `engineTonnage`=$engineTonnage, `gyroTonnage`=$gyroTonnage, `jumpJetsTonnage`=$jumpJetsTon WHERE mechID = $mechID";
    $runUpdate = mysqli_query($conn, $updateQuery);
    
    $updateQuery2 = "UPDATE mechinternals SET ";
    
    $findTonsQuery = "SELECT * FROM mechinternals WHERE mechID = $mechID";
    $findTons = mysqli_query($conn, $findTonsQuery);
    $Tons = mysqli_fetch_array($findTons);
    
    $newTonnage = $Tons['weaponTonnage'] + $Tons['internalStructureTonnage'] + $Tons['engineTonnage'] + $Tons['gyroTonnage'] + $Tons['cockpitTonnage'] + $Tons['heatSinksTonnage'] + $Tons['jumpJetsTonnage'];
    
    $tonnageUpdate = "UPDATE `mechinternals` SET `totalInternalTonnage`=$newTonnage WHERE mechID = $mechID";
    $runUpdate = mysqli_query($conn, $tonnageUpdate);
    
    $tonnageUpdate2 = "UPDATE `mechs` SET `maxTonnage`=$tons WHERE mechID = $mechID";
    $runUpdate3 = mysqli_query($conn, $tonnageUpdate2);

    $tonnageUpdate4 = "UPDATE `mechengine` SET `engineRating`=$newEngineRating WHERE mechID = $mechID";
    $runUpdate4 = mysqli_query($conn, $tonnageUpdate4);
    