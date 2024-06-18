<?php
require_once 'PageFunctionality.php';
$pageFunctionality = new PageFunctionality();

global $pdo;
$url_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["logoutUser"])) $pageFunctionality->logoutUser();
    if (isset($_POST["deleteAnimal"])) $pageFunctionality->deleteAnimal();
    if (isset($_POST["addAnimal"])) $pageFunctionality->addAnimal();
    if (isset($_POST["editAnimalClick"])) $pageFunctionality->editAnimal($_POST['editAnimalClick']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZOO Animal Detail Page</title>
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
        <a href="8-SpeciesPage.php"> Our Species </a>
        <?php
        $sql = "SELECT * FROM `species` WHERE `species_id` = '$url_id'";
        $clickedSpecies = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

        $url = "9-AnimalDetailsPage.php?id=" . $url_id;
        if ($clickedSpecies) {
            echo "<a> &#x2192; </a>
              <a href='$url'> {$clickedSpecies['common_name']} Details</a>";
        } ?>
    </header>
</div>

<?php if (isset($_SESSION['notificationAdd'])) : ?>
    <p id="notifications"><?= $_SESSION['notificationAdd']; ?> </p>
<?php endif ?>

<!-- ZOOKEEPERS ONLY FORMS (ADD/EDIT) -->
<?php if (isset($_SESSION['zookeeper_id'])) : ?>
    <div class="edit-add-forms-container">

        <!-- Add Animal - ZOOKEEPERS ONLY -->
        <h2>Add a <?= $clickedSpecies['common_name'] ?></h2>
        <form class="edit-add-forms-zookeeper" id="animal-add" method="POST">
            <input type="hidden" id="SpeciesIdAnimalAdd" name="SpeciesIdAnimalAdd" value="<?= $url_id ?>">

            <label for="nameAnimalAdd">Name:
                <input type="text" id="nameAnimalAdd" name="nameAnimalAdd" required>
            </label>
            <label for="habitatIdAnimalAdd">Habitat Number:
                <input type="number" id="habitatIdAnimalAdd" name="habitatIdAnimalAdd">
            </label>
            <label for="dateOfBirthAnimalAdd">Date of Birth:
                <input type="date" id="dateOfBirthAnimalAdd" name="dateOfBirthAnimalAdd">
            </label>
            <label for="descriptionAnimalAdd">Description:
                <textarea id="descriptionAnimalAdd" name="descriptionAnimalAdd"></textarea>
            </label>
            <label for="imageAnimalAdd">Image URL:
                <input type="url" id="imageAnimalAdd" name="imageAnimalAdd">
            </label>
            <button type="submit" name="addAnimal">Submit</button>
        </form>
        <!-- Edit Animal - ZOOKEEPERS ONLY -->
        <?php if (isset($_POST['editAnimal'])) :
        $animalData = $pageFunctionality->fetchClickedAnimal(); ?>
        <h2>Edit Animal <?= $animalData['animal_name'] ?> </h2>
        <form class="edit-add-forms-zookeeper" id="animal-edit" method="POST">
            <input type="hidden" id="SpeciesIdAnimalEdit" name="SpeciesIdAnimalEdit" value="<?= $url_id ?>">

            <label for="nameAnimalEdit">Name:
                <input type="text" id="nameAnimalEdit" name="nameAnimalEdit" value="<?= $animalData['animal_name'] ?>"
                       required>
            </label>
            <label for="habitatIdAnimalEdit">Habitat Number:
                <input type="number" id="habitatIdAnimalEdit" name="habitatIdAnimalEdit"
                       value="<?= $animalData['habitat_id'] ?>">
            </label>
            <label for="dateOfBirthAnimalEdit">Date of Birth:
                <input type="date" id="dateOfBirthAnimalEdit" name="dateOfBirthAnimalEdit"
                       value="<?= $animalData['date_of_birth'] ?>">
            </label>
            <label for="descriptionAnimalEdit">Description:
                <textarea id="descriptionAnimalEdit"
                          name="descriptionAnimalEdit"><?= $animalData['description'] ?></textarea>
            </label>
            <label for="imageAnimalEdit">Image URL:
                <input type="url" id="imageAnimalEdit" name="imageAnimalEdit" value="<?= $animalData['image'] ?>">
            </label>
            <button type="submit" name="editAnimalClick" value="<?= $animalData['animal_id'] ?>">Submit</button>
            <?php endif ?>
    </div>
<?php endif ?>


<!-- List all animals inside the species category -->
<div class="boxes">
    <?php $pageFunctionality->listAllSpecimen($url_id); ?>
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