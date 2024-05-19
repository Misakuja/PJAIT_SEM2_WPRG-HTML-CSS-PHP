<?php
$backgroundColour = $_COOKIE['backgroundColour'] ?? 'white';
$textColour = $_COOKIE['textColour'] ?? 'black';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Text & Background Cookie Saving Showcase Site</title>
    <link href="LAB10_Ex02.css" rel="stylesheet" type="text/css">
    <style>
        body {
            background-color: <?php echo $backgroundColour; ?>;
            color: <?php echo $textColour; ?>;
        }
    </style>
</head>
<body>
<div class="container">
<div class="textLorem">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel nibh ut eros lobortis scelerisque. Orci varius
    natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed viverra sodales nibh, eget luctus
    nibh malesuada in. Nunc nibh tortor, pharetra a porttitor eu, pulvinar et augue. Aliquam dignissim cursus nunc, nec
    tempor tellus imperdiet eu. Etiam lobortis euismod eleifend. Mauris vestibulum sem odio. Ut pulvinar dictum risus,
    quis semper neque imperdiet vel. Proin risus turpis, suscipit ut volutpat in, ultrices non sapien. Vivamus dignissim
    nec lectus vel maximus. Proin lacinia magna vitae arcu commodo elementum. Integer sed tellus eu orci faucibus
    consectetur ut ut sapien. Proin accumsan eu orci id dignissim. Nam nec pretium urna. Integer in ligula feugiat,
    semper urna nec, dignissim elit. Sed iaculis lectus a erat mollis cursus.</p>
</div>
<div class="formBox3">
<form action="LAB10_Ex02-1.html">
    <fieldset>
        <button type="submit" name="change">Change current settings</button>
    </fieldset>
</form>
</div>
</div>
</body>
</html>
