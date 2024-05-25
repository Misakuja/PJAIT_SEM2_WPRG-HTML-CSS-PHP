<?php
class Car {
    static int $count = 0;
    private String $model;
    private float $price; //EUR
    private float $exchangeRate; //PLN

    public function __construct($model, $price, $exchangeRate) {
        $this->model = $model;
        $this->price = $price;
        $this->exchangeRate = $exchangeRate;
        self::$count++;
    }
    function getModel(): string {
        return $this->model;
    }
    function setModel($modelInput): void {
        $this->model = $modelInput;
    }
    function getPrice(): string {
        return $this->model;
    }
    function setPrice($priceInput): void {
        $this->price = $priceInput;
    }
    function getExchangeRate(): float {
        return $this->exchangeRate;
    }
    function setExchangeRate($exchangeRateInput): void {
        $this->exchangeRate = $exchangeRateInput;
    }
    function value(): float|int {
        return $this->price * $this->exchangeRate;
    }
    public function __toString() {
        return "Model: $this->model, Price: $this->price EUR, Exchange Rate: $this->exchangeRate PLN";
    }
}