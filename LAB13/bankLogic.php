<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once 'databases.php';
global $pdo;

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
?>