<?php

class InsuranceCar extends NewCar {
    private string $firstOwner;
    private int $years;

    function __construct($model, $price, $exchangeRate, $alarm, $radio, $climatronic, $firstOwner, $years) {
        parent::__construct($model, $price, $exchangeRate, $alarm, $radio, $climatronic);
        $this->firstOwner = $firstOwner;
        $this->years = $years;
    }

    function getFirstOwner(): string {
        return $this->firstOwner;
    }

    function setFirstOwner($ownerInput): void {
        $this->firstOwner = $ownerInput;
    }

    function getYears(): string {
        return $this->years;
    }

    function setYears($yearsInput): void {
        $this->years = $yearsInput;
    }

    function value(): float|int {
        $baseCarValue = parent::value();
        $baseCarValue -= 0.1*($baseCarValue*$this->years);
        if ($this->firstOwner) $baseCarValue -= 0.5*$baseCarValue;
        return $baseCarValue;
    }
}
