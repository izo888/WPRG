<?php

class Movie
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT movies.*, categories.name AS category_name
                FROM movies
                LEFT JOIN categories ON movies.category_id = categories.id
                ORDER BY movies.created_at DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function search($keyword)
{
    $sql = "SELECT movies.*, categories.name AS category_name
            FROM movies
            LEFT JOIN categories ON movies.category_id = categories.id
            WHERE movies.title LIKE :keyword
               OR movies.director LIKE :keyword
               OR categories.name LIKE :keyword
            ORDER BY movies.created_at DESC";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        'keyword' => '%' . $keyword . '%'
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getById($id)
    {
        $sql = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $director, $releaseYear, $description, $categoryId, $poster)
    {
        $sql = "INSERT INTO movies (title, director, release_year, description, category_id, poster)
                VALUES (:title, :director, :release_year, :description, :category_id, :poster)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'title' => $title,
            'director' => $director,
            'release_year' => $releaseYear,
            'description' => $description,
            'category_id' => $categoryId,
            'poster' => $poster
        ]);
    }

    public function update($id, $title, $director, $releaseYear, $description, $categoryId, $poster)
    {
        $sql = "UPDATE movies
                SET title = :title,
                    director = :director,
                    release_year = :release_year,
                    description = :description,
                    category_id = :category_id,
                    poster = :poster
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'director' => $director,
            'release_year' => $releaseYear,
            'description' => $description,
            'category_id' => $categoryId,
            'poster' => $poster
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM movies WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }
    public function countAll()
{
    $sql = "SELECT COUNT(*) AS total FROM movies";
    $stmt = $this->pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}

public function getLatest()
{
    $sql = "SELECT movies.*, categories.name AS category_name
            FROM movies
            LEFT JOIN categories ON movies.category_id = categories.id
            ORDER BY movies.created_at DESC
            LIMIT 1";

    $stmt = $this->pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}