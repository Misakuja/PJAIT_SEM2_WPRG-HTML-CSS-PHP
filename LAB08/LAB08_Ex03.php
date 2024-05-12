<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analyser and Transformer of Text with Regex in PHP</title>
    <link href="LAB08_Ex03.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1 id="mainTitle">Analyser and Transformer of Text with Regex in PHP</h1>
<div class="formResult">
    <form method='post' action="">
        <fieldset>
            <div class=formWrap>
                <label for='inputText'>Input the text to analyze</label>
                <input type='text' id='inputText' name='inputText' required>

                <label for='inputRegex'>Input Regex</label>
                <input type='text' id='inputRegex' name='inputRegex' required>

                <label for='operation'></label>
                <select id='operation' name='operation' required onchange="ifReplace()">>
                    <option value="" disabled selected>Select operation</option>
                    <option value="match">Find matches</option>
                    <option value="matchPositions">Find matches and positions</option>
                    <option value="replace">Replace text that matches the</option>
                    <option value="validate">Validate; check if text matches the regex</option>
                </select>

                <label for='replaceText'></label>
                <input type='text' id='replaceText' name='replaceText'
                       placeholder="Input the text you'd like to replace the regex to" required>
                <script>
                    function ifReplace() {
                        let operation = document.getElementById("operation").value;
                        if (operation === "replace") {
                            document.getElementById("replaceText").style.display = "block";
                        } else {
                            document.getElementById("replaceText").style.display = "none";
                        }
                    }
                </script>
                <button type='submit'>Execute</button>
            </div>
        </fieldset>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputText = $_POST["inputText"];
        $regex = $_POST["inputRegex"];
        $operation = $_POST["operation"];
        $replaceText = $_POST["replaceText"];

        $regex = "/" . str_replace("/", "\\/", $_POST["inputRegex"]) . "/";

        echo "<div class='result'>";
        switch ($operation) {
            case "match":
                preg_match_all($regex, $inputText, $matches);
                foreach ($matches[0] as $match) {
                    echo "Match: " . $match . "<br/>";
                }
                break;
            case "matchPositions":
                preg_match_all($regex, $inputText, $matches, PREG_OFFSET_CAPTURE);
                foreach ($matches[0] as $match) {
                    echo "Match: " . $match[0] . " Position: " . $match[1] . "<br/>";
                }
                break;
            case "replace":
                $array = preg_replace($regex, $replaceText, $inputText);
                echo $array;
                break;
            case "validate":
                if (preg_match($regex, $inputText) && preg_match('/^' . $regex . '$/', $inputText)) {
                    echo "Text matches the pattern.";
                } else {
                    echo "Text does not match the pattern.";
                }
                break;
        }
        echo "</div>";
    }
    ?>
</div>
</body>
</html>