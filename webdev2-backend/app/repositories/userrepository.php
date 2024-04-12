<?php

namespace Repositories;

use PDO;
use PDOException;
use Models\User;
use Repositories\Repository;

class UserRepository extends Repository
{
    function checkUsernamePassword($email, $password)
    {
        try {
            // retrieve the user with the given username
            $stmt = $this->connection->prepare("SELECT id, firstname, lastname, password, rank, email FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();

            if (!$user)
                return false;
            // verify if the password matches the hash in the database
            if(!$this->verifyPassword($password, $user->password))
                return false;
            // do not pass the password hash to the caller
            $user->password = "";

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT id, firstname, lastname, email, rank FROM users";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);

        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $query = "SELECT id, firstname, lastname, email, password, rank FROM users WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function update($user, $id){
        try {
            $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, rank = :rank WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':firstname', $user->firstname);
            $stmt->bindParam(':lastname', $user->lastname);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->bindParam(':rank', $user->rank);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function insert($user){
        try {
            $query = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':firstname', $user->firstname);
            $stmt->bindParam(':lastname', $user->lastname);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->execute();
            return $this->getOne($this->connection->lastInsertId());
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function delete($id){
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    // hash the password (currently uses bcrypt)
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // verify the password hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }
}
