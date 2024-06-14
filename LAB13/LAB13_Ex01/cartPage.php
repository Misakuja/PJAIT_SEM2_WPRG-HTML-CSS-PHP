<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once 'databases.php';
global $pdo;

function displayCart() : void {
    $_SESSION['totalPrice'] = 0;
    if (!empty($_SESSION['cart'])) {
        echo "<h2>Cart Contents:</h2>";
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $price = getProductPrice($product_id);
            echo "Product ID: $product_id, Quantity: $quantity, Individual Price: $price$<br>";
            $_SESSION['totalPrice'] += $price * $quantity;
            echo '<form action="" method="post">
                    <button type="submit" name="deleteItem">Delete Item ' . $product_id . '</button>
                    <input type="hidden" name="deleteProduct_id" value="' . $product_id . '">
                  </form>';
        }
        echo "Total sum: " . $_SESSION['totalPrice'] . "$";
    }
}
function getProductPrice($product_id) {
    return match ($product_id) {
        1 => 20,
        2 => 40,
        3 => 60,
        4 => 80,
        5 => 100,
        6 => 150,
        7 => 200,
        8 => 250,
        9 => 300,
        10 => 350,
        11 => 400,
        default => 0,
    };
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clearCart'])) {
        unset($_SESSION['cart']);
        $sql = "DELETE FROM Cart WHERE User_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
    }

    if (isset($_POST['deleteItem'])) {
        $deleteProduct_id = $_POST['deleteProduct_id'];
        if (isset($_SESSION['cart'][$deleteProduct_id])) {
            unset($_SESSION['cart'][$deleteProduct_id]);
            $sql = "DELETE FROM Cart WHERE User_id = :user_id AND Product_id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $_SESSION['user_id'], 'product_id' => $deleteProduct_id]);
        }
    }

    if (isset($_POST['checkout'])) {
        if ($_SESSION['user_money'] < $_SESSION['totalPrice']) {
            $notif = "Insufficient amount of money in bank.";
        } else {
            unset($_SESSION['cart']);
            $newMoneyAmount = $_SESSION['user_money'] - $_SESSION['totalPrice'];
            $sql = "UPDATE Registered SET User_money = :new_money WHERE User_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['new_money' => $newMoneyAmount, 'user_id' => $_SESSION['user_id']]);
            $_SESSION['user_money'] = $newMoneyAmount;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page - Simple shop site</title>
    <link href="LAB13_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="mainPage.php">
                    <button type="submit">Main Page</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="registerLogin.php">
                        <button type="submit">Register & Login</button>
                    </form>
                </div>
                <div class="menu-item 2 bank">
                    <form action="bankPage.php">
                        <button type="submit">Bank</button>
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

    <div class="cart-container">
        <?php
        if (!isset($_SESSION['user_id'])) echo "<h2>Log in before viewing the cart</h2>";
        if (empty($_SESSION['cart']) && isset($_SESSION['user_id'])) echo "<h2> Your cart is empty.</h2>";
        ?>
        <?php if (isset($_SESSION['user_id'])) displayCart(); ?>
        <?php if (!empty($_SESSION['cart']) && isset($_SESSION['user_id'])) : ?>
            <form action="" method="post">
                <button type="submit" name="clearCart">Clear Cart</button>
                <button type="submit" name="checkout">Checkout</button>
            </form>
        <?php endif ?>
    </div>
</div>
</body>
</html>