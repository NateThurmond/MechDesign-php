
<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");

    $mechID = $_SESSION['mechID'];
    
    $queryInternalWeight = "SELECT * FROM mechinternals WHERE mechID = $mechID";
    $queryArmorWeight = "SELECT * FROM mechexternalarmor WHERE mechID = $mechID";
    $queryMaxTonnage = "SELECT * FROM mechs WHERE mechID = $mechID";
    
    $internalWeight = mysqli_query($conn, $queryInternalWeight)->fetch_object()->totalInternalTonnage;
    $externalArmor = mysqli_query($conn, $queryArmorWeight)->fetch_object()->mechArmorTotal;
    $maxTonnage = mysqli_query($conn, $queryMaxTonnage)->fetch_object()->maxTonnage;
    
    $externalArmorWeight = (ceil($externalArmor/8))/2;
            
            
    $totalWeight = $externalArmorWeight + $internalWeight;
    
    $engineDataArray = array(
    "totalWeight" => $totalWeight,
    "maxTonnage" => $maxTonnage
    );

    echo json_encode($engineDataArray);
    
