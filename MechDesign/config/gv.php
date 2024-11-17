<?php

function getUUID() {
    // Generate a random 32-character hexadecimal string
    $data = random_bytes(16);

    // Set certain bits to make it a valid UUID version 4
    // Set the version (4 bits) and variant (2-3 bits)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);  // version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);  // variant 10xx

    // Format the bytes as a UUID string
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function unsetGV() {
    /*
        Don't really know what the purpose of this function might have been.
        It's called after wiping DB gv's and unsetting cookie so it doesn't seem
        like there was much else to do.
    */
}

?>