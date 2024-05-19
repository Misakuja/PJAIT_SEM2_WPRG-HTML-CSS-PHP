<?php
function calcDate($inputYear) : string {
    if ($inputYear <= 0 ) throw new Exception('ERROR - Invalid year input.');

    $x = 0;
    $y = 0;
    switch($inputYear) {
        case 1-1582:
            $x = 15;
            $y = 6;
            break;
        case 1583-1699:
            $x = 22;
            $y = 3;
            break;
        case 1700-1799:
            $x = 23;
            $y = 3;
            break;
        case 1800-1899:
            $x = 23;
            $y = 4;
            break;
        case 1900-2099:
            $x = 24;
            $y = 5;
            break;
        case 2100-2199:
            $x = 24;
            $y = 6;
            break;
    }
    $a = $inputYear % 19;
    $b = $inputYear % 4;
    $c = $inputYear % 7;
    $d = (19 * $a + $x) % 30;
    $e = (2 * $b + 4 * $c + 6 * $d + $y) % 7;

    if ($e == 6 && $d == 29) {
        return "26.04.$inputYear";
    }
    else if ($e == 6 && $d == 28 && ((11 * $x + 11) % 30 < 19)) {
        return "18.04.$inputYear";
    }
    else if (($d + $e) < 10) {
        return (22 + $d + $e).".03.$inputYear";
    }
    else if (($d + $e) > 9) {
        return ($d + $e - 9).".04.$inputYear";
    }
    return "ERROR";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Easter Date Calculator</title>
    <link href="LAB07_Ex06.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1 id="mainTitle">Easter Date Calculator</h1>
<div class='formResult'>
    <div class='formResultBox'>
    <form method='post' action="">
        <fieldset id='formFieldset'>
            <label for='year'>Input the year</label>
            <input type='number' id='year' name='year' required>

            <button type='submit'>Calculate</button>
        </fieldset>
    </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<div class='result'>";
    try {
        if (isset($_POST["year"])) {
        echo "Easter date: ";
        echo calcDate($_POST["year"]);
        }

        } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "</div>";
}
?>
</div>
</div>
</body>
</html>