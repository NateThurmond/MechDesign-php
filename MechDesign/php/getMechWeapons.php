<?php

require_once "../config/config.php";
include "DB_Conn.php";

$res = mysqli_query(
    $conn,
    "
    SELECT weaponName, damage, heat, rangeMin, rangeShort, rangeMed, rangeLong,
        tons, slotsRequired, ammoNeeded, weaponType, availableDate, techBase
    FROM mechweapons
    ORDER BY weaponName ASC
    ;
    "
);

$dataByWeaponName = [];
$weaponArray = [];
while ($row = mysqli_fetch_assoc($res)) {
    $weaponArray[] = $row;
    extract($row);
    $data[$weaponName] = $row;
}

echo json_encode([$data, $weaponArray]);

?>