<?php
$input = readline("Enter the input word: ");
$count = 0;
$vowels = ['a','e','i','o','u','y'];

for ($i = 0; $i < strlen($input); $i++) {
    if (in_array($input[$i], $vowels)) {
        $count++;
    }
}
echo "Amount of consonants: $count";