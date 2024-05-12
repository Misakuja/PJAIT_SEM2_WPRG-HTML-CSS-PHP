<?php
$height = readline("Enter the cylinder height: ");
$radius = readline("Enter the cylinder radius: ");

$volume = pi() * pow($radius, 2) * $height;

echo "Cylinder's volume equals to $volume";