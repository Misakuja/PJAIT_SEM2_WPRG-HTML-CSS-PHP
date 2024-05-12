<?php

function letterAmount($input) : bool {
if (strlen($input) >= 8)  return true;
else return false;
}
function numbersLetters($input) : bool {
    if (ctype_alnum($input)) {
        return true;
    } else return false;
}
function twoNumbers($input) : bool {
    $amountOfNumbers = 0;
    for ($i = 0; $i < strlen($input); $i++) {
        $char = $input[$i];
        if (is_numeric($char)) {
            $amountOfNumbers++;
        }
    }
    if ($amountOfNumbers >= 2) {
        return true;
    } else return false;
}
$input = readline("Input the password to check.");

if (letterAmount($input) && numbersLetters($input) && twoNumbers($input)) {
    echo "The password is secure!";
} else echo "The password is weak.";
