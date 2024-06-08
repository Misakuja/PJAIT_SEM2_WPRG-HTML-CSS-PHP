<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage MySQL Table</title>
    <link href="LAB12_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Manage MySQL Table</h1>
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
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'student';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    printf("Connect failed: %s<br />", $mysqli->connect_error);
    exit();
}
$mysqli->query("CREATE DATABASE IF NOT EXISTS $dbname");
$mysqli->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS Student( " .
    "studentID INT NOT NULL AUTO_INCREMENT, " .
    "firstName VARCHAR(255) NOT NULL, " .
    "SecondName VARCHAR(255) NOT NULL, " .
    "Salary INT NOT NULL, " .
    "DateOfBirth DATE NOT NULL, " .
    "PRIMARY KEY ( studentID )); ";

if ($mysqli->query($sql) === TRUE) {
    printf("Table " . $dbname . " created successfully.<br />");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dropTable'])) {
    $mysqli->query("DROP TABLE student");
    printf("Table dropped successfully<br>");
}
$mysqli->close();
?>
