<?php

session_start();

$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error " . mysqli_error($conn));

