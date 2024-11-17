<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");
    $mechID = $_SESSION['mechID'] ?? 1;
            
    $mechPart = $_GET['mechPart'];
    $leftRight = $_GET['leftRight'];
    
    $queryTotalSlotsAvailable = "SELECT * from $mechPart WHERE mechID = '$mechID' AND partLeftorRight = $leftRight";
    $queryslotsUnmovable = mysqli_query($conn, $queryTotalSlotsAvailable);
    $weaponsArray = mysqli_fetch_array($queryslotsUnmovable);

    $myArray = array();
    for ($i=0; $i < 12; $i++) {
        $t = $i+1;
        $availSlot = "slot" . strval($t);
        $availSlot = strval($availSlot);
        $myArray[$i] = $weaponsArray[$availSlot];
    }

    $counter1 = 0;
    while ($counter1 <= 11) {
        
        while(($myArray[$counter1] == "") && ($counter1 <= 11)) {
            $counter2 = $counter1;
            $counter3 = $counter1;
            
            while(($myArray[$counter3] == "") && ($counter3 < 12)) {
                $counter3++;
            }
            $counter4 = $counter3;
            
            while ($counter1 < $counter3) {

                $myArray[$counter1] = $myArray[$counter4];
                $myArray[$counter4] = "";
                $counter1++;
                $counter4++;
                if ($counter4 == 11) {
                    $counter1 = $counter3;
                }
            }
            
            $counter1 = $counter2;
            $counter1++;
        }
               
    $counter1++;    
    }

 $clearQuery = "
        UPDATE $mechPart SET slot1 = '$myArray[0]', slot2 = '$myArray[1]', 
        slot3 = '$myArray[2]', slot4 = '$myArray[3]',
        slot5 = '$myArray[4]', slot6 = '$myArray[5]'
         ";
 
 $clearQuery2 = "
        , slot7 = '$myArray[6]', slot8 = '$myArray[7]',
        slot9 = '$myArray[8]', slot10 = '$myArray[9]',
        slot11 = '$myArray[10]', slot12 = '$myArray[11]'
        ";
 
 $clearWhere = "
        WHERE mechID = '$mechID' AND partLeftorRight = $leftRight
        ";
        
    if (($mechPart == "mecharm") || ($mechPart == "mechtorso") || ($mechPart == "mechtorsocenter")) {
        $finalQuery = $clearQuery . $clearQuery2 . $clearWhere;
    }
    else  if (($mechPart == "mechleg") || ($mechPart == "mechhead")) {
        $finalQuery = $clearQuery . $clearWhere;
    }
    
    $runQuery = mysqli_query($conn, $finalQuery);