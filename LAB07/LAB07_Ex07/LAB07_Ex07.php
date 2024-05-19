<?php
function checkEmail($email) : string
{
    $regex = "/^[A-z0-9.]+@[A-z]+\.[A-z]{3}+$/";

    if (!preg_match($regex, $email)) {
        return "ERROR";
    }
    return $email;
}

function checkPhone($phone) : string
{
    $regex = "/^[+][0-9]/";

    if (!preg_match($regex, $phone)) {
        return "ERROR";
    }
    return $phone;
}
function checkCheckbox($checkbox1, $checkbox2) : string {
    if (isset($_POST['checkbox1'], $_POST['checkbox2'])) return $checkbox1 . $checkbox2;
    else if (isset($_POST['checkbox1']) && !isset($_POST['checkbox2'])) return $checkbox1 . "off";
    else if (!isset($_POST['checkbox1']) && isset($_POST['checkbox2'])) return "off" . $checkbox2;
    return "ERROR";
}
function checkboxDisplay($checkbox) : string {
    if($checkbox == "onon") return "Option 1 + Option 2";
    else if($checkbox == "onoff") return "Option 1";
    else if($checkbox == "offon") return "Option 2";
    return "ERROR";
}
function radioDisplay($radio) : string {
    if($radio == "radio1") return "Option 1";
    else if($radio == "radio2") return "Option 2";
    return "ERROR";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <link href="LAB07_Ex07.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1 id="mainTitle">Contact Form</h1>
<div class='formBox'>
    <form method='post' action="">
        <fieldset id='form'>
            <label for='fullName'></label>
            <input type='text' id='fullName' name='fullName' placeholder="Full Name" required>

            <label for='email'></label>
            <input type='email' id='email' name='email' placeholder="Email" required>

            <label for='phoneNumber'></label>
            <input type='text' id='phoneNumber' name='phoneNumber' placeholder="Phone Number" required>

            <label for='topic'></label>
            <select id='topic' name='topic' required>
                <option value="" disabled selected>Select Topic</option>
                <option value="Topic 1">Topic 1</option>
                <option value="Topic 2">Topic 2</option>
            </select>

            <label for='message'></label>
            <input type='text' id='message' name='message' placeholder="Your message here">

            <div class="checkboxRadioWrapper">
            <label for='checkbox1'>Choose options:</label>
            <div class="checkboxWrapper">
            <input type='checkbox' id='checkbox1' name='checkbox1'>
            <label for='checkbox1'>Option 1</label>
            </div>

            <div class="checkboxWrapper">
            <input type='checkbox' id='checkbox2' name='checkbox2'>
            <label for='checkbox2'>Option 2</label>
            </div>
            </div>

            <div class="checkboxRadioWrapper">
            <label for='radio1'>Choose one option:</label>
            <div class="radioWrapper">
            <input type='radio' id='radio1' name='radio' value='radio1'>
            <label for='radio1'>Option 1</label>
            </div>

            <div class="radioWrapper">
            <input type='radio' id='radio2' name='radio' value='radio2'>
            <label for='radio2'>Option 2</label>
            </div>
            <button type='submit'>Send</button>
            </div>
        </fieldset>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        if (isset($_POST["fullName"]) + isset($_POST["email"]) + isset($_POST["phoneNumber"]) + isset($_POST["topic"]) + isset($_POST["message"]) + isset($_POST["checkbox1"]) + isset($_POST["checkbox2"])){

            $fullName = $_POST["fullName"];
            $email = checkEmail($_POST["email"]);
            $phoneNumber = checkPhone($_POST["phoneNumber"]);
            $topic = $_POST["topic"];
            $message = $_POST["message"];
            $checkboxOptions = checkCheckbox($_POST["checkbox1"] ?? null, $_POST["checkbox2"] ?? null);
            $radio = $_POST["radio"];

            echo "<div class='resultBox'><h1>Input Info:</h1><ul>";
            echo "<li>" . $fullName . "</li>";
            echo "<li>" . $email . "</li>";
            echo "<li>" . $phoneNumber . "</li>";
            echo "<li>" . $topic . "</li>";
            echo "<li>" . $message . "</li>";
            echo "<li>" . checkboxDisplay($checkboxOptions) . "</li>";
            echo "<li>" . radioDisplay($radio) . "</li>";

            echo "</ul></div>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
</body>
</html>
