<?php
require_once 'PageFunctionality.php';
$pageFunctionality = new PageFunctionality();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
    if (isset($_POST["deleteSpecies"])) $pageFunctionality->deleteSpecies();
    if (isset($_POST["addSpecies"])) $pageFunctionality->addSpecies();
    if (isset($_POST["editSpeciesClick"])) $pageFunctionality->editSpecies($_POST["editSpeciesClick"]);
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
        <a href="8-SpeciesPage.php"> Our Species</a>
    </header>
</div>

<!-- Animal Categories Table -->
<?php $pageFunctionality->showAnimalCategoriesTable(); ?>

<!-- ZOOKEEPERS ONLY FORMS (ADD/EDIT) -->
<?php if (isset($_SESSION['zookeeper_id'])) : ?>

    <!-- Add Species - ZOOKEEPERS ONLY -->
    <h2>Add New Species</h2>
    <form method="POST">
        <label for="categoryNameSpeciesAdd">Category Name:</label>
        <select name="categoryNameSpeciesAdd" id="categoryNameSpeciesAdd" required>
            <option value="">Select Category</option>
            <?php $pageFunctionality->getCategories(); ?>
        </select>
        <label for="commonNameSpeciesAdd">Common Name:</label>
        <input type="text" id="commonNameSpeciesAdd" name="commonNameSpeciesAdd" required>

        <label for="scientificNameSpeciesAdd">Scientific Name:</label>
        <input type="text" id="scientificNameSpeciesAdd" name="scientificNameSpeciesAdd" required>

        <label for="conservationStatusSpeciesAdd">Conservation Status:</label>
        <input type="text" id="conservationStatusSpeciesAdd" name="conservationStatusSpeciesAdd">

        <label for="dietSpeciesAdd">Diet:</label>
        <textarea id="dietSpeciesAdd" name="dietSpeciesAdd"></textarea>

        <label for="behaviourSpeciesAdd">Behaviour:</label>
        <textarea id="behaviourSpeciesAdd" name="behaviourSpeciesAdd"></textarea>

        <label for="imageSpeciesAdd">Image URL:</label>
        <input type="url" id="imageSpeciesAdd" name="imageSpeciesAdd">

        <button type="submit" name="addSpecies">Submit</button>
    </form>
    <!-- Edit Species - ZOOKEEPERS ONLY -->
    <?php if (isset($_POST['editSpecies'])) :
        $speciesData = $pageFunctionality->fetchClickedSpecies(); ?>
        <h2>Edit Species: <?= $speciesData['common_name'] ?> </h2>
        <form method="POST">
            <label for="categoryNameSpeciesEdit">Category Name:</label>
            <select name="categoryNameSpeciesEdit" id="categoryNameSpeciesEdit" required>
                <option value="">Select Category</option>
                <?php $pageFunctionality->getCategories(); ?>
            </select>
            <label for="commonNameSpeciesEdit">Common Name:</label>
            <input type="text" id="commonNameSpeciesEdit" name="commonNameSpeciesEdit"
                   value="<?= $speciesData['common_name'] ?>" required>

            <label for="scientificNameSpeciesEdit">Scientific Name:</label>
            <input type="text" id="scientificNameSpeciesEdit" name="scientificNameSpeciesEdit"
                   value="<?= $speciesData['scientific_name'] ?>" required>

            <label for="conservationStatusSpeciesEdit">Conservation Status:</label>
            <input type="text" id="conservationStatusSpeciesEdit" name="conservationStatusSpeciesEdit"
                   value="<?= $speciesData['conservation_status'] ?>">

            <label for="dietSpeciesEdit">Diet:</label>
            <textarea id="dietSpeciesEdit" name="dietSpeciesEdit"><?= $speciesData['diet'] ?></textarea>

            <label for="behaviourSpeciesEdit">Behaviour:</label>
            <textarea id="behaviourSpeciesEdit" name="behaviourSpeciesEdit"><?= $speciesData['behaviour'] ?></textarea>

            <label for="imageSpeciesEdit">Image URL:</label>
            <input type="url" id="imageSpeciesEdit" name="imageSpeciesEdit" value="<?= $speciesData['image'] ?>">

            <button type="submit" name="editSpeciesClick" value="<?= $speciesData['species_id'] ?>">Submit</button>
        </form>
    <?php endif ?>
<?php endif ?>


<!-- List all species -->
<?php $pageFunctionality->listAllSpecies(); ?>

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