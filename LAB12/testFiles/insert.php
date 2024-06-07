<html>
<head><title>Add
        New
        Record in MySQL Database</title></head>
<body>
<?php
if
(
    isset
    ($_POST['add'])) {
    $dbhost = 'szuflandia.pjwstk.edu.pl';
    $dbuser = 's30284';
    $dbpass = 'Ann.Turo';
    $dbname = 's30284';
    $mysqli =
        new
        mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if
    ($mysqli->connect_errno) {
        printf(
            "Connect failed: %s<br />"
            , $mysqli->connect_error);
        exit
        ();
    }
    printf(
        'Connected successfully.<br />'
    );
    $tutorial_title = $_POST['tutorial_title'];
    $tutorial_author = $_POST['tutorial_author'];
    $submission_date = $_POST['submission_date'];
    $sql =
        "INSERT INTO tutorials_tbl " . "(tutorial_title,tutorial_author, submission_date) " .
        "VALUES " . "('$tutorial_title','$tutorial_author','$submission_date')";
    if
    ($mysqli->query($sql)) {
        printf(
            "Record inserted successfully.<br />"
        );
    }
    if
    ($mysqli->errno) {
        printf(
            "Could not insert record into table: %s<br />"
            , $mysqli->error);
    }
    $mysqli->close();
} else {
//$_PHP_SELF oznacza wykonanie skryptu będącego w pliku .php (w tym przypadku kodu powyżej)
    ?>
    <form method="post" action="">
        <table width="600" border="0" cellspacing="1" cellpadding="2">
            <tr>
                <td width="250"
                >Tutorial Title
                </td>
                <td><input name="tutorial_title" type="text" id="tutorial_title"></td>
            </tr>
            <tr>
                <td width="250">Tutorial Author
                </td>
                <td><input name="tutorial_author" type="text" id="tutorial_author"></td>
            </tr>
            <tr>
                <td width="250">Submission Date [ yyyy-mm-dd ]
                </td>
                <td><input name="submission_date" type="text" id="submission_date"></td>
            </tr>
            <tr>
                <td width="250"></td>
                <td></td>
            </tr>
            <tr>
                <td width="250"></td>
                <td><input name="add" type="submit" id="add" value="Add Tutorial"></td>
            </tr>
        </table>
    </form>
    <?php
}
?>
</body>
</html>