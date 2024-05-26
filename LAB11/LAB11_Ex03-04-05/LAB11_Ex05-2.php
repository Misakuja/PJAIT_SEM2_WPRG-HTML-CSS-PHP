<?php
require_once "LAB11_Ex03-Car.php";
require_once "LAB11_Ex03-NewCar.php";
require_once "LAB11-Ex04-InsuranceCar.php";

session_start();

if (isset($_POST['index'])) {
    $_SESSION['indexSession'] = $_POST['index'];
}
$_SESSION['chosenCar'] = $_SESSION['carsObjects'][$_SESSION['indexSession']];
// setters below
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modelChange'])) $_SESSION['chosenCar']->setModel($_POST['modelChange']);
    if (isset($_POST['priceChange'])) $_SESSION['chosenCar']->setPrice($_POST['priceChange']);
    if (isset($_POST['exchangeRateChange'])) $_SESSION['chosenCar']->setExchangeRate($_POST['exchangeRateChange']);

    if ($_SESSION['chosenCar'] instanceof NewCar || $_SESSION['chosenCar'] instanceof InsuranceCar) {
        if (isset($_POST['alarmChange'])) $_SESSION['chosenCar']->setAlarm(true);
        if (!isset($_POST['alarmChange'])) $_SESSION['chosenCar']->setAlarm(false);
        if (isset($_POST['radioChange'])) $_SESSION['chosenCar']->setRadio(true);
        if (!isset($_POST['radioChange'])) $_SESSION['chosenCar']->setRadio(false);
        if (isset($_POST['climatronicChange'])) $_SESSION['chosenCar']->setClimatronic(true);
        if (!isset($_POST['climatronicChange'])) $_SESSION['chosenCar']->setClimatronic(false);
    }

    if ($_SESSION['chosenCar'] instanceof InsuranceCar) {
        if (isset($_POST['firstOwnerChange'])) $_SESSION['chosenCar']->setFirstOwner(true);
        if (!isset($_POST['firstOwnerChange'])) $_SESSION['chosenCar']->setFirstOwner(false);

        if (isset($_POST['yearsChange'])) $_SESSION['chosenCar']->setYears($_POST['yearsChange']);
    }

    if (isset($_SESSION['calculatedPrices'][$_SESSION['indexSession']])) {
        $_SESSION['calculatedPrices'][$_SESSION['indexSession']] = $_SESSION['chosenCar']->value();
    }

    $_SESSION['carsObjects'][$_SESSION['indexSession']] = $_SESSION['chosenCar'];
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
<div class="carDetailedInfo">
    <ul>
        <?php echo "<li>" . $_SESSION['chosenCar']->getModel() . " | " . $_SESSION['chosenCar']->getPrice() . " | " . $_SESSION['chosenCar']->getExchangeRate() . "</li>"; ?>
        <?php
        if ($_SESSION['chosenCar'] instanceof NewCar || $_SESSION['chosenCar'] instanceof InsuranceCar) {
            echo "<li>" . $_SESSION['chosenCar']->getAlarm() . "</li>";
            echo "<li>" . $_SESSION['chosenCar']->getRadio() . "</li>";
            echo "<li>" . $_SESSION['chosenCar']->getClimatronic() . "</li>";
        }
        if ($_SESSION['chosenCar'] instanceof InsuranceCar) {
            echo "<li>" . $_SESSION['chosenCar']->getFirstOwner() . "</li>";
            echo "<li>" . $_SESSION['chosenCar']->getYears() . "</li>";
        }
        ?>
    </ul>
</div>
<div class="formChange">
    <form method='post' action="">
        <fieldset>
            <label for="modelChange">Model:</label>
            <input type='text' id='modelChange' name='modelChange'>

            <label for="priceChange">Price:</label>
            <input type='number' id='priceChange' name='priceChange'>

            <label for="exchangeRateChange">Exchange Rate:</label>
            <input type='number' id='exchangeRateChange' name='exchangeRateChange'>

            <?php if ($_SESSION['chosenCar'] instanceof NewCar || $_SESSION['chosenCar'] instanceof InsuranceCar): ?>
                <label for="alarmChange">Alarm:</label>
                <input type='checkbox' id='alarmChange' name='alarmChange'>

                <label for="radioChange">Radio:</label>
                <input type='checkbox' id='radioChange' name='radioChange'>

                <label for="climatronicChange">Climatronic:</label>
                <input type='checkbox' id='climatronicChange' name='climatronicChange'>
            <?php endif ?>

            <?php if ($_SESSION['chosenCar'] instanceof InsuranceCar): ?>
                <label for="firstOwnerChange">First Owner:</label>
                <input type='checkbox' id='firstOwnerChange' name='firstOwnerChange'>

                <label for="yearsChange">Years:</label>
                <input type='number' id='yearsChange' name='yearsChange'>
            <?php endif ?>

            <button type="submit" name="submitChangedChange">Submit Changes</button>
        </fieldset>
    </form>
</div>
<div class="formGoBack">
    <form action="LAB11_Ex05-1.php" method="post">
        <button type='submit'>goBack</button>
    </form>
</div>
</body>
</html>