<?php

namespace App\Model;

use PDO;

class UserManager extends Connection
{
    /**
     * Insert new user in database
     */
    public function insert(array $user): void
    {
        $query = "INSERT INTO user (`username`,`email`,`password`) VALUES (:username, :email, :password)";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':username', $user['username'], PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', $user['password'], PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Get all information for one user
     */
    public function getOneUser(int $id): array
    {
        $sql = "SELECT ID_user, firstname, lastname, username, birthday, country,
       email, password, role FROM user WHERE ID_user=:id";
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Get email + password to verify in database
     */
    public function login($email, $password)
    {
        $sql = "SELECT * FROM user WHERE email = :email and password = :password";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', $password, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Update new information for user
     */
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

    /**
     * Delete user from database
     */
    public function delete($id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM user WHERE ID_user=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
