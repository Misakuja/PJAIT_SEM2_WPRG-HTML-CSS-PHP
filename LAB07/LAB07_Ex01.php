<?php

function spliceArray($inputArray, $position) {
    if ($position < 0 || $position > count($inputArray)) {
        echo "ERROR";
    }
    array_splice($inputArray, $position, 0, '$');

    echo "\n";
    foreach ($inputArray as $arrElement) {
        echo $arrElement . " ";
    }
}
echo "How many values should the array have?";
$arrLength = fgets(STDIN);

$inputArray = array();

echo "Provide values for the array: ";
for($i = 0; $i < $arrLength; $i++) {
    $inputArray[$i] = fgets(STDIN);
}

echo "Choose the position of the splice";
$position = fgets(STDIN);

spliceArray($inputArray, $position);