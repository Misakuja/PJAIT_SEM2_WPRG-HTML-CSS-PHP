<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once 'databases.php';
global $pdo;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    $isInTable = $pdo->query("SELECT * FROM Cart WHERE User_id = '{$_SESSION['user_id']}' AND Product_id = '$productId'")->fetchAll(PDO::FETCH_ASSOC);
    if($isInTable) {
        $sql = "UPDATE Cart SET Quantity = '{$_SESSION['cart'][$productId]}' WHERE User_id = '{$_SESSION['user_id']}' AND Product_id = '$productId'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO Cart (Product_id, Quantity, User_id) VALUES ('$productId', '{$_SESSION['cart'][$productId]}', '{$_SESSION['user_id']}')";
        $pdo->query($sql);
    }
}
?>
