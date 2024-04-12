<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\ShoppingCart;
use Models\Product;

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

            $stmt->setFetchMode(PDO::FETCH_CLASS, ShoppingCart::class);
            $shoppingcarts = $stmt->fetchAll();

            return $shoppingcarts;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, user_id, product_id, quantity FROM shoppingcarts WHERE user_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, ShoppingCart::class);
            $shoppingcart = $stmt->fetchAll();

            foreach ($shoppingcart as $item) {
                $stmt = $this->connection->prepare("SELECT id, name, price, description, image FROM products WHERE id = :id");
                $stmt->bindParam(':id', $item->product_id);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, Product::class);
                $item->product = $stmt->fetch();
            }

            return $shoppingcart;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function checkDuplicate($item)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, user_id, product_id, quantity FROM shoppingcarts WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':user_id', $item->user_id);
            $stmt->bindParam(':product_id', $item->product_id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, ShoppingCart::class);
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch();
            }

            return null;
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

    function delete($shoppingcart, $total_price)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO orders (user_id, total_price) value (:user_id, :total_price)");
            $stmt->bindParam(':user_id', $shoppingcart[0]->user_id);
            $stmt->bindParam(':total_price', $total_price);
            $stmt->execute();
    
            $orderId = $this->connection->lastInsertId();
    
            foreach ($shoppingcart as $item) {
                $stmt = $this->connection->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                $stmt->bindParam(':order_id', $orderId);
                $stmt->bindParam(':product_id', $item->product_id);
                $stmt->bindParam(':quantity', $item->quantity);
                $stmt->bindParam(':price', $item->product->price);
                $stmt->execute();
    
                $stmt = $this->connection->prepare("DELETE FROM shoppingcarts WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $item->user_id);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
