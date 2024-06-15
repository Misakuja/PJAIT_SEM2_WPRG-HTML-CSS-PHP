<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project</title>
    <link href="project.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Side Navigation -->
<div class="side-nav-container" id="sideNav">
    <a href="javascript:void(0)" class="closeButton" onclick="closeSideNav()">&times;</a>
    <a href="#">Register & Login</a>
    <a href="#">For Workers </a>
    <a href="#">Our Animals</a>
    <a href="#">Tickets</a>
    <a href="#">Pricing</a>
    <a href="#">Opening Hours</a>
    <div id="contact-regulations">
        <a href="#">Contact us</a>
        <a href="#">Visiting Regulations</a>
    </div>
</div>

<!-- Top Navigation -->
<div class="top-nav-container">
    <span class="top-nav-item" id="burger-menu" onclick="openSideNav()">&#9776;</span>

    <form class="top-nav-item" id="tickets-button" action=".php">
        <button class="top-nav-item" type="submit">Tickets</button>
    </form>

    <a href="mainPage.php" class="top-nav-item" id="logo"></a>
</div>

<div class="image-container" id="header-background"></div>

<div class="button-banners-flexContainer">
    <div class="button-banners-gridContainer">
        <!--Species Page-->
        <form id="species-button-form" action=".php">
            <button type="submit">Check out all our species at the zoo!</button>
        </form>

        <!--Pricing & Opening Hours-->
        <form id="pricing-button-form" action=".php">
            <button type="submit" id="pricing-opening-button">Pricing</button>
        </form>
        <form id="opening-button-form" action=".php">
            <button type="submit" id="pricing-opening-button">Opening Hours</button>
        </form>
    </div>
</div>

<script src="mainPage.js"></script>
</body>
</html>
