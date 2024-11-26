<?php

require_once("../config/config.php");
include("../php/DB_Conn.php");

$query = "SELECT * FROM mechs NATURAL JOIN mechengine";
$data = mysqli_query($conn, $query);

$return = [];
while ($row = mysqli_fetch_assoc($data)) {
    $return[] = $row;
}
echo json_encode($return);