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
    <title>ZOO Visiting Regulations Page</title>
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
        <a href="3-regulationsPage.php"> Regulations</a>
    </header>
</div>

<!--Regulations-->
<div class="regulations">
    <h2>VISITING REGULATIONS</h2>
    <h4>Respect for Animals:</h4>
    <p>Visitors must refrain from feeding, teasing, or disturbing the animals in any way. This includes not tapping on glass enclosures or making loud noises that could stress the animals.</p>

    <h4>Stay on Designated Paths:</h4>
    <p>For both safety and conservation reasons, visitors must stay on marked pathways at all times. Venturing into restricted areas or climbing fences is strictly prohibited.</p>

    <h4>No Outside Pets:</h4>
    <p>To prevent stress to our animals and ensure the safety of all visitors, outside pets are not allowed within the zoo premises.</p>

    <h4>Proper Attire:</h4>
    <p>Appropriate clothing and footwear must be worn at all times. Bare feet, swimwear, and excessively revealing clothing are not permitted.</p>

    <h4>Trash Disposal:</h4>
    <p>Help keep our zoo clean by using designated trash bins for litter and waste disposal. Recycling bins are also available for recyclable items.</p>

    <h4>No Smoking or Vaping:</h4>
    <p>Smoking, vaping, or any open flames are not allowed within the zoo grounds, including all indoor and outdoor areas.</p>

    <h4>Photography Guidelines:</h4>
    <p>Photography is allowed for personal use only. Flash photography and the use of drones are prohibited without prior permission from zoo management.</p>

    <h4>Behavioral Standards:</h4>
    <p>Visitors are expected to conduct themselves respectfully towards fellow guests, staff, and animals. Disorderly conduct, including the use of offensive language or disruptive behavior, will result in removal from the premises.</p>

    <h4>Children's Supervision:</h4>
    <p>Children must be supervised by an adult at all times. Running, shouting, or any behavior that could disturb the animals or other visitors should be avoided.</p>

    <h4>Accessibility:</h4>
    <p>The zoo strives to be accessible to all visitors. Please respect designated areas for disabled parking, ramps, and facilities.</p>

    <h4>Emergency Procedures:</h4>
    <p>In the event of an emergency or if you notice any unusual behavior from animals or visitors, please alert zoo staff immediately.</p>

    <h4>COVID-19 Safety:</h4>
    <p>During periods of health concerns, such as pandemics, visitors must adhere to additional health and safety guidelines issued by the zoo, including mask-wearing and social distancing measures.</p>
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