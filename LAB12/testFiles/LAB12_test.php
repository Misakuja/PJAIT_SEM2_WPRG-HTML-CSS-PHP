<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbhost = 'localhost';
$dbuser = 'Miskauja';
$dbpass = '';
$dbname = 'tutorial';

$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$mysql->query("CREATE DATABASE TUTORIALS");

if ($mysql->connect_errno) {
    printf("Connect failed: %s\n", $mysql->connect_error);
    exit();
}
printf('Connected successfully.');

if ($mysql->query("CREATE DATABASE TUTORIALS")) {
    printf("Database TUTORIALS created successfully.");
    $retval = mysqli_select_db($mysql, "TUTORIALS");
    printf("Database TUTORIALS created successfully.");
}