<?php
function checkVisits() : int {
    if(file_exists("LAB09_Ex02.txt")) {
        $visits = (int)file_get_contents("LAB09_Ex02.txt");
        $visits++;
        file_put_contents("LAB09_Ex02.txt", $visits);
        return $visits;
    }
    return 0;
}
function resetVisits() : int {
    file_put_contents("LAB09_Ex02.txt", 0);
    return 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Views Counter</title>
    <link href="LAB09_Ex02.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="flexBox">
<h1 id="header">Website Views Counter</h1>
<p id="visits">Total visits:
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        resetVisits();
        echo resetVisits() + 1;
    } else echo checkVisits();
    ?>
</p>
<form method='post' action="">
    <fieldset>
        <button type='submit'>Reset</button>
    </fieldset>
</form>
</div>
</body>
</html>
