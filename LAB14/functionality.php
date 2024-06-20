<?php
require_once "Movie.php";

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

function addMovie(&$movies) {
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

function sortMoviesChoice($movies) {
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


function editMovie($movies) {
    $editId = $_POST['editHiddenSubmit'];

    $selectedMovieEdit = null;

    foreach ($movies as $movie) {
        if ($movie->getId() == $editId) {
            $selectedMovieEdit = $movie;
        }
    }
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