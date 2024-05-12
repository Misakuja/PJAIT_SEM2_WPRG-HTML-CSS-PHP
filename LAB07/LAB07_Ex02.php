<?php
function toHex($oct): string {
    $dec = octdec($oct);

    return dechex($dec);
}
echo "How many values should the array have?";
$arrLength = fgets(STDIN);

$inputArray = array();

echo "Provide octal values for the array: ";
for($i = 0; $i < $arrLength; $i++) {
    $inputArray[$i] = fgets(STDIN);
}

foreach ($inputArray as $oct) {
    echo "Octal: " . $oct . " => Hexadecimal: " . toHex($oct) . "\n";
}