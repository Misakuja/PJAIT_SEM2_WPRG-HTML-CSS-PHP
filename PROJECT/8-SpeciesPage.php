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
    <title>ZOO Species Page</title>
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
        <a href="8-SpeciesPage.php"> Our Species</a>
    </header>
</div>

<!-- Animal Categories Table -->
<?php $pageFunctionality->showAnimalCategoriesTable(); ?>

<?php if (isset($_SESSION['notificationAdd'])) : ?>
    <p id="notifications"><?= $_SESSION['notificationAdd']; ?> </p>
<?php endif ?>

<!-- ZOOKEEPERS ONLY FORMS (ADD/EDIT) -->
<?php if (isset($_SESSION['zookeeper_id'])) : ?>
<div class="edit-add-forms-container">
    <!-- Add Species - ZOOKEEPERS ONLY -->
    <h2>Add New Species</h2>
    <form class="edit-add-forms-zookeeper" id="species-add" method="POST">
        <label for="categoryNameSpeciesAdd">Category Name:
        <select name="categoryNameSpeciesAdd" id="categoryNameSpeciesAdd" required>
            <option value="">Select Category</option>
            <?php $pageFunctionality->getCategories(0); ?>
        </select></label>
        <label for="commonNameSpeciesAdd">Common Name:
        <input type="text" id="commonNameSpeciesAdd" name="commonNameSpeciesAdd" required>
        </label>
        <label for="scientificNameSpeciesAdd">Scientific Name:
        <input type="text" id="scientificNameSpeciesAdd" name="scientificNameSpeciesAdd" required>
        </label>
        <label for="conservationStatusSpeciesAdd">Conservation Status:
        <input type="text" id="conservationStatusSpeciesAdd" name="conservationStatusSpeciesAdd">
        </label>
        <label for="dietSpeciesAdd">Diet:
        <textarea id="dietSpeciesAdd" name="dietSpeciesAdd"></textarea>
        </label>
        <label for="behaviourSpeciesAdd">Behaviour:
        <textarea id="behaviourSpeciesAdd" name="behaviourSpeciesAdd"></textarea>
        </label>
        <label for="imageSpeciesAdd">Image URL:
        <input type="url" id="imageSpeciesAdd" name="imageSpeciesAdd">
        </label>
        <button type="submit" name="addSpecies">Submit</button>
    </form>
    <!-- Edit Species - ZOOKEEPERS ONLY -->
    <?php if (isset($_POST['editSpecies'])) :
        $speciesData = $pageFunctionality->fetchClickedSpecies(); ?>
        <h2>Edit Species: <?= $speciesData['common_name'] ?> </h2>
        <form class="edit-add-forms-zookeeper" id="species-edit" method="POST">
            <label for="categoryNameSpeciesEdit">Category Name:
            <select name="categoryNameSpeciesEdit" id="categoryNameSpeciesEdit" required>
                <option value="">Select Category</option>
                <?php $pageFunctionality->getCategories($speciesData['category_id']); ?>
            </select></label>
            <label for="commonNameSpeciesEdit">Common Name:
            <input type="text" id="commonNameSpeciesEdit" name="commonNameSpeciesEdit"
                   value="<?= $speciesData['common_name'] ?>" required>
            </label>
            <label for="scientificNameSpeciesEdit">Scientific Name:
            <input type="text" id="scientificNameSpeciesEdit" name="scientificNameSpeciesEdit"
                   value="<?= $speciesData['scientific_name'] ?>" required>
            </label>
            <label for="conservationStatusSpeciesEdit">Conservation Status:
            <input type="text" id="conservationStatusSpeciesEdit" name="conservationStatusSpeciesEdit"
                   value="<?= $speciesData['conservation_status'] ?>">
            </label>
            <label for="dietSpeciesEdit">Diet:
            <textarea id="dietSpeciesEdit" name="dietSpeciesEdit"><?= $speciesData['diet'] ?></textarea>
            </label>
            <label for="behaviourSpeciesEdit">Behaviour:
            <textarea id="behaviourSpeciesEdit" name="behaviourSpeciesEdit"><?= $speciesData['behaviour'] ?></textarea>
            </label>
            <label for="imageSpeciesEdit">Image URL:
            <input type="url" id="imageSpeciesEdit" name="imageSpeciesEdit" value="<?= $speciesData['image'] ?>">
            </label>
            <button type="submit" name="editSpeciesClick" value="<?= $speciesData['species_id'] ?>">Submit</button>
        </form>
    <?php endif ?>
</div>
<?php endif ?>

<!-- List all species -->
<div class="boxes">
<?php $pageFunctionality->listAllSpecies(); ?>
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