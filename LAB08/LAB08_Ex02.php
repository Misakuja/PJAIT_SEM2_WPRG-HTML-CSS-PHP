<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced String Analyzer</title>
    <link href="LAB08_Ex02.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="formResult">
    <div class='formBox'>
        <form method='post' action="">
            <fieldset id='formFieldset'>
                <div class=formWrap>
                    <h1>Advanced String Analyzer</h1>
                    <label for='string'></label>
                    <input type='text' id='string' name='string' placeholder="Input your string" required>

                    <h3>Count frequency of unique:</h3>
                    <div class="radioWrapper">
                        <input type='radio' id='uniqueLetters' name='radio' value="uniqueLetters">
                        <label for='uniqueLetters'>Letters</label>

                        <input type='radio' id='uniqueWords' name='radio' value="uniqueWords">
                        <label for='uniqueWords'>Words</label>
                    </div>
                    <h3>Sort alphabetically:</h3>
                    <div class="radioWrapper">
                        <input type='radio' id='alphabeticallyAscending' name='radio2' value="alphabeticalAscending">
                        <label for='alphabeticallyAscending'>Ascending</label>

                        <input type='radio' id='alphabeticallyDescending' name='radio2' value="alphabeticalDescending">
                        <label for='alphabeticallyDescending'>Descending</label>
                    </div>
                    <div class="splitWrapper"
                    <h3>Split string:</h3>
                    <input type='checkbox' id='checkbox' name='checkbox' value="split">
                    <label for='checkbox'>Yes</label>
                    </div>

                    <h4>Every how many letters do you want the split to be?</h4>
                    <label for='splitGap'></label>
                    <input type='number' id='splitGap' name='splitGap'>

                    <button type='submit'>Analyze</button>
                </div>

    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["string"])) {
            $inputString = $_POST["string"];
            $uniqueRadio = $_POST["radio"] ?? NULL;
            $alphabetRadio = $_POST["radio2"] ?? NULL;
            $splitCheckbox = $_POST["checkbox"] ?? NULL;
            $splitGap = $_POST["splitGap"] ?? NULL;

            $resultString = "";
            $array = [];

            $inputString = strtolower($inputString);

            if ($uniqueRadio === "uniqueLetters") $array = array_count_values(str_split(preg_replace('/\s+/', '', $inputString)));
            else if ($uniqueRadio === "uniqueWords") {
                if ($splitCheckbox === "split") {
                    $inputString = preg_replace('/\s+/', '', $inputString);
                    $array = str_split($inputString, $splitGap);
                    $inputString = implode(" ", $array);
                    $array = array_count_values(str_word_count($inputString, 1));
                } else $array = array_count_values(str_word_count($inputString, 1));

            }
            if (!isset($uniqueRadio) && $splitCheckbox === "split") $array = str_split(preg_replace('/\s+/', '', $inputString), $splitGap);

            if (!isset($uniqueRadio) && !isset($splitCheckbox)) $array = explode(" ", $inputString);


            if (isset($uniqueRadio)) {
                if ($alphabetRadio === "alphabeticalAscending") {
                    ksort($array);
                } else if ($alphabetRadio === "alphabeticalDescending") {
                    krsort($array);
                }
            } else {
                if ($alphabetRadio === "alphabeticalAscending") {
                    sort($array);
                } else if ($alphabetRadio === "alphabeticalDescending") {
                    arsort($array);
                }
            }
            if (!isset($uniqueRadio)) {
                echo "<div class='result'>";
                foreach ($array as $key => $value) {
                    echo $value . " ";
                }
            } else {
                echo "<div class='resultTable'>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>" . "Word" . "</th>";
                echo "<th>" . "Frequency" . "</th>";
                echo "<tbody>";
                foreach ($array as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . $key . "</td>";
                    echo "<td>" . $value . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            echo "</div>";
        }
    }
    ?>
</body>
</html>
