<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\Order;
use Models\OrderItems;

class OrderRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT id, user_id, total_price, order_date FROM orders";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, Order::class);
            $orders = $stmt->fetchAll();
            foreach ($orders as $order) {
                $this->getOrderItems($order);
            }

            return $orders;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function getOrderItems($order){
                $stmt = $this->connection->prepare("SELECT order_items.id, order_items.order_id, order_items.product_id, order_items.quantity, order_items.price, products.name as product_name FROM order_items INNER join products ON order_items.product_id = products.id WHERE order_items.order_id = :id");
                $stmt->bindParam(':id', $order->id);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, OrderItems::class);
                $order->order_items = $stmt->fetchAll();
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, user_id, total_price, order_date FROM orders WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, Order::class);
            $order = $stmt->fetch();
            $this->getOrderItems($order);

            return $order;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
