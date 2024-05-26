<?php
class NewCar extends Car {
    private bool $alarm;
    private bool $radio;
    private bool $climatronic;
    public function __construct($model, $price, $exchangeRate, $alarm, $radio, $climatronic) {
        parent::__construct($model, $price, $exchangeRate);
        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->climatronic = $climatronic;
    }

    function getAlarm(): string {
        return $this->alarm ? 'Yes' : 'No';
    }
    function setAlarm($alarmInput): void {
        $this->alarm = $alarmInput;
    }
    function getRadio(): string {
        return $this->radio ? 'Yes' : 'No';
    }
    function setRadio($radioInput): void {
        $this->radio = $radioInput;
    }
    function getClimatronic(): string {
        return $this->climatronic ? 'Yes' : 'No';
    }
    function setClimatronic($climatronicInput): void {
        $this->climatronic = $climatronicInput;
    }
    function value(): float|int {
        $baseCarValue = parent::value();
        if ($this->alarm) $baseCarValue *= 1.05;
        if ($this->radio) $baseCarValue *= 1.075;
        if ($this->climatronic) $baseCarValue *= 1.1;
        return $baseCarValue;
    }
    function __toString() {
        return parent::__toString() . " Alarm: " . $this->getAlarm() . ", Radio: "  . $this->getRadio() . ", Climatronic: " . $this->getClimatronic();
    }
}