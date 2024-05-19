<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Randomizer</title>
    <link href="LAB06_Ex09.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$usedImages = [];
    for ($i = 1; $i <= 3; $i++) {
        do {
            $newImg = rand(1,9);
        } while(in_array($newImg, $usedImages));

        $usedImages[] = $newImg;
?>
<div id="flexbox">
            <?php
        switch ($newImg) {
            case 1: {
                echo "<img class='cat cat1' src='https://i.imgur.com/Q9vwbdq.png' alt='cat1'>";
                break;
            }
            case 2: {
                echo "<img class='cat cat2' src='https://i.imgur.com/E7uGK7a.png' alt='cat2''>";
                break;
            }
            case 3: {
                echo "<img class='cat cat3' src='https://i.imgur.com/q8qlv95.png' alt='cat3'>";
                break;
            }
            case 4: {
                echo "<img class='cat cat4' src='https://i.imgur.com/WUyR47D.png' alt='cat4'>";
                break;
            }
            case 5: {
                echo "<img class='cat notCat5' src='https://i.imgur.com/sdqvrvK.png' alt='impostor'>";
                break;
            }
            case 6: {
                echo "<img  class='cat cat6' src='https://i.imgur.com/Qp1Xotp.png' alt='cat6'>";
                break;
            }
            case 7: {
                echo "<img class='cat cat7' src='https://i.imgur.com/9WCUmbr.png' alt='cat7'>";
                break;
            }
            case 8: {
                echo "<img class='cat cat8' src='https://i.imgur.com/0gV7KSA.png' alt='cat8'>";
                break;
            }
            case 9: {
                echo "<img class='cat cat9' src='https://i.imgur.com/hFQLgXN.png' alt='cat9'>";
                break;
            }
        }
    }
    ?>
</body>
</html>