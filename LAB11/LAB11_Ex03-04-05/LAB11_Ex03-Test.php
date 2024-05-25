<?php
require "LAB11_Ex03-Car.php";
require "LAB11_Ex03-NewCar.php";
require "LAB11-Ex04-InsuranceCar.php";

$car = new Car("Toyota", 20000, 4.5);
echo "Car Information:\n";
echo $car . "\n\n";

$newCar = new NewCar("BMW", 30000, 5.0, true, false, true);
echo "New Car Information:\n";
echo $newCar . "\n\n";

$newCar->setClimatronic(false);

echo "Updated New Car Information:\n";
echo "Model: " . $newCar->getModel() . "\n";
echo $newCar;

$carInsurance = new InsuranceCar("BMW", 30000, 5.0, true, false, true, "Joe Doe", 2);
echo "Car Information:\n";
echo $carInsurance . "\n\n";

echo "value calc: " . $carInsurance->value();

echo "Amount of cars: " . Car::getCount();