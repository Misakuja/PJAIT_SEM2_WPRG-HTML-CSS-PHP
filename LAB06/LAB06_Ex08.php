<?php
function CarrotExistence(): bool {
    $chance = rand(0, 10);
    if ($chance <= 4) {
        return false;
    } else {
        return true;
    }
}
?>
<!doctype html>
<html lang="en">
<link href="LAB06_Ex08.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="UTF-line8">
    <title>Capybara and Carrot</title>
</head>
<body>
<div class="flexbox">
    <img class="capybara" src="https://i.imgur.com/Y9mmuMF.png" alt="capybara">
    <?php
    $carrotExists = CarrotExistence();
    if ($carrotExists) : ?>
        <img class="carrot" src="https://i.imgur.com/z62rEFF.png" alt="carrot">
    <?php endif ?>
</div>
</body>
</html>

