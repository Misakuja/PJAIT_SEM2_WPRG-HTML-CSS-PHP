<html>
<head><title>Creating MySQL Table</title></head>
<body>
<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'MyN3wP4ssw0rd';
$dbname = 'Student';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass);
if ($mysqli->connect_errno) {
    printf(
        "Connect failed: %s<br />", $mysqli->connect_error);
    exit();
}
printf('Connected successfully.<br />');

$mysqli->query("CREATE DATABASE IF NOT EXISTS $dbname");
$mysqli->select_db($dbname);
$sql = "CREATE TABLE $dbname( " .
    "tutorial_id INT NOT NULL AUTO_INCREMENT, " .
    "tutorial_title VARCHAR(100) NOT NULL, " .
    "tutorial_author VARCHAR(40) NOT NULL, " .
    "submission_date DATE, " .
    "PRIMARY KEY ( tutorial_id )); ";
if ($mysqli->query($sql)) {
    printf("Table" . $dbname . "created successfully.<br />");
}
if
($mysqli->errno) {
    if ($mysqli->query("DROP TABLE tutorials_tbl")) {
        printf("Table " . $dbname . " dropped succesfully");
    } else {
        printf("Could not create table: %s<br />", $mysqli->error);
    }
}
$mysqli->close();
?>
</body>
</html>