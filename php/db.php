<?php
// This file is used to set database user credentials.
// Expected user has full control over the set database, recommend making user+db together in mysql/mariadb for simplicity.
// Recommend storing this file outside of web server root, then set path to file in PHP scripts that perform DB operations.

// Hostname/IP of database server. If database is on web server host, set to localhost.
$dbhost = "localhost";

// Name of the database used for AG Locator.
$dbname = "cheatsheet";

// Name of the database user account with full control permissions for database in use ($dbname).
$dbuser = "root";

// Password for database user account set in $dbuser.
$dbpass = "";

// ---------------------------
// DO NOT EDIT BELOW THIS LINE
// Set defaul connection params
global $test_db;

$test_db = new mysqli();
$test_db->connect($dbhost, $dbuser, $dbpass, $dbname);
$test_db->set_charset("utf8");

// Check Connection
if ($test_db->connect_errno) {
    printf("Connect failed: %s\n", $test_db->connect_error);
    exit();
}
?>
