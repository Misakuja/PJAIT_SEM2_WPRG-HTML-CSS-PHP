<?php
require_once 'PageFunctionality.php';
$pageFunctionality = new PageFunctionality();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["loginZookeeper"])) $pageFunctionality->loginZookeeper();
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
    if (isset($_POST["resetZookeeperPassword"])) $pageFunctionality->resetPasswordZookeeper();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZOO Register & Login - Employee Only</title>
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
        <a href="7-RegisterLoginZookeeperPage.php"> Employees Only</a>
    </header>
</div>

<!-- Info Banner-->
<div class="info-container" id="info-employee-only">
    <h1>EMPLOYEE ONLY ZONE</h1>
    <p>Welcome to the Employee Login Portal.</p>
    <p>This page is exclusively for employees to access internal resources and manage their professional
        information.</p>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <p id="user-on-employee-site">It looks like you've landed in a section that's off-limits to you!</p>
    <?php endif ?>
</div>

<?php if (isset($_SESSION['notification2'])) : ?>
    <p id="notifications"><?= $_SESSION['notification2']; ?> </p>
<?php endif ?>

<?php if (!isset($_SESSION['user_id'])) : ?>
<div class="forms-page forms-zookeeper">
    <!--LOGIN-->
    <form method='post' action="">
        <fieldset>
            <legend>Employee Login</legend>
            <label for="loginZookeeperEmail">Email:</label>
            <input type="email" id="loginZookeeperEmail" name="loginZookeeperEmail" required>
            <label for="loginZookeeperPassword">Password:</label>
            <input type="password" id="loginZookeeperPassword" name="loginZookeeperPassword" required>
            <button type="submit" name="loginZookeeper">Login</button>
        </fieldset>
    </form>

    <!--RESET-->
    <?php if (isset($_SESSION['zookeeper_id'])) : ?>
        <form method='post' action="">
            <fieldset>
                <legend>Reset Password</legend>
                <label for="resetZookeeperEmail">Email:</label>
                <input type="email" id="resetZookeeperEmail" name="resetZookeeperEmail" required>
                <label for="resetZookeeperPassword">New Password:</label>
                <input type="password" id="resetZookeeperPassword" name="resetZookeeperPassword" required>
                <button type="submit" name="resetZookeeperPassword">Reset Password</button>
            </fieldset>
        </form>
    <?php endif ?>
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