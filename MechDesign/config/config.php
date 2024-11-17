<?php

// Load environment variables from the .env file (from the root directory)
require_once __DIR__ . '/../../vendor/autoload.php';  // Adjust path if necessary
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // Path to root directory
$dotenv->load();

/*
    This is not how I would normally store creds these days but I just need to get this project
    up and running for some screenshots to see how it use to look. It was one of my first college
    projects, however it stored separate database stuff which is lost to time and I'll need to reverse
    engineer
*/

define('DBHOST', getenv('MYSQL_HOST'));
define('DBUSER', getenv('MYSQL_USER'));
define('DBPASS', getenv('MYSQL_PASSWORD'));
define('DBNAME', getenv('MYSQL_DATABASE'));
define('MAX_PASS_LOGIN', 5);
define('TIMEOUT', 86400);

?>