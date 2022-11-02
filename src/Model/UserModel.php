<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

class UserModel
{
    public PDO $pdo;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getOneUser(int $id): array
    {
        $sql = "SELECT ID_user, firstname, lastname, username, birthday, country,
       email, password FROM user WHERE ID_user=:id";
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function update(array $user): bool
    {
        $query = 'UPDATE user SET firstname = :firstname, lastname = :lastname, username = :username,
                birthday = :birthday, country = :country, password = :password WHERE ID_user=:id';
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $user['ID_user'], PDO::PARAM_INT);
        $statement->bindValue(':firstname', $user['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $user['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':username', $user['username'], PDO::PARAM_STR);
        $statement->bindValue(':birthday', $user['birthday'], PDO::PARAM_STR);
        $statement->bindValue(':country', $user['country'], PDO::PARAM_STR);
        $statement->bindValue(':password', $user['password'], PDO::PARAM_STR);

        return $statement->execute();
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM user WHERE ID_user=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM user WHERE email = :email and password = :password";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', $password, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch();
    }
}
