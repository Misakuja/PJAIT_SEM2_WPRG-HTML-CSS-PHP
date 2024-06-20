<?php

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