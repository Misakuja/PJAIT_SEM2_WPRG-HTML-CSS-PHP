<?php
require_once 'PageFunctionality.php';
$pageFunctionality = new PageFunctionality();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZOO Opening Hours</title>
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

    <a href="1-mainPage.php" class="top-nav-item" id="logo-top"><img src="https://svgshare.com/i/17GD.svg" alt="logo-svg"></a>
</div>

<!-- Header Image -->
<div class="image-container" id="header-background">
    <header class="middle-text">
        <a href="1-mainPage.php">Main Page </a>
        <a> &#x2192; </a>
        <a href="4-openingHoursPage.php"> Opening Hours</a>
    </header>
</div>

<!-- Opening Hours Table -->
<div id="opening-hours-table">
    <h2>OPENING HOURS</h2>
    <table>
        <thead>
        <tr>
            <th>Month</th>
            <th>Entry Time</th>
            <th>Sightseeing Until</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>January</td>
            <td>9:00 AM</td>
            <td>5:00 PM</td>
        </tr>
        <tr>
            <td>February</td>
            <td>9:00 AM</td>
            <td>5:00 PM</td>
        </tr>
        <tr>
            <td>March</td>
            <td>9:00 AM</td>
            <td>6:00 PM</td>
        </tr>
        <tr>
            <td>April</td>
            <td>9:00 AM</td>
            <td>6:00 PM</td>
        </tr>
        <tr>
            <td>May</td>
            <td>9:00 AM</td>
            <td>6:30 PM</td>
        </tr>
        <tr>
            <td>June</td>
            <td>9:00 AM</td>
            <td>6:30 PM</td>
        </tr>
        <tr>
            <td>July</td>
            <td>9:00 AM</td>
            <td>7:00 PM</td>
        </tr>
        <tr>
            <td>August</td>
            <td>9:00 AM</td>
            <td>7:00 PM</td>
        </tr>
        <tr>
            <td>September</td>
            <td>9:00 AM</td>
            <td>6:30 PM</td>
        </tr>
        <tr>
            <td>October</td>
            <td>9:00 AM</td>
            <td>6:00 PM</td>
        </tr>
        <tr>
            <td>November</td>
            <td>9:00 AM</td>
            <td>5:00 PM</td>
        </tr>
        <tr>
            <td>December</td>
            <td>9:00 AM</td>
            <td>5:00 PM</td>
        </tr>
        </tbody>
    </table>
</div>
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