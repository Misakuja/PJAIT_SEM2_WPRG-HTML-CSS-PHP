<?php
session_start();
//Logout
if (isset($_POST['logout'])) {
    unset($_SESSION['logged_in']);
    session_destroy();
}
function displayCart() : void {
    if (!empty($_SESSION['cart'])) {
        echo "<h2>Cart Contents:</h2>";
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            echo "Product ID: $product_id, Quantity: $quantity <br>";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page - Simple shop site</title>
    <link href="LAB10_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="LAB10_Ex04-1.php">
                    <button type="submit">Main Page</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="LAB10_Ex04-2.php">
                        <button type="submit">Register & Login</button>
                    </form>
                </div>
                <div class="menu-item 2 logout">
                    <?php if (isset($_SESSION['logged_in'])) : ?>
                        <form method='post' action="">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    <?php endif ?>
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
    <div class="cart-container">
        <?php
        if(!isset($_SESSION['logged_in'])) echo "<h2>Log in before viewing the cart</h2>";
        if (empty($_SESSION['cart']) && isset($_SESSION['logged_in'])) echo "<h2> Your cart is empty.</h2>";
        ?>
        <?php if (isset($_SESSION['logged_in'])) displayCart(); ?>
        <?php if (!empty($_SESSION['cart']) && isset($_SESSION['logged_in'])) : ?>
        <form action="" method="post">
            <button type="submit" name="checkout">Checkout</button>
        </form>
        <?php endif ?>
    </div>
</div>
</body>
</html>