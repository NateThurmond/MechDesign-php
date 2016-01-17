<?php

function getUUID(){
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);// ""
    return $uuid;
}

function unsetGV() {
    unset($GLOBALS['user_name']);
    unset($GLOBALS['created_at']);
    unset($GLOBALS['user_email']);
    unset($GLOBALS['user_login_status']);
    unset($GLOBALS['user_id']);
    unset($GLOBALS['clientFilter']);
    unset($GLOBALS['gcmid']);
    unset($GLOBALS['serial']);
    unset($GLOBALS['filter']);
}

function checkLogin($uuid) {
    
    if (isset($uuid)) {
        if ($uuid != "") {

            $userConn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            $getUUIDsql = mysqli_prepare($userConn, "SELECT uuid, gv FROM uuid WHERE uuid = ?");
            $result = bindFetch($getUUIDsql, [$uuid]);

            if (count($result) <= 0) {
                // UUID's do not match.
                return false;
            }
            else {
                $gvs = json_decode($result[0]['gv']);

                // create time was over 4 hours ago
                if ($gvs->created_at <= time() - TIMEOUT) {
                    
                    $delete_UUID_query = mysqli_prepare($userConn, "DELETE FROM uuid WHERE `uuid`=?");
                    $resultDelete = bindExecute($delete_UUID_query, [$_COOKIE['UUID']]);
                    mysqli_stmt_close($delete_UUID_query);

                    unsetGV();
                    setcookie("UUID", "", time()-99999);
                    return false;
                }
                // create time is recent
                else {
                    $gvs->created_at = time();

                    foreach ($gvs as $key => $val) {
                        $GLOBALS[$key] = $val;
                    }

                    // Update the timestamp
                    $update_GV_Query = mysqli_prepare($userConn, "UPDATE `uuid` SET `gv`=?, `lastActivityTimeStamp`=now() WHERE `uuid`=?");
                    $resultUpdate = bindExecute($update_GV_Query, [json_encode($gvs), $_COOKIE["UUID"]]);
                    mysqli_stmt_close($update_GV_Query);

                    return true;
                }
            }

            $userConn->close();
        }
    }
    return false;
}