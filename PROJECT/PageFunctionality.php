<?php
require_once 'PageInterface.php';
require_once 'Databases.php';
session_start();

global $pdo;

class PageFunctionality implements PageInterface {

    function sendMailContactForm(): void {
        $name = $_POST['contactFormName'];
        $mail = $_POST['contactFormMail'];
        $phone = $_POST['contactFormPhone'];
        $message = $_POST['contactFormMessage'];

        $headers = "From: $name <$mail>\r\n <$phone>\r\n";

        $message = wordwrap($message, 70);

        mail('contact@zoo.com', 'Contact Form Message', $message, $headers);
    }

    function logoutUser(): void {
        unset($_SESSION['user_id']);
        unset($_SESSION['zookeeper_id']);
        session_destroy();
    }

    function registerUser(): void {
        global $pdo;
        $firstName = $_POST["registerFirstName"];
        $lastName = $_POST["registerLastName"];
        $email = $_POST["registerEmail"];
        $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM users WHERE user_email = '$email'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $_SESSION['notification'] = "Email already registered";
        } else {
            $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password) VALUES ('$firstName', '$lastName', '$email', '$password')";
            $pdo->exec($sql);
            $_SESSION['notification'] = "Registered successfully";
        }
    }

    function loginUser(): void {
        global $pdo;
        $loginEmail = $_POST["loginEmail"];
        $loginPassword = $_POST["loginPassword"];

        $user = $pdo->query("SELECT * FROM users WHERE user_email = '$loginEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($loginPassword, $user['user_password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_first_name'] = $user['user_first_name'];
            $_SESSION['user_last_name'] = $user['user_last_name'];
            $_SESSION['user_email'] = $user['user_email'];

            $_SESSION['notification'] = "Logged in successfully as " . $user['user_first_name'] . " " . $user['user_last_name'];
        } else {
            $_SESSION['notification'] = "Invalid Email or Password";
        }
        if (isset($_SESSION['zookeeper_id'])) unset($_SESSION['zookeeper_id']);
    }

    function resetPasswordUser(): void {
        global $pdo;
        $resetEmail = $_POST["resetEmail"];
        $resetPassword = password_hash($_POST["resetPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM users WHERE user_email = '$resetEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $sql = "UPDATE users SET user_password = '$resetPassword' WHERE user_email = '$resetEmail'";
            $pdo->exec($sql);

            $_SESSION['notification'] = "Password reset successfully.";
        } else {
            $_SESSION['notification'] = "Password reset failed.";
        }
    }

    function loginZookeeper(): void {
        global $pdo;
        $loginZookeeperEmail = $_POST["loginZookeeperEmail"];
        $loginPasswordZookeeper = $_POST["loginZookeeperPassword"];

        $zookeeper = $pdo->query("SELECT * FROM zookeepers WHERE zookeeper_email = '$loginZookeeperEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($zookeeper && password_verify($loginPasswordZookeeper, $zookeeper['zookeeper_password'])) {
            $_SESSION['zookeeper_id'] = $zookeeper['zookeeper_id'];

            $_SESSION['notification2'] = "Logged in successfully as " . $zookeeper['zookeeper_first_name'] . " " . $zookeeper['zookeeper_last_name'];
        } else {
            $_SESSION['notification2'] = "Invalid Email or Password.";
        }
        if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
    }

    function resetPasswordZookeeper(): void {
        global $pdo;
        $resetZookeeperEmail = $_POST["resetEmailZookeeper"];
        $resetZookeeperPassword = password_hash($_POST["resetZookeeperPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM zookeepers WHERE zookeepers_email = '$resetZookeeperEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $sql = "UPDATE zookeepers SET zookeeper_password = '$resetZookeeperEmail' WHERE zookeeper_email = '$resetZookeeperPassword'";
            $pdo->exec($sql);

            $_SESSION['notification'] = "Password reset successfully.";
        } else {
            $_SESSION['notification'] = "Password reset failed.";
        }
    }

    function displayCart(): void {
        if (!empty($_SESSION['cart'])) {
            echo "<h2 class='information-cart'>Cart Contents:</h2>";
            echo "
            <table id='cart-table'>
            <thead>
                <tr>
                    <th>TYPE OF TICKET</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>TOTAL VALUE</th>
                </tr>
            </thead>";
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                if ($product_id === "Normal") {
                    $ticketPrice = 10;
                } else $ticketPrice = 5;

                $ticketValue = $this->calculatePrice($product_id, $ticketPrice);
                echo "
                <tbody>
                <tr>
                    <td>$product_id Ticket</td>
                    <td>$ticketPrice$</td>
                    <td>$quantity</td>
                    <td>$ticketValue$</td>
                </tr>";
            }
            echo "</tbody></table>";

            $totalPrice = $this->calculateTotalValue();
            echo "<h3>Total Price: " . $totalPrice . "$</h3>";
        } else {
            echo "<h2 class='information-cart'>Your cart is empty.</h2>";
        }
    }

    function calculatePrice($product_id, $ticketPrice): int|float {
        return $ticketPrice * $_SESSION['cart'][$product_id];
    }

    function calculateTotalValue(): int|float {
        $totalPrice = null;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            if ($product_id === "Normal") {
                $ticketPrice = 10;
            } else $ticketPrice = 5;

            $totalPrice = $totalPrice + $this->calculatePrice($product_id, $ticketPrice);
        }
        return $totalPrice;
    }

    function addToCart($product_id): void {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += 1;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }

    function removeFromCart($product_id): void {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] -= 1;

            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }

    function clearCart(): void {
        unset($_SESSION['cart']);
    }

    function checkoutCart(): void {
        global $pdo;

        $totalPrice = $this->calculateTotalValue();

        $adultAmount = $_SESSION['cart']["Normal"] ?? 0;
        $reducedAmount = $_SESSION['cart']["Reduced"] ?? 0;
        $firstName = $pdo->quote($_SESSION['user_first_name']);
        $lastName = $pdo->quote($_SESSION['user_last_name']);
        $userId = $pdo->quote($_SESSION['user_id']);

        $sql = "INSERT INTO ticketorders (user_id, buyer_first_name, buyer_last_name, order_price, normal_tickets_amount, reduced_tickets_amount) VALUES ($userId, $firstName, $lastName, $totalPrice, $adultAmount, $reducedAmount)";
        $pdo->exec($sql);

        $this->sendConfirmationMailCheckout();

        unset($_SESSION['cart']);
    }

    function sendConfirmationMailCheckout(): void {
        $email = $_SESSION['user_email'];
        $subject = 'Ticket Confirmation';
        $totalValue = $this->calculateTotalValue() . "$" . PHP_EOL;
        $adultAmount = $_SESSION['cart']["Normal"] ?? 0;
        $reducedAmount = $_SESSION['cart']["Reduced"] ?? 0;

        $message = 'Name: ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . PHP_EOL;
        $message .= 'Total Price: ' . $totalValue . PHP_EOL;
        $message .= 'Normal Tickets: ' . $adultAmount . PHP_EOL;
        $message .= 'Reduced Tickets: ' . $reducedAmount . PHP_EOL;

        $headers = 'From no-reply@zoo.com';

        mail($email, $subject, $message, $headers);
    }

    function updateAnimalCategoriesDatabase(): void {
        global $pdo;

        $sql1 = "UPDATE animalcategories SET number_of_species = (SELECT COUNT(DISTINCT species_id) FROM species WHERE species.category_id = animalCategories.category_id);";
        $pdo->exec($sql1);

        $sql2 = "UPDATE animalcategories SET number_of_specimens = (SELECT COUNT(*) FROM animals JOIN species ON animals.species_id = species.species_id WHERE species.category_id = animalcategories.category_id);";
        $pdo->exec($sql2);
    }

    function getNumberOfSpecies(): int {
        global $pdo;

        $this->updateAnimalCategoriesDatabase();

        $fetchSpecies = $pdo->query("SELECT SUM(number_of_species) AS total_species FROM animalcategories")->fetch(PDO::FETCH_ASSOC);

        return (int)$fetchSpecies['total_species'];
    }

    function getNumberOfSpecimens(): int {
        global $pdo;

        $this->updateAnimalCategoriesDatabase();

        $fetchSpecimens = $pdo->query("SELECT SUM(number_of_specimens) AS total_specimens FROM animalcategories")->fetch(PDO::FETCH_ASSOC);

        return (int)$fetchSpecimens['total_specimens'];
    }

    function showAnimalCategoriesTable(): void {
        $this->updateAnimalCategoriesDatabase();

        global $pdo;
        $sql = "SELECT category_id FROM animalcategories";
        $ids = $pdo->query($sql)->fetchAll(PDO::FETCH_COLUMN, 0);
        echo "<div id='animal-categories'><h2>All Our animals in numbers</h2><table>
    <thead>
        <tr>
            <th>Category</th>
            <th>Species</th>
            <th>Specimens</th>
        </tr>
    </thead>
    <tbody>";
        foreach ($ids as $id) {
            $nextRow = $pdo->query("SELECT * FROM animalcategories WHERE category_id = '$id'")->fetch(PDO::FETCH_ASSOC);
            echo "<tr>
                <td>{$nextRow['category_name']}</td>
                <td>{$nextRow['number_of_species']}</td>
                <td>{$nextRow['number_of_specimens']}</td>
            </tr>";
        }
        echo "</tbody></table></div>";
    }

    function listAllSpecies(): void {
        global $pdo;
        $sql = "SELECT species_id FROM species";
        $ids = $pdo->query($sql)->fetchAll(PDO::FETCH_COLUMN, 0);

        foreach ($ids as $id) {
            $nextRow = $pdo->query("SELECT * FROM species WHERE species_id = '$id'")->fetch(PDO::FETCH_ASSOC);

            $url = "9-AnimalDetailsPage.php?id=" . $id;
            if ($nextRow) {
                echo "<a href='$url' class='animal-species-box' id='species-box'>
                <img class='animal-species-image' src='{$nextRow['image']}' alt='species_img'>
                <div class='animal-species-information'>
                    <h3 id='species-common-name'>{$nextRow['common_name']}</h3>
                    <h4>{$nextRow['scientific_name']}</h4>
                    <ul>
                        <li><strong>Conservation Status:</strong> {$nextRow['conservation_status']}</li>
                        <li><strong>Diet:</strong> {$nextRow['diet']}</li>
                        <li><strong>Behaviour:</strong> {$nextRow['behaviour']}</li>";
                if (isset($_SESSION['zookeeper_id'])) {
                    echo "<li> 
                            <form method='POST'>
                                <button type='submit' name='deleteSpecies' value='{$nextRow['species_id']}'>Delete</button>
                                <button type='submit' name='editSpecies' value='{$nextRow['species_id']}'>Edit</button>
                            </form></li>";
                }
                echo "</ul></div></a>";
            }
        }
    }

    function listAllSpecimen($url_id): void {
        global $pdo;
        $sql = "SELECT animal_id FROM animals WHERE species_id = '$url_id'";
        $ids = $pdo->query($sql)->fetchAll(PDO::FETCH_COLUMN, 0);

        foreach ($ids as $id) {
            $nextRow = $pdo->query("SELECT * FROM animals WHERE animal_id = '$id'")->fetch(PDO::FETCH_ASSOC);

            if ($nextRow) {
                echo "<div class='animal-species-box' id='animal-box'>
                <img class='animal-species-image' src='{$nextRow['image']}' alt='specimen_img'>
                <div class='animal-species-information'>
                    <h3 id='animal-name'>{$nextRow['animal_name']}</h3>
                    <ul>
                        <li><strong>Date of Birth:</strong> {$nextRow['date_of_birth']}</li>
                        <li><strong>Habitat:</strong> {$nextRow['habitat_id']}</li>
                        <li><strong>Description:</strong> {$nextRow['description']}</li>";
                if (isset($_SESSION['zookeeper_id'])) {
                    echo "<li><form method='POST'>
                                <button type='submit' name='deleteAnimal' value='{$nextRow['animal_id']}'>Delete</button>
                                <button type='submit' name='editAnimal' value='{$nextRow['animal_id']}'>Edit</button>
                            </form></li>";
                }
                echo "</ul></div></div>";
            }
        }
    }

    function getCategories($selectedCategoryId): void {
        global $pdo;
        $sql = "SELECT category_id, category_name FROM animalcategories ORDER BY category_name";
        $categories = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $category) {
            $isSelected = ($category['category_id'] == $selectedCategoryId) ? 'selected' : '';
            echo '<option value="' . $category['category_id'] . '" ' . $isSelected . '>' . $category['category_name'] . '</option>';
        }
    }

    function addSpecies(): void {
        global $pdo;
        $categoryName = $_POST['categoryNameSpeciesAdd'];
        $commonName = $_POST['commonNameSpeciesAdd'];
        $scientificName = $_POST['scientificNameSpeciesAdd'];
        $conservationStatus = $_POST['conservationStatusSpeciesAdd'];
        $diet = $_POST['dietSpeciesAdd'];
        $behaviour = $_POST['behaviourSpeciesAdd'];
        $imageUrl = $_POST['imageSpeciesAdd'];

        try {
            $sql = "INSERT INTO species (category_id, common_name, scientific_name, conservation_status, diet, behaviour, image) VALUES ('$categoryName', '$commonName', '$scientificName', '$conservationStatus', '$diet', '$behaviour', '$imageUrl')";
            $pdo->exec($sql);
        } catch (PDOException $e) {
            $_SESSION['notificationAdd'] = "Failed to add new entry.";
        }
    }

    function fetchClickedSpecies() {
        global $pdo;

        $sql = "SELECT * FROM species WHERE species_id = {$_POST['editSpecies']}";
        return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function editSpecies($selectedSpeciesId): void {
        global $pdo;
        $categoryName = $_POST['categoryNameSpeciesEdit'];
        $commonName = $_POST['commonNameSpeciesEdit'];
        $scientificName = $_POST['scientificNameSpeciesEdit'];
        $conservationStatus = $_POST['conservationStatusSpeciesEdit'];
        $diet = $_POST['dietSpeciesEdit'];
        $behaviour = $_POST['behaviourSpeciesEdit'];
        $imageUrl = $_POST['imageSpeciesEdit'];

        $sql = "UPDATE species SET category_id = '$categoryName', common_name = '$commonName', scientific_name = '$scientificName', conservation_status = '$conservationStatus', diet = '$diet', behaviour = '$behaviour', image = '$imageUrl' WHERE species_id = '$selectedSpeciesId'";
        $pdo->exec($sql);
    }

    function deleteSpecies(): void {
        global $pdo;

        $sql1 = "DELETE FROM animals WHERE species_id = '{$_POST['deleteSpecies']}'";
        $pdo->exec($sql1);

        $sql2 = "DELETE FROM species WHERE species_id = '{$_POST['deleteSpecies']}'";
        $pdo->exec($sql2);
    }

    function addAnimal(): void {
        global $pdo;
        $speciesId = $_POST['SpeciesIdAnimalAdd'];
        $name = $_POST['nameAnimalAdd'];
        $habitatId = $_POST['habitatIdAnimalAdd'];
        $dateOfBirth = $_POST['dateOfBirthAnimalAdd'];
        $description = $_POST['descriptionAnimalAdd'];
        $imageUrl = $_POST['imageAnimalAdd'];

        try {
            $sql = "INSERT INTO animals (animal_name, species_id, habitat_id, date_of_birth, description, image) VALUES ('$name', '$speciesId', '$habitatId', '$dateOfBirth', '$description', '$imageUrl')";
            $pdo->exec($sql);
        } catch (PDOException $e) {
            $_SESSION['notificationAdd'] = "Failed to add new entry.";
        }
    }

    function fetchClickedAnimal() {
        global $pdo;

        $sql = "SELECT * FROM animals WHERE animal_id = {$_POST['editAnimal']}";
        return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function editAnimal($selectedAnimalId): void {
        global $pdo;
        $speciesId = $_POST['SpeciesIdAnimalEdit'];
        $name = $_POST['nameAnimalEdit'];
        $habitatId = $_POST['habitatIdAnimalEdit'];
        $dateOfBirth = $_POST['dateOfBirthAnimalEdit'];
        $description = $_POST['descriptionAnimalEdit'];
        $imageUrl = $_POST['imageAnimalEdit'];

        $sql = "UPDATE animals SET species_id = '$speciesId', animal_name = '$name', habitat_id = '$habitatId', date_of_birth = '$dateOfBirth', description = '$description', image = '$imageUrl' WHERE animal_id = '$selectedAnimalId'";
        $pdo->exec($sql);
    }

    function deleteAnimal(): void {
        global $pdo;
        $sql = "DELETE FROM animals WHERE animal_id = '{$_POST['deleteAnimal']}'";
        $pdo->exec($sql);
    }
}
