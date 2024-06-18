<?php
require_once 'PageFunctionality.php';
$pageFunctionality = new PageFunctionality();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["registerUser"])) $pageFunctionality->registerUser();
    if (isset($_POST["loginUser"])) $pageFunctionality->loginUser();
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
    if (isset($_POST["resetPasswordUser"])) $pageFunctionality->resetPasswordUser();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZOO Register & Login</title>
    <link href="project.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Side Navigation -->
<div class="side-nav-container" id="sideNav">
    <a href="javascript:void(0)" class="closeButton" onclick="closeSideNav()">&times;</a>
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
        <a href="6-RegisterLoginPage.php"> Register & Login</a>
    </header>
</div>

    <?php if (isset($_SESSION['notification'])) : ?>
        <p id="notifications"><?= $_SESSION['notification']; ?> </p>
    <?php endif ?>

<div class="forms-page">
    <div id="register-login-forms">
    <!--REGISTER-->
    <form method='post' action="">
        <fieldset>
            <legend>Register</legend>
            <label for="registerFirstName">First Name:</label>
            <input type="text" id="registerFirstName" name="registerFirstName" required>
            <label for="registerLastName">Last Name:</label>
            <input type="text" id="registerLastName" name="registerLastName" required>
            <label for="registerPassword">Password:</label>
            <input type="password" id="registerPassword" name="registerPassword" required>
            <label for="registerEmail">Email:</label>
            <input type="email" id="registerEmail" name="registerEmail" required>
            <button type="submit" name="registerUser">Register</button>
        </fieldset>
    </form>
    <!--LOGIN-->
    <form method='post' action="">
        <fieldset>
            <legend>Login</legend>
            <label for="loginEmail">Email:</label>
            <input type="email" id="loginEmail" name="loginEmail" required>
            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="loginPassword" required>
            <button type="submit" name="loginUser">Login</button>
        </fieldset>
    </form>
</div>
    <!--RESET-->
    <?php if (isset($_SESSION['user_id'])) : ?>
    <form method='post' action="">
        <fieldset>
            <legend>Reset Password</legend>
            <label for="resetEmail">Email:</label>
            <input type="email" id="resetEmail" name="resetEmail" required>
            <label for="resetPassword">New Password:</label>
            <input type="password" id="resetPassword" name="resetPassword" required>
            <button type="submit" name="resetPasswordUser">Reset Password</button>
        </fieldset>
    </form>
</div>
<?php endif ?>

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