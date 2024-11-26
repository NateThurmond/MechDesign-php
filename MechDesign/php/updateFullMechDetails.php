<?php

require_once("../config/config.php");
include("../php/DB_Conn.php");
require_once('sqlPrepare.php');

// Assume the JSON is posted as the raw request body
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

/*
EXAMPLE POST PAYLOAD
{
    "mechs_armor": 115,
    "mechs_era": "Succession War",
    "mechs_introDate": 3033,
    "mechs_maxTonnage": 65,
    "mechs_mechID": 2,
    "mechs_mechModel": "Alpha",
    "mechs_mechName": "MadDog",
    "mechs_productionYear": "3055",
    "mechs_techBase": "Clan",
    "mecharmLeft_id": 4,
    "mecharmRight_id": 6,
    "mecharmLeft_mechID": 2,
    "mecharmRight_mechID": 2,
    "mecharmLeft_partLeftorRight": 0,
    "mecharmRight_partLeftorRight": 1,
    "mecharmLeft_slot1": "",
    "mecharmRight_slot1": "",
    "mecharmLeft_slot10": "",
    "mecharmRight_slot10": "",
    "mecharmLeft_slot11": "",
    "mecharmRight_slot11": "",
    "mecharmLeft_slot12": "",
    "mecharmRight_slot12": "",
    "mecharmLeft_slot2": "",
    "mecharmRight_slot2": "",
    "mecharmLeft_slot3": "",
    "mecharmRight_slot3": "",
    "mecharmLeft_slot4": "",
    "mecharmRight_slot4": "",
    "mecharmLeft_slot5": "",
    "mecharmRight_slot5": "",
    "mecharmLeft_slot6": "",
    "mecharmRight_slot6": "",
    "mecharmLeft_slot7": "",
    "mecharmRight_slot7": "",
    "mecharmLeft_slot8": "",
    "mecharmRight_slot8": "",
    "mecharmLeft_slot9": "",
    "mecharmRight_slot9": "",
    "mechengine_activeEngine": 1,
    "mechengine_engineName": "Fusion Engine",
    "mechengine_engineRating": 3,
    "mechengine_id": 2,
    "mechengine_mechID": 2,
    "mechengine_mechJump": 6,
    "mechengine_mechRun": 9,
    "mechengine_mechWalk": 6,
    "mechexternalarmor_armLeftArmor": 4,
    "mechexternalarmor_armRightArmor": 4,
    "mechexternalarmor_centerArmor": 4,
    "mechexternalarmor_headArmor": 4,
    "mechexternalarmor_id": 2,
    "mechexternalarmor_legLeftArmor": 4,
    "mechexternalarmor_legRightArmor": 4,
    "mechexternalarmor_mechArmorTotal": 100,
    "mechexternalarmor_mechID": 2,
    "mechexternalarmor_rearCenterArmor": 4,
    "mechexternalarmor_rearLeftTorsoArmor": 4,
    "mechexternalarmor_rearRightTorsoArmor": 4,
    "mechexternalarmor_torsoLeftArmor": 4,
    "mechexternalarmor_torsoRightArmor": 4,
    "mechhead_id": 2,
    "mechhead_mechID": 2,
    "mechhead_partLeftorRight": "2",
    "mechhead_slot1": "",
    "mechhead_slot2": "",
    "mechhead_slot3": "",
    "mechhead_slot4": "",
    "mechhead_slot5": "",
    "mechhead_slot6": "",
    "mechinternals_cockpitCriticals": 2,
    "mechinternals_cockpitTonnage": 8,
    "mechinternals_engineCriticals": 2,
    "mechinternals_engineTonnage": 8,
    "mechinternals_enhancementsCriticals": 1,
    "mechinternals_enhancementsTonnage": 1,
    "mechinternals_gyroCriticals": 2,
    "mechinternals_gyroTonnage": 4,
    "mechinternals_heatSinksCriticals": 3,
    "mechinternals_heatSinksNum": 12,
    "mechinternals_heatSinksTonnage": 18,
    "mechinternals_heatSinkType": "Singles",
    "mechinternals_id": 2,
    "mechinternals_internalStructureCriticals": 4,
    "mechinternals_internalStructureTonnage": 25,
    "mechinternals_jumpJetsCriticals": 3,
    "mechinternals_jumpJetsNum": 5,
    "mechinternals_jumpJetsTonnage": 5,
    "mechinternals_mechID": 2,
    "mechinternals_totalInternalTonnage": 65,
    "mechinternals_weaponTonnage": 12,
    "mechlegLeft_id": 4,
    "mechlegRight_id": 6,
    "mechlegLeft_mechID": 2,
    "mechlegRight_mechID": 2,
    "mechlegLeft_partLeftorRight": 0,
    "mechlegRight_partLeftorRight": 1,
    "mechlegLeft_slot1": "",
    "mechlegRight_slot1": "",
    "mechlegLeft_slot2": "",
    "mechlegRight_slot2": "",
    "mechlegLeft_slot3": "",
    "mechlegRight_slot3": "",
    "mechlegLeft_slot4": "",
    "mechlegRight_slot4": "",
    "mechlegLeft_slot5": "",
    "mechlegRight_slot5": "",
    "mechlegLeft_slot6": "",
    "mechlegRight_slot6": "",
    "mechtorsoLeft_id": 2,
    "mechtorsoRight_id": 4,
    "mechtorsoLeft_mechID": 2,
    "mechtorsoRight_mechID": 2,
    "mechtorsoLeft_partLeftorRight": "0",
    "mechtorsoRight_partLeftorRight": "1",
    "mechtorsoLeft_slot1": "",
    "mechtorsoRight_slot1": "",
    "mechtorsoLeft_slot10": "",
    "mechtorsoRight_slot10": "",
    "mechtorsoLeft_slot11": "",
    "mechtorsoRight_slot11": "",
    "mechtorsoLeft_slot12": "",
    "mechtorsoRight_slot12": "",
    "mechtorsoLeft_slot2": "",
    "mechtorsoRight_slot2": "",
    "mechtorsoLeft_slot3": "",
    "mechtorsoRight_slot3": "",
    "mechtorsoLeft_slot4": "",
    "mechtorsoRight_slot4": "",
    "mechtorsoLeft_slot5": "",
    "mechtorsoRight_slot5": "",
    "mechtorsoLeft_slot6": "",
    "mechtorsoRight_slot6": "",
    "mechtorsoLeft_slot7": "",
    "mechtorsoRight_slot7": "",
    "mechtorsoLeft_slot8": "",
    "mechtorsoRight_slot8": "",
    "mechtorsoLeft_slot9": "",
    "mechtorsoRight_slot9": "",
    "mechtorsocenter_id": 2,
    "mechtorsocenter_mechID": 2,
    "mechtorsocenter_partLeftorRight": "2",
    "mechtorsocenter_slot1": "",
    "mechtorsocenter_slot10": "",
    "mechtorsocenter_slot11": "",
    "mechtorsocenter_slot12": "",
    "mechtorsocenter_slot2": "",
    "mechtorsocenter_slot3": "",
    "mechtorsocenter_slot4": "",
    "mechtorsocenter_slot5": "",
    "mechtorsocenter_slot6": "",
    "mechtorsocenter_slot7": "",
    "mechtorsocenter_slot8": "",
    "mechtorsocenter_slot9": ""
}
*/

