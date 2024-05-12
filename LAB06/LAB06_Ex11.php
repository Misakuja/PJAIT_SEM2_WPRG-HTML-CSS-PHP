<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fahrenheit / Celsius Calc</title>
    <link href="LAB06_Ex11.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$howMany = $_POST["howMany"] ?? 0;
$currentCount = $_POST["currentCount"] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["dc"])) {
        $celsiusArray = unserialize($_POST["dc"]);
    } else {
        $celsiusArray = [];
    }
    if (isset($_POST["df"])) {
        $fahrenheitArray = unserialize($_POST["df"]);
    } else {
        $fahrenheitArray = [];
    }

    $curr = $currentCount - 1;
    if (isset($_POST["celsius_$curr"])) {
        $celsiusArray[] = $_POST["celsius_$curr"];
    }
    if (isset($_POST["fahrenheit_$curr"])) {
        $fahrenheitArray[] = $_POST["fahrenheit_$curr"];
    }
    if (count($celsiusArray) == $howMany && count($fahrenheitArray) == $howMany) {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Celsius</th>";
        echo "<th>Fahrenheit</th>";
        echo "<th>Fahrenheit</th>";
        echo "<th>Celsius</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        for ($i = 0; $i < $howMany; $i++) {
            echo "<tr>";
            echo "<td>" . ($celsiusArray[$i] ?? "") . "</td>";
            echo "<td>" . ($celsiusArray[$i] ? (($celsiusArray[$i] * 9/5) + 32) : "") . "</td>";
            echo "<td>" . ($fahrenheitArray[$i] ?? "") . "</td>";
            echo "<td>" . ($fahrenheitArray[$i] ? (($fahrenheitArray[$i] - 32) * 5/9) : "") . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

    } else if ($currentCount < $howMany) {
        echo "<form method='post'>";
        echo "<fieldset id='nextInputForm'>";

        echo "<label for='celsius'>Celsius Value:</label>";
        echo "<input type='number' id='celsius' name='celsius_$currentCount' required>";

        echo "<label for='fahrenheit'>Fahrenheit Value:</label>";
        echo "<input type='number' id='fahrenheit' name='fahrenheit_$currentCount' required>";

        echo "<button type='submit'>Submit</button>";

        echo "<input type='hidden' name='howMany' value='$howMany'>";

        $dc = serialize($celsiusArray);
        echo "<input type='hidden' name='dc' value='$dc'>";
        $df= serialize($fahrenheitArray);
        echo "<input type='hidden' name='df' value='$df'>";

        echo "<input type='hidden' name='currentCount' value='" . ($currentCount + 1) . "'>";

        echo "</fieldset>";
        echo "</form>";
    }
} else {
    echo "<form method='post'>";
    echo "<fieldset id='initialForm'>";

    echo "<div id='textInitial'><label for='howMany'>How many values would you like to convert?</label></div>";
    echo "<div><input type='number' id='howMany' name='howMany' required></div>";
    echo "<div><button type='submit'>Submit</button></div>";

    echo "</fieldset>";
    echo "</form>";
}
?>
</body>
</html>
