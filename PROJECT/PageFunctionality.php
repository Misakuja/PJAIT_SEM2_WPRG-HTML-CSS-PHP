<?php
require_once 'PageInterface.php';
require_once 'databases.php';
session_start();

global $pdo;

class PageFunctionality implements PageInterface {

    public function sendMailContactForm(): void {
        $name = $_POST['contactFormName'];
        $mail = $_POST['contactFormMail'];
        $phone = $_POST['contactFormPhone'];
        $message = $_POST['contactFormMessage'];

        $headers = "From: $name <$mail>\r\n <$phone>\r\n";

        $message = wordwrap($message, 70);

        mail('contact@zoo.com', 'Contact Form Message', $message, $headers);
    }

    public function registerUser(): void {
        global $pdo;
        $firstName = $_POST["registerFirstName"];
        $lastName = $_POST["registerLastName"];
        $email = $_POST["registerEmail"];
        $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM users WHERE user_email = '$email'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $_SESSION['notification'] = "Email already registered";
        } else {
            $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password) VALUES ('$firstName', '$lastName', '$email', '$password')";
            $pdo->exec($sql);
            $_SESSION['notification'] = "Registered successfully";
        }
    }

    public function loginUser(): void {
        global $pdo;
        $loginEmail = $_POST["loginEmail"];
        $loginPassword = $_POST["loginPassword"];

        $user = $pdo->query("SELECT * FROM users WHERE user_email = '$loginEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($loginPassword, $user['user_password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_first_name'] = $user['user_first_name'];
            $_SESSION['user_last_name'] = $user['user_last_name'];
            $_SESSION['user_email'] = $user['user_email'];

            $_SESSION['notification'] = "Logged in successfully as " . $user['user_first_name'] . " " . $user['user_last_name'];
        } else {
            $_SESSION['notification'] = "Invalid Email or Password";
        }
    }

    public function resetPasswordUser(): void {
        global $pdo;
        $resetEmail = $_POST["resetEmail"];
        $resetPassword = password_hash($_POST["resetPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM users WHERE user_email = '$resetEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $sql = "UPDATE users SET user_password = '$resetPassword' WHERE user_email = '$resetEmail'";
            $pdo->exec($sql);

            $_SESSION['notification'] = "Password reset successfully.";
        } else {
            $_SESSION['notification'] = "Password reset failed.";
        }
    }

    public function logoutUser(): void {
        session_destroy();
    }

    public function loginZookeeper(): void {
        global $pdo;
        $loginZookeeperEmail = $_POST["loginZookeeperEmail"];
        $loginPasswordZookeeper = $_POST["loginZookeeperPassword"];

        $zookeeper = $pdo->query("SELECT * FROM zookeepers WHERE zookeeper_email = '$loginZookeeperEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($zookeeper && password_verify($loginPasswordZookeeper, $zookeeper['user_password'])) {
            $_SESSION['zookeeper_id'] = $zookeeper['zookeeper_id'];

            $_SESSION['notification2'] = "Logged in successfully as " . $zookeeper['zookeeper_first_name'] . " " . $zookeeper['zookeeper_last_name'];
        } else {
            $_SESSION['notification2'] = "Invalid Email or Password.";
        }
    }

    public function resetPasswordZookeeper(): void {
        global $pdo;
        $resetZookeeperEmail = $_POST["resetEmailZookeeper"];
        $resetZookeeperPassword = password_hash($_POST["resetZookeeperPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM zookeepers WHERE zookeepers_email = '$resetZookeeperEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $sql = "UPDATE zookeepers SET zookeeper_password = '$resetZookeeperEmail' WHERE zookeeper_email = '$resetZookeeperPassword'";
            $pdo->exec($sql);

            $_SESSION['notification'] = "Password reset successfully.";
        } else {
            $_SESSION['notification'] = "Password reset failed.";
        }
    }

    public function displayCart(): void {
        if (!empty($_SESSION['cart'])) {
            echo "<h2>Cart Contents:</h2>";
            echo "
            <table>
            <thead>
                <tr>
                    <th>TYPE OF TICKET</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>TOTAL VALUE</th>
                </tr>
            </thead>";
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                if ($product_id === "Normal") {
                    $ticketPrice = 10;
                } else $ticketPrice = 5;

                $ticketValue = $this->calculatePrice($product_id, $ticketPrice);
                echo "
                <tbody>
                <tr>
                    <td>$product_id Ticket</td>
                    <td>$ticketPrice$</td>
                    <td>$quantity</td>
                    <td>$ticketValue$</td>
                </tr>";
            }
            echo "</tbody></table>";

            $totalPrice = $this->calculateTotalValue();
            echo "Total Price:" . $totalPrice;
        } else {
            echo "<h2 class='information-cart'>Your cart is empty.</h2>";
        }
    }

    public function calculatePrice($product_id, $ticketPrice): int|float {
        return $ticketPrice * $_SESSION['cart'][$product_id];
    }

    public function calculateTotalValue(): int|float {
        $totalPrice = null;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            if ($product_id === "Normal") {
                $ticketPrice = 10;
            } else $ticketPrice = 5;

            $totalPrice = $totalPrice + $this->calculatePrice($product_id, $ticketPrice);
        }
        return $totalPrice;
    }

    public function addToCart($product_id): void {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += 1;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }

    public function removeFromCart($product_id): void {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] -= 1;

            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }

    public function clearCart(): void {
        unset($_SESSION['cart']);
    }

    public function checkoutCart(): void {
        global $pdo;

        $totalPrice = $this->calculateTotalValue();

        $adultAmount = $_SESSION['cart']["Normal"] ?? 0;
        $reducedAmount = $_SESSION['cart']["Reduced"] ?? 0;
        $firstName = $pdo->quote($_SESSION['user_first_name']);
        $lastName = $pdo->quote($_SESSION['user_last_name']);
        $userId = $pdo->quote($_SESSION['user_id']);

        $sql = "INSERT INTO ticketorders (user_id, buyer_first_name, buyer_last_name, order_price, normal_tickets_amount, reduced_tickets_amount) VALUES ($userId, $firstName, $lastName, $totalPrice, $adultAmount, $reducedAmount)";
        $pdo->exec($sql);

        $this->sendConfirmationMailCheckout();

        unset($_SESSION['cart']);
    }

    public function sendConfirmationMailCheckout(): void {
        $email = $_SESSION['user_email'];
        $subject = 'Ticket Confirmation';
        $totalValue = $this->calculateTotalValue() . "$". PHP_EOL;
        $adultAmount = $_SESSION['cart']["Normal"] ?? 0;
        $reducedAmount = $_SESSION['cart']["Reduced"] ?? 0;

        $message = 'Name: ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . PHP_EOL;
        $message .= 'Total Price: ' . $totalValue . PHP_EOL;
        $message .= 'Normal Tickets: '. $adultAmount . PHP_EOL;
        $message .= 'Reduced Tickets: '. $reducedAmount . PHP_EOL;

        $headers = 'From no-reply@zoo.com';

        mail($email, $subject, $message, $headers);
    }
}
