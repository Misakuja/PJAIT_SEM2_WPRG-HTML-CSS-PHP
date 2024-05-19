<?php
function Union($arrayA, $arrayB): array {
    return array_unique(array_merge($arrayA, $arrayB));
}

function Except($arrayA, $arrayB): array {
    return array_diff($arrayA, $arrayB);
}

function Intersect($arrayA, $arrayB): array {
    return array_intersect($arrayA, $arrayB);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Number Sequence Calculator</title>
    <link href="LAB07_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class='style form'>
    <form method='post' action="">
        <div class="title"><h1>Number Sequence Calculator</h1></div>
        <fieldset id='Form'>
            <label for='sequenceA'>Sequence A (Values separated by commas)</label>
            <input type='text' id='sequenceA' name='sequenceA' required>

            <label for='sequenceB'>Sequence B (Values separated by commas)</label>
            <input type='text' id='sequenceB' name='sequenceB' required>

            <label for='operation'>Operation</label>
            <select id='operation' name='operation' required>
                <option value="Union">Union</option>
                <option value="Except">Except</option>
                <option value="Intersect">Intersect</option>
            </select>
            <button type='submit'>Calculate</button>
        </fieldset>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sequenceA"]) && isset($_POST["sequenceB"]) && isset($_POST["operation"])) {
        $sequenceA = $_POST["sequenceA"];
        $sequenceB = $_POST["sequenceB"];
        $operation = $_POST["operation"];

        $arrayA = explode(',', $sequenceA);
        $arrayB = explode(',', $sequenceB);

        $newArray = [];


        echo "<div class='resultantDiv'>";
            echo "<div class='style array'>";
            echo "<div class='title resultArrayTitle'>" . "The resultant array:<br>";
            echo "</div>";
            echo "<div class='newArray arrayStyle'>";
        switch ($operation) {
            case "Union":
                $newArray = Union($arrayA, $arrayB);
                echo implode(', ', $newArray);
                break;
            case "Except":
                $newArray = Except($arrayA, $arrayB);
                echo implode(', ', $newArray);
                break;
            case "Intersect":
                $newArray = Intersect($arrayA, $arrayB);
                echo implode(', ', $newArray);
                break;
        }
        echo "</div>";
        echo "</div>";
    }
}
?>
</body>
</html>