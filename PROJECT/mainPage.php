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

<!--Buttons Grid/Flex/Whatever-->
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
    <h1>Welcome!</h1>
    <p>We're delighted to have you here, a unique sanctuary sprawling across approximately 69
        hectares, housing animals from every corner of the globe. Our zoo offers a diverse and enriching experience,
        providing a safe haven for species from various continents.
    </p>
    <p>
        While you explore our fascinating animal exhibits, don't forget to visit Safari Stop, our charming zoo
        restaurant. It's the perfect spot to unwind and refuel after your wildlife adventures. Whether you're craving a
        quick snack or a leisurely meal, Safari Stop promises a delightful dining experience amidst the zoo's natural
        beauty.
    </p>
    <p>
        Come discover the wonders of the animal kingdom and indulge in delicious treats at Safari Stop – your gateway to
        both wildlife and culinary delights at the ZOO!
    </p>
    <h1>Our ZOO in numbers</h1>
    <div class="box">
        <h1>2000</h1>
        <p>year of foundation</p>
    </div>
    <div class="box">
        <h1>69 ha</h1>
        <p>total area</p>
    </div>
    <div class="box">
        <!--TODO// ECHO SPECIES FROM DATABASES TABLE-->
        <h1>420</h1>
        <p>total species</p>
    </div>
    <div class="box">
        <!--TODO// ECHO SPECIMENS FROM DATABASES TABLE-->
        <h1>2137</h1>
        <p>total specimens</p>
    </div>
</div>
<script src="mainPage.js"></script>
</body>
</html>
