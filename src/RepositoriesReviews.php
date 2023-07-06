<?php

namespace src;
use \PDO;

class RepositoriesReviews
{
    public $pdo;

    public function __construct($dbFile) {
        // Инициализация соединения с базой данных SQLite
        $this->pdo = new PDO("sqlite:$dbFile");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function SearchReview($id){
        $query = "SELECT * FROM reviews WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getReviewsByPage($page, $perPage)
    {
        $offset = ($page) * $perPage;
        $query = "SELECT * FROM reviews ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reviews;
    }

}