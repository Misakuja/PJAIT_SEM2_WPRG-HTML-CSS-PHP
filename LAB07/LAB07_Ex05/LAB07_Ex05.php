<?php
function Addition($addend1, $addend2): float {
    return $addend1 + $addend2;
}

function Subtraction($minuend, $subtrahend): float {
    return $minuend - $subtrahend;
}

function Multiplication($multiplier, $multiplicand): float
{
    return $multiplier * $multiplicand;
}

function Division($dividend, $divisor): float {
    if ($divisor == 0) throw new Exception('ERROR - Division by zero.');
    return $dividend / $divisor;
}

function Cosine($input): float {
    return cos($input);
}

function Sine($input): float {
    return sin($input);
}

function Tangent($input): float {
    return tan($input);
}

function BinToDec($input): string {
    if (!preg_match('/^[01]+$/', $input)) throw new Exception('Invalid binary input');
    return bindec($input);
}

function DecToBin($input): string {
    if (!is_numeric($input)) throw new Exception('Invalid decimal input');
    return decbin($input);
}

function DecToHex($input): string {
    if (!is_numeric($input)) throw new Exception('Invalid decimal input');
    return dechex($input);
}

function HexToDec($input): string {
    if (!preg_match('/^[0-9A-Fa-f]+$/', $input)) throw new Exception('Invalid hexadecimal input');
    return hexdec($input);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculators</title>
    <link href="LAB07_Ex05.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1 id="mainTitle">Calculator</h1>
<div class = calculatorsBackground>
<div class='calculators'>
<div class='form form1'>
    <h2 id="calculatorSimple">Simple</h2>
    <form method='post' action="">
        <fieldset id='Form'>
            <label for='num1'></label>
            <input type='number' id='num1' name='num1' placeholder="Input first number" required>

            <label for='operation'>Operation</label>
            <select id='operation' name='operation' required>
                <option value="Addition">Addition</option>
                <option value="Subtraction">Subtraction</option>
                <option value="Multiplication">Multiplication</option>
                <option value="Division">Division</option>
            </select>

            <label for='num2'></label>
            <input type='number' id='num2' name='num2' placeholder="Input second number" required>

            <button type='submit'>Calculate</button>
        </fieldset>
    </form>
</div>
<div class='form form2'>
    <form method='post' action="">
        <h2 id="calculatorAdvanced">Advanced</h2>
        <fieldset id='Form'>
            <label for='num3'></label>
            <input type='text' id='num3' name='num3' placeholder="Input number" required>

            <label for='operation2'>Operation</label>
            <select id='operation2' name='operation2' required>
                <option value="Cosine">Cosine</option>
                <option value="Sine">Sine</option>
                <option value="Tangent">Tangent</option>
                <option value="BinToDec">Bin To Dec</option>
                <option value="DecToBin">Dec To Bin</option>
                <option value="DecToHex">Dec To Hex</option>
                <option value="HexToDec">Hex To Dec</option>
            </select>
            <button type='submit'>Calculate</button>
        </fieldset>
    </form>
</div>
</div>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<div class='resultBox'>";
    try {
        if (isset($_POST["num1"]) && isset($_POST["num2"]) && isset($_POST["operation"])) {
            $num1 = $_POST["num1"];
            $num2 = $_POST["num2"];
            $operation = $_POST["operation"];

            $result = 0;

            switch ($operation) {
                case "Addition":
                    $result = Addition($num1, $num2);
                    break;
                case "Subtraction":
                    $result = Subtraction($num1, $num2);
                    break;
                case "Multiplication":
                    $result = Multiplication($num1, $num2);
                    break;
                case "Division":
                    $result = Division($num1, $num2);
                    break;
            }
            echo "<div class='result'>The result is: " . $result . "</div>";
        }
        if (isset($_POST["num3"]) && isset($_POST["operation2"])) {
            $num3 = $_POST["num3"];
            $operation2 = $_POST["operation2"];

            $result = 0;

            switch ($operation2) {
                case "Cosine":
                    $result = Cosine($num3);
                    break;
                case "Sine":
                    $result = Sine($num3);
                    break;
                case "Tangent":
                    $result = Tangent($num3);
                    break;
                case "BinToDec":
                    $result = BinToDec($num3);
                    break;
                case "DecToBin":
                    $result = DecToBin($num3);
                    break;
                case "DecToHex":
                    $result = DecToHex($num3);
                    break;
                case "HexToDec":
                    $result = HexToDec($num3);
                    break;
            }
            echo "<div class='result'>The result is: " . $result . "</div>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "</div>";
}
?>
</body>
</html>
