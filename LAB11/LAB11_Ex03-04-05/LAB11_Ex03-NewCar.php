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

    function getAlarm(): bool {
        return $this->alarm;
    }
    function setAlarm($alarmInput): void {
        $this->alarm = $alarmInput;
    }
    function getRadio(): bool {
        return $this->radio;
    }
    function setRadio($radioInput): void {
        $this->radio = $radioInput;
    }
    function getClimatronic(): bool {
        return $this->climatronic;
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
        $alarmYesNo = $this->alarm ? 'Yes' : 'No';
        $radioYesNo = $this->radio ? 'Yes' : 'No';
        $climatronicYesNo = $this->climatronic ? 'Yes' : 'No';
        return parent::__toString() . " Alarm: $alarmYesNo, Radio: $radioYesNo, Climatronic: $climatronicYesNo";
    }
}