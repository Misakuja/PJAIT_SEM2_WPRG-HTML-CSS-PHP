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

<!--Species Page button-->
<form id="species-button-form" action=".php">
    <button type="submit">Check out all our species at the zoo!</button>
</form>
<script src="mainPage.js"></script>
</body>
</html>
