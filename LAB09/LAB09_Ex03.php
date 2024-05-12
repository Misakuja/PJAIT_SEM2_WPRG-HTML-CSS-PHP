<?php
function showAge($dob): void
{
    $timeNow = time();

    if ($dob > $timeNow) {
        throw new Exception("Wrong input date.");
    } else {
        $diff = abs($timeNow - $dob);
        $ageYears = floor($diff / (365.25 * 24 * 60 * 60));
        $ageMonths = floor(($diff % (365.25 * 24 * 60 * 60)) / (30.44 * 24 * 60 * 60));
        $ageDays = floor(($diff % (365.25 * 24 * 60 * 60)) % (30.44 * 24 * 60 * 60) / (24 * 60 * 60));

        echo "<p>Current Age: " . $ageYears . " years " . $ageMonths . " months " . $ageDays . " days</p>";
    }
}

function timezoneShow($timezone): void
{
    date_default_timezone_set($timezone);
    $currentDateTime = date("d-m-Y H:i:s");
    echo "<p>Current date and time: " . $currentDateTime . " in " . $timezone;
}

function calculateWorkDays($startDate, $endDate): int
{
    if ($startDate > $endDate) {
        throw new Exception("Wrong input date.");
    }
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($startDate, $interval, $endDate);
    $workdays = 0;

    foreach ($period as $date) {
        if ($date->format('N') < 6) {
            $workdays++;
        }
    }
    return $workdays;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Age, Timezone & Work days</title>
    <link href="LAB09_Ex03.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="formResults">
    <div class="box">
        <div class="box1">
            <form method='post' action="">
                <fieldset>
                    <legend>Calculate age and local time</legend>
                    <div class=formWrap>
                        <label for='ageCalc'></label>
                        <input type='text' id='ageCalc' name='ageCalc' placeholder="Date of Birth (dd-mm-yyyy)"
                               required>

                        <label for='timezone'></label>
                        <select id='timezone' name='timezone' required>
                            <option value="selectTimezone" disabled selected>Select Timezone</option>
                            <?php
                            $timezoneList = DateTimeZone::listIdentifiers();

                            foreach ($timezoneList as $timezone) {
                                echo "<option value=\"$timezone\">$timezone</option>";
                            }
                            ?>
                        </select>
                        <button type='submit'>Submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="box2">
            <form method='post' action="">
                <fieldset>
                    <legend>Calculate work days</legend>
                    <div class=formWrap>
                        <label for='startDate'></label>
                        <input type='text' id='startDate' name='startDate' placeholder="Start date (dd-mm-yyyy)"
                               required>
                        <label for='endDate'></label>
                        <input type='text' id='endDate' name='endDate' placeholder="End date (dd-mm-yyyy)" required>

                        <button type='submit'>Submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo '<div class="result">';
                try {
                    if (isset($_POST['ageCalc']) && isset($_POST['timezone'])) {
                        showAge(strtotime($_POST['ageCalc']));
                        timezoneShow($_POST['timezone']);
                    }
                    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
                        $startDate = $_POST['startDate'];
                        $endDate = $_POST['endDate'];
                        echo "<p>Amount of work days between " . $startDate . " and " . $endDate . ": " . calculateWorkDays(new DateTime($startDate), new DateTime($endDate)) . "</p>";
                    }
                } catch (Exception $e) {
                    echo "<p>" . $e->getMessage() . "</p>";
                }
            }
            echo "</div>";
            ?>
    </div>
</div>
</body>
</html>