<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

class AdminManager
{

    public PDO $pdo;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }
// FEATURE GESTION USERS //
    public function getAllUsers(): array
    {
        $sql = "SELECT ID_user, username, email FROM user";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOneUser(int $id): array
    {
        $sql = "SELECT ID_user, username, email, password FROM user WHERE ID_user=:id";
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function deleteOneUser(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM user WHERE ID_user=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getAllMusics(): array 
    {
        $sql = "SELECT title, artist, image_url, song_url, genre_ID_genre FROM songs";
        $statement= $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();

    }
}
