<?php

/*
    Author: Nathan Thurmond
    Revision Date: 2024-11-27
    Notes: I'm keeping this script in case I need to reference the calcuations later but
        the code itself is deprecated in favor of whole model approach loaded to front-end
*/

exit(0);
$incArm = $_GET['incArm'];
$mechIdPassed = intval($_GET['mechIdPassed']);
$linked = $_GET['linked'];
$armorLocation;
$armorLocation2;
$altArmorLocation;
$altArmorLocation2;
$maxArmor;
$revAltArmor = 0;

$queryTonnage = "SELECT * FROM mechs WHERE mechID = $mechIdPassed";
$queryExternalArmor = "SELECT * FROM mechexternalarmor WHERE mechID = $mechIdPassed";
$queryMechDetails = "SELECT * from mechdetails WHERE mechID = $mechIdPassed";

$mechArmorValues = mysqli_query($conn, $queryExternalArmor);

$mechTonnage = mysqli_query($conn, $queryTonnage)->fetch_object()->maxTonnage;
$queryMaxTons = "SELECT * FROM maxarmorfortonnage WHERE mechTonnage = $mechTonnage";

$maxTorsoArmor = mysqli_query($conn, $queryMaxTons)->fetch_object()->torsoMax;
$maxArmArmor = mysqli_query($conn, $queryMaxTons)->fetch_object()->armMax;
$maxLegArmor = mysqli_query($conn, $queryMaxTons)->fetch_object()->legMax;
$maxCenterArmor = mysqli_query($conn, $queryMaxTons)->fetch_object()->centerTorsoMax;

if (isset($_GET['armorLocation'])) {
    $armorLocation = $_GET['armorLocation'];

    if ($armorLocation == "torsoLeftArmor") {
        $maxArmor = $maxTorsoArmor;
        $altArmorLocation = "torsoRightArmor";
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->rearLeftTorsoArmor;
        $armorLocation2 = "rearLeftTorsoArmor";
        $altArmorLocation2 = "rearRightTorsoArmor";
    } else if ($armorLocation == "torsoRightArmor") {
        $maxArmor = $maxTorsoArmor;
        $altArmorLocation = "torsoLeftArmor";
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->rearRightTorsoArmor;
        $armorLocation2 = "rearRightTorsoArmor";
        $altArmorLocation2 = "rearLeftTorsoArmor";
    } else if ($armorLocation == "legLeftArmor") {
        $maxArmor = $maxLegArmor;
        $altArmorLocation = "legRightArmor";
    } else if ($armorLocation == "legRightArmor") {
        $maxArmor = $maxLegArmor;
        $altArmorLocation = "legLeftArmor";
    } else if ($armorLocation == "armLeftArmor") {
        $maxArmor = $maxArmArmor;
        $altArmorLocation = "armRightArmor";
    } else if ($armorLocation == "armRightArmor") {
        $maxArmor = $maxArmArmor;
        $altArmorLocation = "armLeftArmor";
    } else if ($armorLocation == "rearLeftTorsoArmor") {
        $maxArmor = $maxTorsoArmor;
        $altArmorLocation = "rearRightTorsoArmor";
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->torsoLeftArmor;
        $armorLocation2 = "torsoLeftArmor";
        $altArmorLocation2 = "torsoRightArmor";
    } else if ($armorLocation == "rearRightTorsoArmor") {
        $maxArmor = $maxTorsoArmor;
        $altArmorLocation = "rearLeftTorsoArmor";
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->torsoRightArmor;
        $armorLocation2 = "torsoRightArmor";
        $altArmorLocation2 = "torsoLeftArmor";
    } else if ($armorLocation == "centerArmor") {
        $maxArmor = $maxCenterArmor;
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->rearCenterArmor;
        $linked = "no";
        $armorLocation2 = "rearCenterArmor";
    } else if ($armorLocation == "rearCenterArmor") {
        $maxArmor = $maxCenterArmor;
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->centerArmor;
        $linked = "no";
        $armorLocation2 = "centerArmor";
    } else if ($armorLocation == "headArmor") {
        $maxArmor = 9;
        $linked = "no";
    }
}

$armorLocationMod = 1;

if ($incArm == 'decrease') {

    if ($mechArmorValues->fetch_object()->$armorLocation > 1) {
        $armorLocationMod = -1;
    } else {
        $armorLocationMod = 0;
    }
}

if ($mechArmorValues->fetch_object()->$armorLocation < $maxArmor) {

    updateArmor($armorLocation, $armorLocationMod, $linked, $altArmorLocation, $mechIdPassed, $conn);
}

if ($revAltArmor) {
    $armorThis = mysqli_query($conn, $queryExternalArmor)->fetch_object()->$armorLocation;

    if (($revAltArmor + $armorThis) > $maxArmor) {
        updateArmor($armorLocation2, -1, $linked, $altArmorLocation2, $mechIdPassed, $conn);
    }

    if ($altArmorLocation2) {
        $revAltArmor = mysqli_query($conn, $queryExternalArmor)->fetch_object()->$altArmorLocation2;
        $armorThis = mysqli_query($conn, $queryExternalArmor)->fetch_object()->$altArmorLocation;

        if (($revAltArmor + $armorThis) > $maxArmor) {
            updateArmor($altArmorLocation2, -1, $linked, $armorLocation2, $mechIdPassed, $conn);
        }
    }
}

function updateArmor($armorLocation, $armorLocationMod, $linked, $altArmorLocation, $mechIdPassed, $conn)
{
    $retval2 = mysqli_query($conn, "UPDATE mechexternalarmor SET $armorLocation = $armorLocation+$armorLocationMod WHERE mechID = $mechIdPassed");
    if (!$retval2) {
        die('Could not update data: ' . mysqli_error($conn));
    }
    echo "Updated data successfully\n";

    if ($linked == 'yes') {

        $queryMirrorArmor = "SELECT * FROM mechexternalarmor WHERE mechID = $mechIdPassed";
        $mirrorArmor = mysqli_query($conn, $queryMirrorArmor)->fetch_object()->$armorLocation;

        $retval4 = mysqli_query($conn, "UPDATE mechexternalarmor SET $altArmorLocation = $mirrorArmor WHERE mechID = $mechIdPassed");
        if (!$retval4) {
            die('Could not update data: ' . mysqli_error($conn));
        }
        echo "Updated data successfully\n";
    }
}

$retval3 = mysqli_query($conn, "UPDATE mechexternalarmor SET mechArmorTotal = torsoLeftArmor + torsoRightArmor +"
    . "legLeftArmor + legRightArmor + armLeftArmor + armRightArmor + rearLeftTorsoArmor + rearRightTorsoArmor +"
    . "centerArmor + rearCenterArmor + headArmor WHERE mechID = $mechIdPassed");
if (!$retval3) {
    die('Could not update data: ' . mysqli_error($conn));
}
echo "Updated data successfully\n";



$conn->close();
