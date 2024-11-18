
<?php

    require_once("../config/config.php");
    include("../php/DB_Conn.php");
    include("../php/sqlPrepare.php");

    $mechID = filter_input(INPUT_GET, 'mechIDPassed', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;

    $queryMaxTonnage = mysqli_prepare($conn, "SELECT * FROM mechs WHERE mechID = ?");
    $queryMaxTonnageRes = bindFetch($queryMaxTonnage, [$mechID]);
    echo json_encode($queryMaxTonnageRes[0]);
?>