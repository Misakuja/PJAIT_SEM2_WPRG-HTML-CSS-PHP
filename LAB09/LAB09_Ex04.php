<?php
function reviewsReset() {
    file_put_contents("LAB09_Ex04.txt", "");
}
function deleteReview() {
    $reviews = file("LAB09_Ex04.txt");
    unset($reviews[$_POST["index"]]);

    file_put_contents("LAB09_Ex04.txt", implode("", $reviews));
}
function addReview() {
    $reviewInput = $_POST["reviewInput"];
    $date = date("d-m-Y");
    $file = "LAB09_Ex04.txt";

    file_put_contents($file, $date . "\n" . $reviewInput, FILE_APPEND);
}
if(isset($_POST["delete"]) && isset($_POST["index"])) {
    deleteReview();
}

if(isset($_POST["addReview"]) && isset($_POST["reviewInput"])) {
    addReview();
}

if(isset($_POST["reset"])) {
    reviewsReset();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviews Manager</title>
    <link href="LAB09_Ex03.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="box">
    <form method='post' action="">
        <fieldset>
            <legend>Managing Reviews</legend>
            <div class=formWrap>
                <label for='reviewInput'></label>
                <input type='text' id='reviewInput' name='reviewInput' placeholder="Write your review here." required>

                <button type='submit' name="addReview">Add a Review</button>
            </div>
        </fieldset>
    </form>
    <div class="reviews">
        <h1>Reviews:</h1>
        <?php
            if(file_exists("LAB09_Ex04.txt")) {
                $reviewsArray = file("LAB09_Ex04.txt");
                foreach($reviewsArray as $index => $review) {
                    echo "<div>$review<form action='' method='post'><input type='hidden' name='index' value='$index'><input type='submit' name='delete' value='Delete'></form></div><br>";
                }
            }
        ?>
        <form action="" method="post">
            <button type='submit' name="reset">Reset Reviews</button>
        </form>
    </div>
</div>
</body>
</html>