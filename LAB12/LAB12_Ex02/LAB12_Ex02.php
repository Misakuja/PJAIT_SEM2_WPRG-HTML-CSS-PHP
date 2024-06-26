<?php
$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'LAB12Ex02';
$persons = null;
$cars = null;
$pdo = null;
$searchResults = null;
$notif = null;
$notif2 = null;

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $personTable = "CREATE TABLE IF NOT EXISTS Person ( 
    Person_id INT AUTO_INCREMENT, 
    Person_first_name VARCHAR(255) NOT NULL, 
    Person_second_name VARCHAR(255) NOT NULL, 
    PRIMARY KEY (Person_id)
    )";
    $pdo->exec($personTable);

    $carsTable = "CREATE TABLE IF NOT EXISTS Cars (
    Cars_id INT AUTO_INCREMENT, 
    Cars_model VARCHAR(255) NOT NULL, 
    Cars_price FLOAT NOT NULL, 
    Cars_day_of_buy DATETIME NOT NULL,
    Person_id INT NOT NULL,

    PRIMARY KEY (Cars_id),
    FOREIGN KEY (Person_id) REFERENCES Person (Person_id)
    );";
    $pdo->exec($carsTable);
    $notif = "Successfully created tables Person and Cars.\n";

    $persons = $pdo->query("SELECT * FROM Person")->fetchAll(PDO::FETCH_ASSOC);
    $cars = $pdo->query("SELECT * FROM Cars")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addPerson"])) {
        $firstName = $_POST["personFirstName"];
        $secondName = $_POST["personSecondName"];
        $sql = "INSERT INTO Person (Person_first_name, Person_second_name) VALUES ('$firstName', '$secondName')";

        $pdo->query($sql);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCar"])) {
        $carsModel = $_POST["carsModel"];
        $carsPrice = $_POST["carsPrice"];
        $dayOfBuy = $_POST["carsDayOfBuy"];
        $personId = $_POST["personId"];

        $sql = "INSERT INTO Cars (Cars_model, Cars_price, Cars_day_of_buy, Person_id) VALUES ('$carsModel', '$carsPrice', '$dayOfBuy', '$personId')";
        $pdo->query($sql);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deletePerson"])) {
        $PersonIndex = $_POST["index"];

        $sql = "DELETE FROM Cars WHERE Person_id = '$PersonIndex'";
        $pdo->exec($sql);

        $sql2 = "DELETE FROM Person WHERE Person_id = '$PersonIndex'";
        $pdo->exec($sql2);

        $notif2 = "Successfully deleted Person with index: " . $PersonIndex;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteCar"])) {
        $carIndex = $_POST["index"];
        $sql = "DELETE FROM Cars WHERE Cars_id = '$carIndex'";
        $pdo->exec($sql);

        $notif2 = "Successfully deleted Car with index: " . $carIndex;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editPersonSubmit"])) {
        $personIndex = $_POST["index"];
        $firstNameEdit = $_POST["personFirstNameEdit"];
        $secondNameEdit = $_POST["personSecondNameEdit"];

        $sql = "UPDATE Person SET Person_first_name = '$firstNameEdit', Person_second_name = '$secondNameEdit' WHERE Person_id = '$personIndex'";
        $pdo->exec($sql);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editCarSubmit"])) {
        $carIndex = $_POST["index"];
        $modelEdit = $_POST["modelEdit"];
        $priceEdit = $_POST["priceEdit"];
        $dayOfBuyEdit = $_POST["dayOfBuyEdit"];
        $PersonIdEdit = $_POST["carPersonIdEdit"];

        $sql = "UPDATE Cars SET Cars_model = '$modelEdit', Cars_price = '$priceEdit', Cars_day_of_buy = '$dayOfBuyEdit', Person_id = '$PersonIdEdit' WHERE Cars_id = '$carIndex'";
        $pdo->exec($sql);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        $field = $_POST["searchField"];
        $value = $_POST["searchValue"];

        $sql = "SELECT * FROM Person JOIN Cars ON Person.Person_id = Cars.Person_id WHERE $field LIKE '%$value%'";
        $searchResults = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    $persons = $pdo->query("SELECT * FROM Person")->fetchAll(PDO::FETCH_ASSOC);
    $cars = $pdo->query("SELECT * FROM Cars")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Managing MySQL Database</title>
    <link href="LAB12_Ex02.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <h1>Manage MySQL Database</h1>
    <?php if ($notif) : ?>
        <p> <?= $notif ?> </p>
    <?php endif ?>
    <?php if ($notif2) : ?>
        <p> <?= $notif2 ?> </p>
    <?php endif ?>
    <div class="formWrap addPersonForm">
        <form method='post' action="">
            <fieldset>
                <legend>Add Person</legend>
                <label for="firstName">First Name:
                <input type='text' id='firstName' placeholder='First Name' name='personFirstName' required>
                </label>
                <label for="secondName">Second Name:
                <input type='text' id='secondName' placeholder='Second Name' name='personSecondName' required>
                </label>

                <button type='submit' name='addPerson'>Add Person</button>
            </fieldset>
        </form>
    </div>
    <div class="formWrap addCarForm">
        <form method='post' action="">
            <fieldset>
                <legend>Add Car</legend>
                <label for="model">Model:
                <input type='text' id='model' placeholder='Model' name='carsModel' required>
                </label>
                <label for="price">Price:
                <input type='number' step='0.01' id='price' placeholder='Price' name='carsPrice' required>
                </label>
                <label for="carsDayOfBuy">Day of Buy:
                <input type='datetime-local' id='carsDayOfBuy' name='carsDayOfBuy' required>
                </label>
                <label>Person ID:
                    <select name="personId">
                        <?php foreach ($persons as $person) : ?>
                            <option value="<?= $person["Person_id"] ?>"> <?= $person['Person_id'] ?> </option>
                        <?php endforeach ?>
                    </select>
                </label>
                <button type='submit' name='addCar'>Add Car</button>
            </fieldset>
        </form>
    </div>
    <?php if ($persons && $cars) : ?>
        <div class="formWrap searchForm">
            <form method='post' action="">
                <fieldset>
                    <legend>Search by Value</legend>
                    <label>Search Field:
                        <select name="searchField" id="searchField">
                            <option value="Person_first_name">First Name</option>
                            <option value="Person_second_name">Second Name</option>
                            <option value="Cars_model">Car Model</option>
                            <option value="Cars_price">Car Price</option>
                            <option value="Cars_day_of_buy">Car Date of Buy</option>
                        </select>
                    </label>
                    <label for="searchValue">Search Value:
                    <input type='text' id='searchValue' name='searchValue' required>
                    </label>
                    <button type='submit' name='search'>Search</button>
                </fieldset>
            </form>
        </div>
    <?php endif ?>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editPerson"])) : ?>
        <?php
        $index = $_POST['index'];
        $chosenPerson = $pdo->query("SELECT * FROM Person WHERE Person_id = '$index'")->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="formWrap editPersonForm">
            <form method='post' action="">
                <fieldset>
                    <legend>Edit Person</legend>
                    <label for="firstNameEdit">First Name:
                    <input type='text' id='firstNameEdit' name='personFirstNameEdit'
                           value='<?= $chosenPerson[0]['Person_first_name'] ?>' required>
                    </label>
                    <label for="secondNameEdit">Second Name:
                    <input type='text' id='secondNameEdit' name='personSecondNameEdit'
                           value='<?= $chosenPerson[0]['Person_second_name'] ?>' required>
                    </label>
                    <button type='submit' name='editPersonSubmit'>Edit Person</button>
                    <input type="hidden" name="index" value="<?php echo $index ?>">
                </fieldset>
            </form>
        </div>
    <?php endif ?>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editCar"])) : ?>
        <?php
        $index = $_POST['index'];
        $chosenCar = $pdo->query("SELECT * FROM Cars WHERE Cars_id = '$index'")->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="formWrap editCar">
            <form method='post' action="">
                <fieldset>
                    <legend>Edit Car</legend>
                    <label for="modelEdit">Model:
                    <input type='text' id='modelEdit' name='modelEdit' value='<?= $chosenCar[0]['Cars_model'] ?>' required>
                    </label>
                    <label for="priceEdit">Price:
                    <input type='number' id='priceEdit' step='0.01' name='priceEdit' value='<?= $chosenCar[0]['Cars_price'] ?>' required>
                    </label>
                    <label for="dayOfBuyEdit">Day of Buy:
                    <input type='datetime-local' id='dayOfBuyEdit' name='dayOfBuyEdit' value='<?= $chosenCar[0]['Cars_day_of_buy'] ?>' required>
                    </label>
                    <label>Person ID:
                        <select name="carPersonIdEdit">
                            <?php foreach ($persons as $person) : ?>

                                <?php if ($chosenCar[0]['Person_id'] == $person['Person_id']) { ?>
                                    <option value="<?= $person['Person_id'] ?>"
                                            selected> <?= $person['Person_id'] ?> </option>
                                <?php } else { ?>
                                    <option value="<?= $person['Person_id'] ?>"> <?= $person['Person_id'] ?> </option>
                                <?php } ?>
                            <?php endforeach ?>
                        </select>
                    </label>

                    <button type='submit' name='editCarSubmit'>Edit Car</button>
                    <input type="hidden" name="index" value="<?php echo $index ?>">
                </fieldset>
            </form>
        </div>
    <?php endif ?>

    <?php if ($searchResults) : ?>
        <div class="tableWrap searchTable">
            <table>
                <tr>
                    <th>Person_ID</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Cars_ID</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Day of Buy</th>
                </tr>
                <?php foreach ($searchResults as $row) : ?>
                    <tr>
                        <td> <?= $row['Person_id'] ?> </td>
                        <td> <?= $row['Person_first_name'] ?> </td>
                        <td> <?= $row['Person_second_name'] ?> </td>
                        <td> <?= $row['Cars_id'] ?> </td>
                        <td> <?= $row['Cars_model'] ?> </td>
                        <td> <?= $row['Cars_price'] ?> </td>
                        <td> <?= $row['Cars_day_of_buy'] ?> </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    <?php endif ?>

    <?php if ($persons) : ?>
        <div class="tableWrap personTable">
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($persons as $person) : ?>
                    <tr>
                        <td> <?= $person['Person_id'] ?> </td>
                        <td> <?= $person['Person_first_name'] ?> </td>
                        <td> <?= $person['Person_second_name'] ?> </td>
                        <td>
                            <form method="post" action="">
                                <button type="submit" name="deletePerson">Delete</button>
                                <button type="submit" name="editPerson">Edit</button>
                                <input type="hidden" name="index" value="<?php echo $person['Person_id'] ?>">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif ?>
    <?php if ($cars) : ?>
        <div class="tableWrap carsTable">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Day of Buy</th>
                    <th>Person ID</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cars as $car) : ?>
                    <tr>
                        <td> <?= $car['Cars_id'] ?> </td>
                        <td> <?= $car['Cars_model'] ?> </td>
                        <td> <?= $car['Cars_price'] ?> </td>
                        <td> <?= $car['Cars_day_of_buy'] ?> </td>
                        <td> <?= $car['Person_id'] ?> </td>
                        <td>
                            <form method="post" action="">
                                <button type="submit" name="deleteCar">Delete</button>
                                <button type="submit" name="editCar">Edit</button>
                                <input type="hidden" name="index" value="<?php echo $car['Cars_id'] ?>">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif ?>
</div>
</body>
</html>