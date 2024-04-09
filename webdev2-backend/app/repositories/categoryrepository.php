<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

class CategoryRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT id, name FROM category";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Category');
            $Categories = $stmt->fetchAll();

            return $Categories;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, name FROM category WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Category');
            $category = $stmt->fetch();

            return $category;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function insert($category)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into category (name) VALUES (:name)");

            $stmt->bindParam(':name', $category->name);
            $stmt->execute();

            $category->id = $this->connection->lastInsertId();

            return $category;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    function update($category, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE category SET name = :name WHERE id = :id");

            $stmt->bindParam(':name', $category->name);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $category;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM category WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            return;
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
