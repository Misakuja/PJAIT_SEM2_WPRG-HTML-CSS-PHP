<?php
session_start();
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'MyN3wP4ssw0rd';
$dbname = 'LAB13Ex01';
$pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);
$pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
$pdo->exec("USE $dbname");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bankAmountAdd'])) {
        $valueToAdd = $_POST['bankAmount'];

        $getUser = $pdo->query("SELECT User_money FROM Registered WHERE User_id = '{$_SESSION['user_id']}'")->fetch(PDO::FETCH_ASSOC);
        if ($getUser) {
            $newMoneyAmount = $getUser['User_money'] += $valueToAdd;

            $sql = "UPDATE Registered SET User_money = '$newMoneyAmount' WHERE User_id = '{$_SESSION['user_id']}'";
            $pdo->exec($sql);

            $_SESSION['user_money'] = $newMoneyAmount;
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="LAB13_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="LAB13_Ex04-3.php">
                    <button type="submit">Cart</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="LAB13_Ex04-1.php">
                        <button type="submit">Main Page</button>
                    </form>
                </div>
                <div class="menu-item 2">
                    <form action="LAB13_Ex04-2.php">
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
    <?= "<p id='moneyAmount'><b>Money amount: </b>" . $_SESSION['user_money'] . "</p>" ?>
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
</div>
<?php endif ?>
</body>
</html>