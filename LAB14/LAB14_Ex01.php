<?php
require_once 'functionality.php';
require_once 'Movie.php';

$movies = toArray();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) addMovie($movies);
    if (isset($_POST['sort'])) sortMoviesChoice($movies);
    if (isset($_POST['editSubmit'])) editMovie($movies);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie List</title>
    <link href="LAB14_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php if (!empty($movies)) : ?>
<h1>MOVIES DATABASE</h1>
<div id="tableForms">
    <table id="moviesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Director</th>
            <th>Release Year</th>
            <th>Genre</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($movies as $movie) : ?>
            <tr>
                <td><?= $movie->getId(); ?></td>
                <td><?= $movie->getTitle(); ?></td>
                <td><?= $movie->getDirector(); ?></td>
                <td><?= $movie->getReleaseYear(); ?></td>
                <td><?= $movie->getGenre(); ?></td>
                <td><?= $movie->getRating(); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="editChosenMovie" value="<?= $movie->getId(); ?>">
                        <button type="submit" name="editButton" value="<?= $movie->getId(); ?>">Edit</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="formsPage">
        <form method="post" class="formBox">
            <label for="selectSort">Sort by:</label>
            <select id="selectSort" name="selectSort">
                <option value="releaseYearAscending">Ascending - Release Year</option>
                <option value="releaseYearDescending">Descending - Release Year</option>
                <option value="ratingAscending">Ascending - Rating</option>
                <option value="ratingDescending">Descending - Rating</option>
            </select>
            <button type="submit" name="sort">Sort</button>
        </form>
        <?php endif; ?>
        <form method="post" class="formBox">
            <fieldset>
                <legend>Add new Movie</legend>
                <label for="addId">ID:</label>
                <input type="number" id="addId" name="addId" required>

                <label for="addTitle">Title:</label>
                <input type="text" id="addTitle" name="addTitle" required>

                <label for="addDirector">Director:</label>
                <input type="text" id="addDirector" name="addDirector" required>

                <label for="addReleaseYear">Release Year:</label>
                <input type="number" id="addReleaseYear" name="addReleaseYear" required>

                <label for="addGenre">Genre:</label>
                <input type="text" id="addGenre" name="addGenre" required>

                <label for="addRating">Rating:</label>
                <input type="number" step="0.1" id="addRating" name="addRating" required>

                <button type="submit" name="add">Add</button>
            </fieldset>
        </form>
        <?php if (isset($_POST['editButton'])) :
            $editId = $_POST['editChosenMovie'];

            $selectedMovie = null;

            foreach ($movies as $movie) {
                if ($movie->getId() == $editId) {
                    $selectedMovie = $movie;
                }
            }
            ?>
            <form method="post" class="formBox">
                <fieldset>
                    <legend>Edit Movie</legend>
                    <label for="editTitle">Title:</label>
                    <input type="text" id="editTitle" name="editTitle" value="<?= $selectedMovie->getTitle() ?>"
                           required>

                    <label for="editDirector">Director:</label>
                    <input type="text" id="editDirector" name="editDirector"
                           value="<?= $selectedMovie->getDirector() ?>"
                           required>

                    <label for="editReleaseYear">Release Year:</label>
                    <input type="number" id="editReleaseYear" name="editReleaseYear"
                           value="<?= $selectedMovie->getReleaseYear() ?>" required>

                    <label for="editGenre">Genre:</label>
                    <input type="text" id="editGenre" name="editGenre" value="<?= $selectedMovie->getGenre() ?>"
                           required>

                    <label for="editRating">Rating:</label>
                    <input type="number" step="0.1" id="editRating" name="editRating"
                           value="<?= $selectedMovie->getRating() ?>" required>

                    <button type="submit" name="editSubmit" value="<?= $editId ?>">Edit</button>
                    <input type="hidden" name="editHiddenSubmit" value="<?= $editId ?>">
                </fieldset>
            </form>
        <?php endif ?>
    </div>
</div>
</body>
</html>
