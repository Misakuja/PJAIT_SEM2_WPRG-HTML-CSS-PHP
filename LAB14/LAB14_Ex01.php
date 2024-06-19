<?php

//author notes: sincerely apologising for noodle code:(

class Movie {
    public int $id;
    public string $title;
    public string $director;
    public int $releaseYear;
    public string $genre;
    public float $rating;

    public function __construct($id, $title, $director, $releaseYear, $genre, $rating) {
        $this->id = $id;
        $this->title = $title;
        $this->director = $director;
        $this->releaseYear = $releaseYear;
        $this->genre = $genre;
        $this->rating = $rating;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDirector(): string {
        return $this->director;
    }

    public function getReleaseYear(): int {
        return $this->releaseYear;
    }

    public function getGenre(): string {
        return $this->genre;
    }

    public function getRating(): float {
        return $this->rating;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDirector(string $director): void {
        $this->director = $director;
    }

    public function setReleaseYear(int $releaseYear): void {
        $this->releaseYear = $releaseYear;
    }

    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    public function setRating(float $rating): void {
        $this->rating = $rating;
    }
}

function toArray(): array {
    $file = fopen("movies.csv", "r");
    if ($file !== FALSE) {
        $movies = [];
        fgetcsv($file);
        while (($data = fgetcsv($file, 1000)) !== FALSE) {
            if (count($data) == 6) {
                $nextMovie = new Movie(intval($data[0]), $data[1], $data[2], intval($data[3]), $data[4], floatval($data[5]));
                $movies[] = $nextMovie;
            } else {
                echo "Error in data format";
                fclose($file);
                return [];
            }
        }
        fclose($file);
        return $movies;
    } else {
        echo "Error in opening file";
        return [];
    }
}

function saveMovies($movies) {
    $file = fopen("movies.csv", "w");
    fputcsv($file, ["ID", "Title", "Director", 'Release Year', "Genre", "Rating"]);
    foreach ($movies as $movie) {
        fputcsv($file, [$movie->getId(), $movie->getTitle(), $movie->getDirector(), $movie->getReleaseYear(), $movie->getGenre(), $movie->getRating()]);
    }
    fclose($file);
}

function sortMovies(&$movies, $sortBy, $order) {
    usort($movies, function ($a, $b) use ($sortBy, $order) {
        if ($a->$sortBy == $b->$sortBy) {
            return 0;
        }
        if ($order === 'asc') {
            return ($a->$sortBy < $b->$sortBy) ? -1 : 1;
        } else {
            return ($a->$sortBy > $b->$sortBy) ? -1 : 1;
        }
    });
}

$movies = toArray();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $id = $_POST['addId'];
    $title = $_POST['addTitle'];
    $director = $_POST['addDirector'];
    $releaseYear = $_POST['addReleaseYear'];
    $genre = $_POST['addGenre'];
    $rating = $_POST['addRating'];

    foreach ($movies as $movie) {
        if ($movie->getId() == $id) {
            echo "Error: Duplicate ID";
            return;
        }
    }

    $newMovie = new Movie($id, $title, $director, $releaseYear, $genre, $rating);
    $movies[] = $newMovie;

    saveMovies($movies);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sort'])) {
    $selectedSort = $_POST['selectSort'];

    switch ($selectedSort) {
        case 'releaseYearAscending':
            sortMovies($movies, 'releaseYear', 'asc');
            break;
        case 'releaseYearDescending':
            sortMovies($movies, 'releaseYear', 'desc');
            break;
        case 'ratingAscending':
            sortMovies($movies, 'rating', 'asc');
            break;
        case 'ratingDescending':
            sortMovies($movies, 'rating', 'desc');
            break;
    }

    saveMovies($movies);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editSubmit'])) {
    $editId = $_POST['editHiddenSubmit'];

    $selectedMovieEdit = null;

    foreach ($movies as $movie) {
        if ($movie->getId() == $editId) {
            $selectedMovieEdit = $movie;
        }
    }

    $id = $_POST['editId'];
    $title = $_POST['editTitle'];
    $director = $_POST['editDirector'];
    $releaseYear = $_POST['editReleaseYear'];
    $genre = $_POST['editGenre'];
    $rating = $_POST['editRating'];

    $selectedMovieEdit->setTitle($title);
    $selectedMovieEdit->setDirector($director);
    $selectedMovieEdit->setReleaseYear($releaseYear);
    $selectedMovieEdit->setGenre($genre);
    $selectedMovieEdit->setRating($rating);

    saveMovies($movies);
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
