<?php
function reviewsReset() : void{
    file_put_contents("LAB09_Ex04.txt", "");
}
function deleteReview() : void {
    $reviews = file("LAB09_Ex04.txt");
    unset($reviews[$_POST["index"]]);

    file_put_contents("LAB09_Ex04.txt", implode("", $reviews));
}
function addReview() : void {
    $reviewInput = $_POST["reviewInput"];
    $date = date("d-m-Y");
    $file = "LAB09_Ex04.txt";

    file_put_contents($file, $date . " | " . $reviewInput . "\n", FILE_APPEND);
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
    <link href="LAB09_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="formResult">
    <h1>Review Manager</h1>
    <div class="form">
    <form method='post' action="">
        <fieldset>
            <legend>Add Review</legend>
            <div class=formWrap>
                <label for='reviewInput'></label>
                <input type='text' id='reviewInput' name='reviewInput' placeholder="Write your review here." required>

                <button type='submit' name="addReview">Add a Review</button>
            </div>
        </fieldset>
    </form>
    </div>
    <div class="reviews">
        <h1>Reviews:</h1>
        <?php
            if(file_exists("LAB09_Ex04.txt")) {
                $reviewsArray = file("LAB09_Ex04.txt");
                foreach($reviewsArray as $index => $review) {
                    echo "<div class='border'>$review
                    <form action='' method='post'>
                    <input type='hidden' name='index' value='$index'>
                    <input type='submit' name='delete' value='Delete'>
                    </form>
                    </div><br>";
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