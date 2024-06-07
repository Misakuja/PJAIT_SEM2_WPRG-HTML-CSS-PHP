<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="" rel="stylesheet" type="text/css">
</head>
<body>
<form method='post' action="">
    <fieldset>
        <button type='submit'>Drop Table</button>
        <input type="hidden" name="dropTable" value="dropTable">
    </fieldset>
</form>
</body>
</html>
<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'MyN3wP4ssw0rd';
$dbname = 'Student';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass);

$mysqli->query("CREATE DATABASE IF NOT EXISTS $dbname");
$mysqli->select_db($dbname);

if ($mysqli->connect_errno) {
    printf(
        "Connect failed: %s<br />", $mysqli->connect_error);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dropTable'])) {
    mysqli_query($mysqli, "DROP TABLE IF EXISTS $dbname");
}

$sql = "CREATE TABLE IF NOT EXISTS Student( " .
    "studentID INT NOT NULL AUTO_INCREMENT, " .
    "firstName VARCHAR(255) NOT NULL, " .
    "SecondName VARCHAR(255) NOT NULL, " .
    "Salary INT NOT NULL, " .
    "DateOfBirth DATE NOT NULL, " .
    "PRIMARY KEY ( studentID )); ";

if ($mysqli->query($sql)) {
    printf("Table " . $dbname . " created successfully.<br />");
} else printf("Table " . $dbname . " already exists.<br />");
?>
