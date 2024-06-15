<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require 'bankLogic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple shop site</title>
    <link href="LAB13_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="cartPage.php">
                    <button type="submit">Cart</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="mainPage.php">
                        <button type="submit">Main Page</button>
                    </form>
                </div>
                <div class="menu-item 2">
                    <form action="registerLogin.php">
                        <button type="submit">Register & Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="image-text-container">
        <header class="middle-text">
            <h1>
                <strong>Simple Shop</strong>
                Dolorem ex vel similique ut consectetur quidem tempore?
            </h1>
        </header>
        <div class="header-background"><img src="https://i.imgur.com/08SHq9K.png" alt="header-background"></div>
    </div>

    <?php if (isset($_SESSION['user_id'])) : ?>
        <p id='moneyAmount'><b>Money amount: </b><?= $_SESSION['user_money'] ?></p>
        <div class="formsPage">
            <form method='post' action="">
                <fieldset>
                    <legend>Add money</legend>
                    <label for="bankAmount">Amount:</label>
                    <input type="number" id="bankAmount" name="bankAmount" required>
                    <button type="submit" name="bankAmountAdd">Add</button>
                </fieldset>
            </form>
        </div>
    <?php endif ?>
</div>
</body>
</html>