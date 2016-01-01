<?php

    include("php_Global_Vars_and_DB_Conn.php");
    $mechID = $_SESSION['mechID'];
    $weaponName;
    
    if ( isset($_GET['weaponName']) ) {
        $weaponName = $_GET['weaponName'];
    }
    
    $queryWeaponData = "SELECT * FROM mechweapons WHERE weaponName = '$weaponName'";
    $weaponData = mysqli_query($conn, $queryWeaponData);
    
    $weaponDataDetails = array();
    if( $weaponData ) {
        $weaponDataDetails = mysqli_fetch_array($weaponData);
    }
    else {
        die('Could not fetch data: ' . mysqli_error($conn)); 
    }
    
    $weaponDataArray = array(
      "weaponName" => $weaponDataDetails['weaponName'],
      "damage" => $weaponDataDetails['damage'],
      "heat" => $weaponDataDetails['heat'],
      "minRange" => $weaponDataDetails['rangeMin'],
      "shortRange" => $weaponDataDetails['rangeShort'],
      "midRange" => $weaponDataDetails['rangeMed'],
      "longRange" => $weaponDataDetails['rangeLong'],
      "tons" => $weaponDataDetails['tons'],
      "slotsRequired" => $weaponDataDetails['slotsRequired'],
      "ammoNeeded" => $weaponDataDetails['ammoNeeded'],
      "weaponType" => $weaponDataDetails['weaponType'],
      "availDate" => $weaponDataDetails['availableDate']
    );
    
    echo json_encode($weaponDataArray);