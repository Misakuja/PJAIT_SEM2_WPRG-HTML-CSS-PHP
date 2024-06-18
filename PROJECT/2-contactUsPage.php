<?php
require_once 'PageFunctionality.php';

$pageFunctionality = new PageFunctionality();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['contactForm'])) $pageFunctionality->sendMailContactForm();
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZOO Contact Page</title>
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
        <a href="2-contactUsPage.php"> Contact Us</a>
    </header>
</div>

<div class="contactInfo-container">
    <div class="contactInfo-phone">
        <img src="https://svgshare.com/i/17JW.svg" alt="phone-svg">
        <h3>Phone</h3>
        <p>+48 690 420 420</p>
    </div>
    <div class="contactInfo-mail">
        <img src="https://svgshare.com/i/17GE.svg" alt="mail-svg">
        <h3>Mail</h3>
        <p>contact@zoo.com</p>
    </div>
</div>

<form class="contactForm" method="POST" action="2-contactUsPage.php">
    <header id="contactForm-header">
        <h3>Contact Form</h3>
        <img src="https://svgshare.com/i/17Gz.svg" alt="write-svg">
    </header>

    <label for="contactFormName">Your Name:</label>
    <input type="text" id="contactFormName" name="contactFormName" required>

    <label for="contactFormMail">Email:</label>
    <input type="email" id="contactFormMail" placeholder="example@mail.com" name="contactFormMail" required>

    <label for="contactFormPhone">Phone:</label>
    <input type="tel" pattern="+[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="+48 123 456 789" id="contactFormPhone"
           name="contactFormPhone" required>

    <label for="contactFormMessage">Message:</label>
    <textarea id="contactFormMessage" name="contactFormMessage" required></textarea>

    <button type="submit" name="contactForm">Send</button>
</form>

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