<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

class CartRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT id, user_id, product_id, quantity FROM shoppingcarts";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Shoppingcart');
            $shoppingcarts = $stmt->fetchAll();

            return $shoppingcarts;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, user_id, product_id, quantity FROM shoppingcarts WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Shoppingcart');
            $shoppingcart = $stmt->fetch();

            return $shoppingcart;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function insert($shoppingcart)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into shoppingcarts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $stmt->bindParam(':user_id', $shoppingcart->user_id);
            $stmt->bindParam(':product_id', $shoppingcart->product_id);
            $stmt->bindParam(':quantity', $shoppingcart->quantity);
            $stmt->execute();

            $shoppingcart->id = $this->connection->lastInsertId();

            return $shoppingcart;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    function update($shoppingcart, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE shoppingcarts SET quantity = :quantity WHERE id = :id");
            $stmt->bindParam(':quantity', $shoppingcart->quantity);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $shoppingcart;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM shoppingcarts WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
