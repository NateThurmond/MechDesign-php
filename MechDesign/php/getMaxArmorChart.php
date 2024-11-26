<?php

require_once("../config/config.php");
include("DB_Conn.php");

$res = mysqli_query(
    $conn,
    'Select mechTonnage, torsoMax, armMax, legMax, centerTorsoMax FROM maxarmorfortonnage WHERE 1'
);

$data = [];
while($row = mysqli_fetch_assoc($res)) {
    $data[$row['mechTonnage']] = $row;
}

echo json_encode($data);

?>
