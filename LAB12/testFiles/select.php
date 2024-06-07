<html>
<head><title>Creating MySQL Table</title></head>
<body>
<?php
$dbhost = 'szuflandia.pjwstk.edu.pl';
$dbuser = 's30284';
$dbpass = 'Ann.Turo';
$dbname = 's30284';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s<br />", $mysqli->connect_error);
    exit();
}
printf('Connected successfully.<br />');
$sql = "SELECT tutorial_id, tutorial_title, tutorial_author, submission_date FROM tutorials_tbl";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        printf("Id: %s, Title: %s, Author: %s, Date: %d <br />", $row["tutorial_id"], $row["tutorial_title"], $row["tutorial_author"], $row["submission_date"]);
    }
} else {
    printf('No record found.<br />');
}
mysqli_free_result($result);
$mysqli->close();
?>
</body>
</html>