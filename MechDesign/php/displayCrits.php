<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");

    $mechID = $_SESSION['mechID'] ?? 1;
            
    $mechPart = $_GET['mechPart'];
    $leftRight = $_GET['leftRight'];
    
    /*  SAMPLE INNER JOIN IF I FIND OUT THAT I NEED IT.
    $queryMechLeftArm = "SELECT  a.*, b.* FROM mechhead a INNER JOIN mechtorsocenter b
        ON a.mechID = b.mechID AND a.mechID = '$mechID'";
    */
    
    //if (($leftRight == 1) || ($leftRight == 0)) {
        $queryMechPartCrits = "SELECT * FROM $mechPart WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
    //}
    //else if ($leftRight == 2) {
      //  $queryMechPartCrits = "SELECT * FROM $mechPart WHERE mechID = '$mechID'";
    //}
    
    $mechPartCrits = mysqli_query($conn, $queryMechPartCrits);
    
    $mechPartData = array();
    if ($mechPartCrits) {
        $mechPartData = mysqli_fetch_array($mechPartCrits);
    }
    else {
        die('Could not fetch data: ' . mysqli_error($conn)); 
    }
    
    
    if (($mechPart == "mecharm") || ($mechPart == "mechtorso") || ($mechPart == "mechtorsocenter")) {
        $critsArray = array(
          "slot1" => $mechPartData['slot1'],
          "slot2" => $mechPartData['slot2'],
          "slot3" => $mechPartData['slot3'],
          "slot4" => $mechPartData['slot4'],
          "slot5" => $mechPartData['slot5'],
          "slot6" => $mechPartData['slot6'],
          "slot7" => $mechPartData['slot7'],
          "slot8" => $mechPartData['slot8'],
          "slot9" => $mechPartData['slot9'],
          "slot10" => $mechPartData['slot10'],
          "slot11" => $mechPartData['slot11'],
          "slot12" => $mechPartData['slot12']
        );
    }
    else  if (($mechPart == "mechleg") || ($mechPart == "mechhead")) {
        $critsArray = array(
          "slot1" => $mechPartData['slot1'],
          "slot2" => $mechPartData['slot2'],
          "slot3" => $mechPartData['slot3'],
          "slot4" => $mechPartData['slot4'],
          "slot5" => $mechPartData['slot5'],
          "slot6" => $mechPartData['slot6']
        );
    }
    
    echo json_encode($critsArray);