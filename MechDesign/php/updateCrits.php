<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");

    $mechID = filter_input(INPUT_GET, 'mechIDPassed', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;
            
    $mechPart = $_GET['mechPart'];
    $leftRight = $_GET['leftRight'];
    $critToAdd = $_GET['critToAdd'];
    $addRemove = $_GET['addRemove'];
    
        $queryTotalSlotsAvailable = "SELECT * from $mechPart WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
        $TotalSlotsAvailable = mysqli_query($conn, $queryTotalSlotsAvailable)->fetch_object()->totalSlotsAvailable;
        $queryslotsUnmovable = mysqli_query($conn, $queryTotalSlotsAvailable)->fetch_object()->slotsUnmovable;
        //$value2 = mysqli_fetch_array($value);
        //$TotalSlotsAvailable = $value2['totalSlotsAvailable'];
        
        if (($mechPart == "mecharm") || ($mechPart == "mechtorso") || ($mechPart == "mechtorsocenter")) {
            $firstFreeSlot = 13 - $TotalSlotsAvailable;
            $slotCounter = 12;
        }
        else  if (($mechPart == "mechleg") || ($mechPart == "mechhead")) {
            $firstFreeSlot = 7 - $TotalSlotsAvailable;
            $slotCounter = 6;
        }
        
        $availSlot = "slot" . strval($firstFreeSlot);
        $availSlot = strval($availSlot);
        $slotsRequiredQuery = "SELECT * FROM mechweapons WHERE weaponName = '$critToAdd'";
        $slotsRequired = mysqli_query($conn, $slotsRequiredQuery)->fetch_object()->slotsRequired;
        
        //if (($leftRight == 1) || ($leftRight == 0)) {
            $addRemovePartQuery = "UPDATE $mechPart SET $availSlot = '$critToAdd' WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
            $updateAvailSlotQuery = "UPDATE $mechPart SET totalSlotsAvailable = totalSlotsAvailable-$slotsRequired WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
        //}
        /*else  if ($leftRight == 2) {
            $addRemovePartQuery = "UPDATE $mechPart SET $availSlot = '$critToAdd' WHERE mechID = '$mechID'";
            $updateAvailSlotQuery = "UPDATE $mechPart SET totalSlotsAvailable = totalSlotsAvailable-$slotsRequired WHERE mechID = '$mechID'";
            //$overFlowQuery = "UPDATE $mechPart SET $availSlot = 'overflow' WHERE mechID = '$mechID'";
        }*/
        
        if ($TotalSlotsAvailable >= $slotsRequired) {
            if ($addRemove == "add") {
                $update = mysqli_query($conn, $addRemovePartQuery);
                $update2 = mysqli_query($conn, $updateAvailSlotQuery);
                
                for ($i=$slotsRequired-1; $i > 0; $i--) {
                    $availSlot2 = "slot" . strval($firstFreeSlot+$i);
                    $availSlot2 = strval($availSlot2);
                    //if (($leftRight == 1) || ($leftRight == 0)) {
                        $fillOverflowSlots = mysqli_query($conn, "UPDATE $mechPart SET $availSlot2 = 'overflow' WHERE mechID = '$mechID' AND partLeftorRight = $leftRight");
                    //}
                    //else  if ($leftRight == 2) {
                    //    $fillOverflowSlots = mysqli_query($conn, "UPDATE $mechPart SET $availSlot2 = 'overflow' WHERE mechID = '$mechID'");
                    //}
                }
                
                $weaponTonnage = mysqli_query($conn, $slotsRequiredQuery)->fetch_object()->tons;
                $update3Query = "UPDATE mechinternals SET weaponTonnage = weaponTonnage + $weaponTonnage, totalInternalTonnage = totalInternalTonnage + $weaponTonnage WHERE mechID = '$mechID'";
                $update3 = mysqli_query($conn, $update3Query);
                
            }
        }
        
        if ($addRemove == "remove") {
                //$update = mysqli_query($conn, $addRemovePartQuery);
                //$update2 = mysqli_query($conn, $updateAvailSlotQuery);
                
                
                for ($count = 1; $count <= $slotCounter; $count++) {
                    $availSlot3 = "slot" . strval($count);
                    $availSlot3 = strval($availSlot3);
                    
                    $querySlots = "SELECT * from $mechPart WHERE $availSlot3 = '$critToAdd' AND mechID = '$mechID' AND partLeftorRight = $leftRight";
                    $querySuccess = mysqli_query($conn, $querySlots);
                    $querySuccess2 = mysqli_fetch_array($querySuccess);
                    if ($querySuccess2[$availSlot3] == $critToAdd) {
                        $slotToUpdate = $availSlot3;
                        $count2 = $count;
                    }
                }
                $weaponTonnage = mysqli_query($conn, $slotsRequiredQuery)->fetch_object()->tons;
                $update3Query = "UPDATE mechinternals SET weaponTonnage = weaponTonnage - $weaponTonnage, totalInternalTonnage = totalInternalTonnage - $weaponTonnage WHERE mechID = '$mechID'";
                $update3 = mysqli_query($conn, $update3Query);
                
                $updateAvailSlotQuery = "UPDATE $mechPart SET $slotToUpdate = '', totalSlotsAvailable=totalSlotsAvailable+$slotsRequired WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
                
                for ($count3=1; $count3 < $slotsRequired; $count3++) {
                    $count2 = $count2 + 1;
                    $availSlot4 = "slot" . strval($count2);
                    $availSlot4 = strval($availSlot4);
                    
                    $clearOverflowQuery = "UPDATE $mechPart SET $availSlot4 = '' WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
                    $runUpdate = mysqli_query($conn, $clearOverflowQuery);
                }
                
                $runUpdate = mysqli_query($conn, $updateAvailSlotQuery);
                //clearBlanks();
            }
        
            $divDataToChange = array(
            "slotsRequired" => $slotsRequired,
            "numUnmovable" => $queryslotsUnmovable,
            );
    
            echo json_encode($divDataToChange);
