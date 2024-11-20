<?php

require_once("../config/config.php");
include("../php/DB_Conn.php");
require_once('sqlPrepare.php');

$mechID = filter_input(INPUT_GET, 'mechIDPassed', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;

/* This query determines what type of engine this mech can carry. Usually, under introductory rules only one
engine type is allowed but expansion of this site later will need to be able to handle different engine types. */
$queryAllMechSql = "
    SELECT
        mechs.*,
        '|||leftArm',
        mecharmLeft.*,
        '|||rightArm',
        mecharmRight.*,
        '|||mechenginge',
        mechengine.*,
        '|||mechexternalarmor',
        mechexternalarmor.*,
        '|||mechhead',
        mechhead.*,
        '|||mechinternals',
        mechinternals.*,
        '|||leftLeg',
        mechlegLeft.*,
        '|||rightLeg',
        mechlegRight.*,
        '|||mechtorsoLeft',
        mechtorsoLeft.*,
        '|||mechtorsoRight',
        mechtorsoRight.*,
        '|||mechtorsocenter',
        mechtorsocenter.*
    FROM
        mechs
        LEFT JOIN mecharm mecharmLeft ON mechs.mechID = mecharmLeft.mechID AND mecharmLeft.partLeftorRight = 0
        LEFT JOIN mecharm mecharmRight ON mechs.mechID = mecharmLeft.mechID AND mecharmLeft.partLeftorRight = 1
        LEFT JOIN mechengine on mechs.mechID = mechengine.mechID
        LEFT JOIN mechexternalarmor on mechs.mechID = mechexternalarmor.mechID
        LEFT JOIN mechhead on mechs.mechID = mechhead.mechID
        LEFT JOIN mechinternals on mechs.mechID = mechinternals.mechID
        LEFT JOIN mechleg mechlegLeft ON mechs.mechID = mechlegLeft.mechID AND mechlegLeft.partLeftorRight = 0
        LEFT JOIN mechleg mechlegRight ON mechs.mechID = mechlegRight.mechID AND mechlegRight.partLeftorRight = 1
        LEFT JOIN mechtorso mechtorsoLeft ON mechs.mechID = mechtorsoLeft.mechID AND mechtorsoLeft.partLeftorRight = 0
        LEFT JOIN mechtorso mechtorsoRight ON mechs.mechID = mechtorsoRight.mechID AND mechtorsoRight.partLeftorRight = 1
        LEFT JOIN mechtorsocenter on mechs.mechID = mechtorsocenter.mechID
    WHERE
        mechs.mechID = ?
    LIMIT 1
    ;
";
$queryAllMech = mysqli_prepare($conn, $queryAllMechSql);
$queryAllMechRes = bindFetch($queryAllMech, [$mechID]);
$conn->close();

$preFix = '';
$data = [];
foreach($queryAllMechRes as $row) {
    foreach($row as $colName => $colVal) {
        if (stripos($colName, '|||') !== false) {
            $preFix = explode('|||', $colName)[1];
            continue;
        }
        $data[($preFix ? $preFix . '_' : '') . $colName] = $colVal;
    }
}

echo json_encode($data);

?>
