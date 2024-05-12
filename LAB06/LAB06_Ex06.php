<?php
echo "<ul>";
for ($i = 1; $i <= 20; $i++) {
    if ($i % 2 == 0) {
        echo "<li>$i</li>";
    }
}
echo "</ul>";