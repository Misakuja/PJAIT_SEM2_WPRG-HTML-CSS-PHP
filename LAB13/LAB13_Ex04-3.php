    <?php
    session_start();
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'MyN3wP4ssw0rd';
    $dbname = 'LAB13Ex01';
    $notif = null;
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clearCart'])) {
        unset($_SESSION['cart']);
        $sql = "DELETE FROM Cart WHERE User_id = '{$_SESSION['user_id']}'";
        $pdo->exec($sql);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteItem'])) {
        $deleteProduct_id = $_POST['deleteProduct_id'];
        if (isset($_SESSION['cart'][$deleteProduct_id])) {
            unset($_SESSION['cart'][$deleteProduct_id]);
            }
            $sql = "DELETE FROM Cart WHERE User_id = '{$_SESSION['user_id']}' AND Product_id = $deleteProduct_id";
            $pdo->exec($sql);

    }
    function displayCart(): int {
        $_SESSION['totalPrice'] = 0;
        if (!empty($_SESSION['cart'])) {
            echo "<h2>Cart Contents:</h2>";
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                echo "Product ID: $product_id, Quantity: $quantity, Individual Price: ";
                switch ($product_id) {
                    case 1:
                        echo "20$<br>";
                        $price = 20;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 2:
                        echo "40$<br>";
                        $price = 40;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 3:
                        echo "60$<br>";
                        $price = 60;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 4:
                        echo "80$<br>";
                        $price = 80;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 5:
                        echo "100$<br>";
                        $price = 100;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 6:
                        echo "150$<br>";
                        $price = 150;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 7:
                        echo "200$<br>";
                        $price = 200;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 8:
                        echo "250$<br>";
                        $price = 250;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 9:
                        echo "300$<br>";
                        $price = 300;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 10:
                        echo "350$<br>";
                        $price = 350;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                    case 11:
                        echo "400$<br>";
                        $price = 400;
                        $_SESSION['totalPrice'] += $price * $quantity;
                        break;
                }
    echo '<form action="" method="post">
            <button type="submit" name="deleteItem">Delete Item ' . $product_id . '</button>
            <input type="hidden" name="deleteProduct_id" value="' . $product_id . '">
          </form>';

            }
            echo "Total sum: " . $_SESSION['totalPrice'] . "$";
        }
        return $_SESSION['totalPrice'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
        if ($_SESSION['user_money'] < $_SESSION['totalPrice']) {
            $notif = "Insufficient amount of money in bank.";
        } else {
            unset($_SESSION['cart']);
            $newMoneyAmount = $_SESSION['user_money'] - $_SESSION['totalPrice'];

            $sql = "UPDATE Registered SET User_money = '$newMoneyAmount' WHERE User_id = '{$_SESSION['user_id']}'";
            $pdo->exec($sql);

            $_SESSION['user_money'] = $newMoneyAmount;
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login Page - Simple shop site</title>
        <link href="LAB13_Ex04.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <div class="page">
        <div class="top-nav-header">
            <div class="top-nav-container">
                <div class="top-left-menu">
                    <form action="LAB13_Ex04-1.php">
                        <button type="submit">Main Page</button>
                    </form>
                </div>
                <div class="top-right-menu">
                    <div class="menu-item 1">
                        <form action="LAB13_Ex04-2.php">
                            <button type="submit">Register & Login</button>
                        </form>
                    </div>
                    <div class="menu-item 2 bank">
                        <form action="LAB13_Ex04-4.php">
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

        <div class="notif">
            <?php if ($notif) : ?>
                <h1>Notifications:</h1>
                <p><?= $notif ?> </p>
            <?php endif ?>
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