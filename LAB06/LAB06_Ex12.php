<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change based on clock</title>
    <link href="LAB06_Ex12.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
function getColor($minute, $color) {
    $roundMinute = ceil($minute / 10) * 10;
    return $color[$roundMinute];
}
$minute = date("i");
$color = array(
    0 => "#5b9c9e",
    10 => "#35324b",
    20 => "#584769",
    30 => "#93070d",
    40 => "#f062a1",
    50 => "#8e8c8c",
    60 => "#278b61",
);
$chosenColor = getColor($minute, $color)
?>
<div class="shape" style="background-color: <?php echo $chosenColor;?>;">hi :3</div>
</body>
</html>