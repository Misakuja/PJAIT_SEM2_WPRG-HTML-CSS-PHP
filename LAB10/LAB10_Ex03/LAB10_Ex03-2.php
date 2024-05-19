<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $_SESSION['backgroundColour'] = $_POST['backgroundColour'];
    $_SESSION['textColour'] = $_POST['textColour'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Text & Background Cookie Saving Confirmation</title>
    <link href="LAB10_Ex03.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="formBox2">
    <p>Do you confirm your selections?</p>
    <div class="buttonContainer">
        <form action="LAB10_Ex03-1.html">
            <button type="submit" name="undo">Undo</button>
        </form>
        <form action="LAB10_Ex03-3.php">
            <button type="submit" name="confirm">Confirm</button>
        </form>
    </div>
</div>
</body>
</html>