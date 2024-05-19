<?php
function reverse($inputString) : string {
    return strrev($inputString);
}
function uppercase($inputString) : string {
    return strtoupper($inputString);
}
function lowercase($inputString) : string {
    return strtolower($inputString);
}
function countAmount($inputString) : string {
    return strlen($inputString);
}
function deleteWhitespaces($inputString) : string {
    return preg_replace('/\s+/','',$inputString);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <link href="LAB08_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="formResult">
<div class='formBox'>
    <form method='post' action="">
        <fieldset id='formFieldset'>
            <legend>STRING CONVERTER</legend>
            <label for='string'></label>
            <input type='text' id='string' name='string' placeholder="Input your string" required>

            <label for='operation'></label>
            <select id='operation' name='operation' required>
                <option value="" disabled selected>Select operation</option>
                <option value="reverse">Reverse string</option>
                <option value="uppercase">Change to uppercase</option>
                <option value="lowercase">Change to lowercase</option>
                <option value="count">Count amount of symbols</option>
                <option value="whitespaces">Delete whitespaces</option>
            </select>

            <button type='submit'>Submit</button>
        </fieldset>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["string"]) + isset($_POST["operation"])) {
        $inputString = $_POST["string"];
        $operation = $_POST["operation"];

        $resultString = "";

        switch ($operation) {
            case "reverse":
                $resultString = reverse($inputString);
                break;
            case "uppercase":
                $resultString = uppercase($inputString);
                break;
            case "lowercase":
                $resultString = lowercase($inputString);
                break;
            case "count":
                $resultString = countAmount($inputString);
                break;
            case "whitespaces":
                $resultString = deleteWhitespaces($inputString);
                break;
        }
        echo "<div class='result'>The result is: " . $resultString . "</div>";

    }
}
?>
</div>
</body>
</html>
