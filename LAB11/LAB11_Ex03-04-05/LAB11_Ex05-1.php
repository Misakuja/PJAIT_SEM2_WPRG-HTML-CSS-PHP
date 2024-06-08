<?php
require_once "LAB11_Ex03-Car.php";
require_once "LAB11_Ex03-NewCar.php";
require_once "LAB11-Ex04-InsuranceCar.php";

session_start();

$firstFormSubmitted = false;

if (!isset($_SESSION['carsObjects'])) {
    $_SESSION['carsObjects'] = [];
    $_SESSION['car_count'] = 0;
}
if (!isset($_SESSION['carChoice'])) {
    $_SESSION['carChoice'] = null;
}
if (!isset($_SESSION['calculatedPrices'])) {
    $_SESSION['calculatedPrices'] = [];
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["firstFormSubmit"])) {
    if (isset($_POST['carChoice'])) $_SESSION['carChoice'] = $_POST['carChoice'];
    $firstFormSubmitted = true;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['model'])) {
    $carChoice = $_SESSION['carChoice'];

    $model = $_POST['model'];
    $price = $_POST['price'];
    $exchangeRate = $_POST['exchangeRate'];
    $alarm = isset($_POST['alarm']);
    $radio = isset($_POST['radio']);
    $climatronic = isset($_POST['climatronic']);
    $firstOwner = isset($_POST['firstOwner']);
    $years = $_POST['years'] ?? null;

    $car = createObject($carChoice, $model, $price, $exchangeRate, $alarm, $radio, $climatronic, $firstOwner, $years);

    $_SESSION['carsObjects'][] = $car;
    $_SESSION['car_count']++;
}

function createObject($carChoice, $model, $price, $exchangeRate, $alarm, $radio, $climatronic, $firstOwner, $years) : NewCar|Car|InsuranceCar|null {
    return match ($carChoice) {
        "car" => new Car($model, $price, $exchangeRate),
        "newCar" => new NewCar($model, $price, $exchangeRate, $alarm, $radio, $climatronic),
        "insuranceCar" => new InsuranceCar($model, $price, $exchangeRate, $alarm, $radio, $climatronic, $firstOwner, $years),
        default => null,
    };
}

// delete / edit / check / calc price | logic below
function deleteCar($index) : void {
    unset ($_SESSION['carsObjects'][$index]);
    unset ($_SESSION['calculatedPrices'][$index]);
    $_SESSION['car_count']--;
    $_SESSION['cars'] = array_values($_SESSION['carsObjects']);
    $_SESSION['calculatedPrices'] = array_values($_SESSION['calculatedPrices']);
}
if(isset($_POST["deleteCar"]) && isset($_POST["index"])) {
    $index = $_POST["index"];
    deleteCar($index);
}
function calcPrice($index) : int|float {
    $car = $_SESSION['carsObjects'][$index];
    return $car->value();
}
if (isset($_POST["calculatePrice"]) && isset($_POST["index"])) {
    $index = $_POST["index"];
    $_SESSION['calculatedPrices'][$index] = calcPrice($index);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Site</title>
    <link href="LAB11_Ex05.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
<div class="carCounter">
    <?php
    echo "<h1>Car Counter: " . $_SESSION['car_count'] . "</h1>";
    ?>
</div>
<div class="formChoice">
    <form method='post' action="">
        <fieldset>
            <label>
                <select name="carChoice">
                    <option value="choice" name="choice" disabled selected>Choose Car Type</option>
                    <option value="car" name="car">Car</option>
                    <option value="newCar" name="newCar">NewCar</option>
                    <option value="insuranceCar" name="insuranceCar">InsuranceCar</option>
                </select>
            </label>
            <button type='submit'>Submit</button>
            <input type="hidden" name="firstFormSubmit" value="firstFormSubmit">
        </fieldset>
    </form>
</div>
<?php if ($firstFormSubmitted) : ?>
<div class="formInput">
    <form method='post' action="">
        <fieldset>
            <label for="model">Model:
            <input type='text' id='model' name='model' required>
            </label>
            <label for="price">Price:
            <input type='number' id='price' name='price' required>
            </label>
            <label for="exchangeRate">Exchange Rate:
            <input type='number' id='exchangeRate' name='exchangeRate' required>
            </label>
            <?php if ($_SESSION['carChoice'] === 'newCar' || $_SESSION['carChoice'] === "insuranceCar"): ?>
                <label for="alarm">Alarm:
                <input type='checkbox' id='alarm' name='alarm'>
                </label>
                <label for="radio">Radio:
                <input type='checkbox' id='radio' name='radio'>
                </label>
                <label for="climatronic">Climatronic:
                <input type='checkbox' id='climatronic' name='climatronic'>
                </label>
            <?php endif ?>

            <?php if ($_SESSION['carChoice'] === 'insuranceCar'): ?>
                <label for="firstOwner">First Owner:
                <input type='checkbox' id='firstOwner' name='firstOwner'>
                </label>

                <label for="years">Years:
                <input type='number' id='years' name='years' required>
                </label>
            <?php endif ?>

            <button type='submit'>Submit</button>
        </fieldset>
    </form>
</div>
<?php endif ?>
<div class="carList">
    <ul>
        <?php if(!empty($_SESSION['carsObjects'])) foreach ($_SESSION['carsObjects'] as $index => $car) : ?>
        <?php if($car !== null) : ?>
            <li>
                <?php
                echo "<p>Model: " . $car->getModel() . "<br>Price: " . $car->getPrice() . " EUR" . "<br>Exchange Rate: " . $car->getExchangeRate() . " PLN";
                if (isset($_SESSION['calculatedPrices'][$index])) {
                    echo "<br>Value: " . $_SESSION['calculatedPrices'][$index];
                }
                echo "</p>";
                ?>
                <div class="listButtons">
                <form action="" method="post">
                    <button type="submit" name="calculatePrice">Calculate Price</button>
                    <input type="hidden" name="index" value="<?php echo $index ?>">
                </form>

                <form action="LAB11_Ex05-2.php" method="post">
                    <button type="submit" name="detailsCar">Check or edit car details</button>
                    <input type="hidden" name="index" value="<?php echo $index ?>">
                </form>
                <form action="" method="post">
                    <button type="submit" name="deleteCar">Delete Car</button>
                    <input type="hidden" name="index" value="<?php echo $index ?>">
                </form>
                </div>
            </li>
        <?php endif ?>
        <?php endforeach ?>
    </ul>
</div>
</div>
</body>
</html>
