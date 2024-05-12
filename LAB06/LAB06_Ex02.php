<?php
$a = 1;
$b = 2;

echo '<pre>';
echo "a \t b \t pow(a,b) \n";
echo '</pre>';
for ($i = 1; $i <= 10; $i++) {
    echo '<pre>';
    echo $a;
    echo "\t";
    echo $b;
    echo "\t";
    echo pow($a,$b);
    echo "\n";
    echo '</pre>';
    $a++;
    $b++;
}