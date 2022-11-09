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

    
}