$method = 'update';

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

try {
    $mechId = $data['mechs_mechID'] ?? -1;
    $mechName = $data['mechs_mechName'] ?? '';
    $mechModel = $data['mechs_mechModel'] ?? '';

    $findExistingMechSql = "SELECT 1 FROM mechs WHERE mechName = ? AND mechModel = ?";
    $findExistingMech = mysqli_prepare($conn, $findExistingMechSql);
    $findExistingMechRes = bindFetch($findExistingMech, [$mechName, $mechModel]);

    if ($findExistingMechRes === false) {
        echo json_encode(['error' => 'Invalid JSON']);
    }

    if (count($findExistingMechRes) === 0) {
        // Insert a new mech entry
        $insertMechSql = "INSERT INTO mechs (mechName, armor, maxTonnage, introDate, mechModel, era, techBase, productionYear) 
            VALUES (?,?,?,?,?,?,?,?)";

        $insertMech = mysqli_prepare($conn, $insertMechSql);
        $bindVals = [
            $mechName,
            $data['mechs_armor'] ?? 0,
            $data['mechs_maxTonnage'] ?? 0,
            $data['mechs_introDate'] ?? null,
            $mechModel,
            $data['mechs_era'] ?? '',
            $data['mechs_techBase'] ?? '',
            $data['mechs_productionYear'] ?? null,
        ];

        $insertMechRes = bindExecute($insertMech, $bindVals);

        if ($insertMechRes === false) {
            echo json_encode(['error' => 'Invalid JSON']);
        }

        // Get the new mech ID
        $mechId = mysqli_insert_id($conn);
        $method = 'insert';
    }

    $tableDataToUpdate = [];
    foreach($data as $key => $val) {
        list($tableAlias, $colName) = explode('_', $key, 2);
        $tableDataToUpdate[$tableAlias][$colName] = $val;
    }

    foreach($tableDataToUpdate as $tableAlias => $cols) {
        unset($cols['id']);
        if (isset($cols['mechID'])) {
            $cols['mechID'] = $mechId;
        }

        $officialTableName = $tableAlias;
        if ($tableAlias === 'mecharmLeft' || $tableAlias === 'mecharmRight') {
            $officialTableName = 'mecharm';
        }
        if ($tableAlias === 'mechlegLeft' || $tableAlias === 'mechlegRight') {
            $officialTableName = 'mechleg';
        }
        if ($tableAlias === 'mechtorsoLeft' || $tableAlias === 'mechtorsoRight') {
            $officialTableName = 'mechtorso';
        }
        $extraBindVal = [];

        $insertSql = "INSERT INTO $officialTableName (" . rtrim(implode(',', array_keys($cols)), ',') . ") "
        . "VALUES (" . rtrim(str_repeat('?,', count($cols)), ',') . ");";

        $updateSql = "UPDATE $officialTableName SET ";
        foreach($cols as $colName => $colVal) {
            $updateSql .= $colName . '=?,';
        }
        $updateSql = rtrim($updateSql, ',');
        $updateSql .= " WHERE mechID = ?";
        if ($officialTableName !== $tableAlias && $method === 'update') {
            $updateSql .= " AND partLeftorRight = ?";
            $extraBindVal = [$cols['partLeftorRight']];
        }

        $queryToRun = ($method === 'update' || $officialTableName === 'mechs') ? $updateSql : $insertSql;
        $bindVals = ($method === 'update' || $officialTableName === 'mechs') ? array_merge(array_values($cols), [$mechId]) : array_values($cols);
        
        if (!empty($extraBindVal)) {
            $bindVals = array_merge($bindVals, $extraBindVal);
        }

        $res = mysqli_prepare($conn, $queryToRun);
        $resRes = bindExecute($res, $bindVals);
    }
    echo json_encode(['success' => true, 'mechId' => $mechId]);

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}

?>
