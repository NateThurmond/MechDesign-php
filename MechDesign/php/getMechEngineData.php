<?php

require_once("../config/config.php");
include("../php/DB_Conn.php");
require_once('sqlPrepare.php');

$engineName = filter_input(INPUT_GET, 'engineName', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;

/* This query determines what type of engine this mech can carry. Usually, under introductory rules only one
engine type is allowed but expansion of this site later will need to be able to handle different engine types. */
$queryAllMechSql = "
    SELECT
        mechengine.*
    FROM
        mechengine
    WHERE
        mechengine.engineName = ?
    LIMIT 1
    ;
";
$queryAllMech = mysqli_prepare($conn, $queryAllMechSql);
$queryAllMechRes = bindFetch($queryAllMech, [$engineName]);
$conn->close();

extract($queryAllMechRes[0]);

echo json_encode(compact('engineName', 'engineRating', 'mechWalk', 'mechRun', 'mechJump'));

?>
