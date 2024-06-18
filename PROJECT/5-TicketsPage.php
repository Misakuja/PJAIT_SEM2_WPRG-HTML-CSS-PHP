<?php
require_once 'PageFunctionality.php';
$pageFunctionality = new PageFunctionality();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
    if (isset($_POST["addOne"])) $pageFunctionality->addToCart($_POST['product_id']);
    if (isset($_POST["subtractOne"])) $pageFunctionality->removeFromCart($_POST['product_id']);
    if (isset($_POST["clearCart"])) $pageFunctionality->clearCart();
    if (isset($_POST["checkoutCart"])) $pageFunctionality->checkoutCart();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZOO Tickets</title>
    <link href="project.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Side Navigation -->
<div class="side-nav-container" id="sideNav">
    <a href="javascript:void(0)" class="closeButton" onclick="closeSideNav()">&#215;</a>
    <a href="1-mainPage.php">Main Page</a>
    <a href="6-RegisterLoginPage.php">Register & Login</a>
    <a href="7-RegisterLoginZookeeperPage.php">Employees only</a>
    <a href="8-SpeciesPage.php">Our Animals</a>
    <a href="5-TicketsPage.php">Tickets</a>
    <a href="4-openingHoursPage.php">Opening Hours</a>
    <a href="2-contactUsPage.php">Contact us</a>
    <a href="3-regulationsPage.php">Visiting Regulations</a>
    <!--LOGOUT-->
    <?php if (isset($_SESSION['user_id']) || isset($_SESSION['zookeeper_id'])) : ?>
        <form method='post' action="">
            <button type="submit" name="logoutUser">Logout</button>
        </form>
    <?php endif ?>
</div>

<!-- Top Navigation -->
<div class="top-nav-container">
    <span class="top-nav-item" id="burger-menu" onclick="openSideNav()">&#9776;</span>

    <form class="top-nav-item" id="register-login-button" action="6-RegisterLoginPage.php">
        <button class="top-nav-item" type="submit">Register & Login</button>
    </form>

    <a href="1-mainPage.php" class="top-nav-item" id="logo-top"><img src="https://svgshare.com/i/17GD.svg"
                                                                     alt="logo-svg"></a>
</div>

<!-- Header Image -->
<div class="image-container" id="header-background">
    <header class="middle-text">
        <a href="1-mainPage.php">Main Page </a>
        <a> &#x2192; </a>
        <a href="5-TicketsPage.php"> Tickets</a>
    </header>
</div>

<!-- CART DISPLAY -->
<div class='cart-table-container'>
    <?php
    if (isset($_SESSION['user_id'])) $pageFunctionality->displayCart();
    if (!empty($_SESSION['cart']) && isset($_SESSION['user_id'])) : ?>
    <form action="" method="post" id="cart-actions-container">
        <button type="submit" name="clearCart">Clear Cart</button>
        <button type="submit" name="checkoutCart">Checkout</button>
    </form>
<?php endif ?>
<?php if (!isset($_SESSION['user_id'])) echo "<h2 class='information-cart'>Log in before accessing the tickets page.</h2>";
else { ?>
    <div id="tickets-table-container">
    <div id="tickets-table">
        <table>
            <thead>
            <tr>
                <th>TYPE OF TICKET</th>
                <th>PRICE</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><label>Normal Ticket</label></td>
                <td>10.00$</td>
                <td>
                    <form action="" method="post">
                        <button type="submit" name="subtractOne">-</button>
                        <button type="submit" name="addOne">+</button>
                        <input type="hidden" name="product_id" value="Normal">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Reduced Ticket</label>
                    <p>Reduced admission fee available to:<br>
                        1. children between the ages 3-7, on presenting a document confirming the child’s age,<br>
                        2. school-age youth, on presenting a school ID card,<br>
                        3. students up to age 26, on presenting a student ID card,<br>
                        4. pensioners, recipients of a disability pension and war veterans on presenting an ID card,<br>
                        5. persons with moderate and mild disabilities, on presenting an appropriate document.</p>
                </td>
                <td>5.00$</td>
                <td>
                    <form action="" method="post">
                        <button type="submit" name="subtractOne">-</button>
                        <button type="submit" name="addOne">+</button>
                        <input type="hidden" name="product_id" value="Reduced">
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>

<!-- Bottom Navigation -->
<div class="bottom-nav-container">
    <div class="bottom-nav-item" id="bottom-nav-left">
        <a href="1-mainPage.php" id="logo-bottom"><img src="https://svgshare.com/i/17J8.svg" alt="logo-svg"></a>
        <p>Inspired by ZOO Wrocław & ZOO Gdańsk</p>
    </div>
    <div class="bottom-nav-item" id="bottom-nav-center">
        <p>Safari Trails ZOO</p>
        <p>ul. Targ Drzewny 9/11 83-000, Gdańsk </p>
        <p>+48 690 420 420 &#xa9; 2000 - 2024</p>
    </div>
    <div class="bottom-nav-item" id="bottom-nav-right">
        <a href="2-contactUsPage.php">Contact us</a>
        <a href="3-regulationsPage.php">Visiting Regulations</a>
    </div>
</div>

<script src="1-mainPage.js"></script>
</body>
</html>