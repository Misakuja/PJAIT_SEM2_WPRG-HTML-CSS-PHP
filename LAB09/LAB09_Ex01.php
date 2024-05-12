<?php
function countBytes($fd) : float {
    $size = 0;
    if (is_file($fd)) {
        $size = filesize($fd);
    } else if (is_dir($fd)) {
        $files = scandir($fd);
        $files = array_diff($files, array('.', '..'));

        foreach($files as $file) {
            $filePath = $fd . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath)) {
                $size += filesize($filePath);
            }
        }
    }
    return $size;
}
function formatBytes($bytes) : float {
    $format = sprintf("%.8f", $bytes);
    $format = rtrim($format, "0");
    return rtrim($format, ".");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Size of File/Directory</title>
    <link href="LAB09_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="box">
    <form method='post' action="">
        <fieldset>
            <legend>Input the file or directory name</legend>
            <div class=formWrap>
                <label for='inputText'></label>
                <input type='text' id='inputText' name='inputText' required>

                <button type='submit'>Send</button>
            </div>
        </fieldset>
    </form>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["inputText"])) {
            $fd = $_POST["inputText"];
            if (file_exists($fd)) {
                echo "<p>Results:</p>";
                echo "<ul>";
                echo "<li>Bytes: " . formatBytes(countBytes($fd)) . "B</li>";
                echo "<li>Megabytes: " . formatBytes(countBytes($fd) / (1024 * 1024)) . "MB</li>";
                echo "<li>Gigabytes: " . formatBytes(countBytes($fd) / (1024 * 1024 * 1024)) . "GB</li>";
                echo "</ul>";
            } else echo "<p>Wrong Input.</p>";
        }
    }
?>
</div>
</body>
</html>
