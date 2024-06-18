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
    <title>ZOO Main Page</title>
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
<div class="image-container" id="header-background"></div>

<!--Buttons Grid/Flex/Whatever-->
<div class="button-banners-flexContainer">
    <div class="button-banners-gridContainer">
        <!--Species Page-->
        <form id="species-button-form" action="8-SpeciesPage.php">
            <button type="submit">Check out all our species at the zoo!</button>
        </form>

        <!--Tickets & Opening Hours-->
        <form id="tickets-button-form" action="5-TicketsPage.php">
            <button type="submit" id="tickets-opening-button">Tickets</button>
        </form>
        <form id="opening-button-form" action="4-openingHoursPage.php">
            <button type="submit" id="pricing-opening-button">Opening Hours</button>
        </form>
    </div>
</div>

<!--Restaurant Banner-->
<div class="restaurant-container">
    <header class="middle-text">
        <h1>
            <strong>Safari Stop</strong>
            Coming Soon~
        </h1>
    </header>
    <div class="restaurant-background"><img src="https://i.imgur.com/i7l5cQx.jpeg" alt="restaurant-background"></div>
</div>

<!--Zoo in Numbers + Info Banner-->
<div class="info-container">
    <div id="top-info">
        <h1>Welcome!</h1>
        <p>We're delighted to have you here, a unique sanctuary sprawling across approximately 69
            hectares, housing animals from every corner of the globe. Our zoo offers a diverse and enriching experience,
            providing a safe haven for species from various continents.
        </p>
        <p>
            While you explore our fascinating animal exhibits, don't forget to visit Safari Stop, our charming zoo
            restaurant. It's the perfect spot to unwind and refuel after your wildlife adventures. Whether you're
            craving a
            quick snack or a leisurely meal, Safari Stop promises a delightful dining experience amidst the zoo's
            natural
            beauty.
        </p>
        <p>
            Come discover the wonders of the animal kingdom and indulge in delicious treats at Safari Stop – your
            gateway to
            both wildlife and culinary delights at the ZOO!
        </p>
    </div>
    <div id="bottom-info">
        <h1>Our ZOO in numbers</h1>
        <div class="circles">
            <div class="numbers-circle">
                <h2>2000</h2>
                <p>year of foundation</p>
            </div>
            <div class="numbers-circle">
                <h2>69 ha</h2>
                <p>total area</p>
            </div>

            <div class="numbers-circle">
                <h2><?= $pageFunctionality->getNumberOfSpecies(); ?></h2>
                <p>total species</p>
            </div>
            <div class="numbers-circle">
                <h2><?= $pageFunctionality->getNumberOfSpecimens(); ?></h2>
                <p>total specimens</p>
            </div>
        </div>
    </div>
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
