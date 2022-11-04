<?php

namespace App\Model;

use PDO;

class UserManager
{
    public PDO $pdo;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    /**
     * Get all information for one user
     */
    public function getOneUser(int $id): array
    {
        $sql = "SELECT ID_user, firstname, lastname, username, birthday, country,
       email, password FROM user WHERE ID_user=:id";
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
