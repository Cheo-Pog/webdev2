<?php

namespace Repositories;

use Models\Category;
use Models\Product;
use PDO;
use PDOException;
use Repositories\Repository;

class ProductRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT products.id, products.name, products.price, products.description, products.image, category.id as category_id, category.name as category_name FROM products INNER JOIN category ON products.category_id = category.id";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Product::class);

        } catch (PDOException $e) {
            echo $e;
        }
    }
    function getByCategory($categoryId, $offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT products.id, products.name, products.price, products.description, products.image, category.id as category_id, category.name as category_name FROM products INNER JOIN category ON products.category_id = category.id WHERE category.id = :category_id";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':category_id', $categoryId);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Product::class);

        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $query = "SELECT products.id, products.name, products.price, products.description, products.image, category.id as category_id ,category.name as category_name FROM products INNER JOIN category ON products.category_id = category.id WHERE products.id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, Product::class);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function insert($product)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into products (name, price, description, image, category_id) VALUES (:name, :price, :description, :image, :category_id)");

            $stmt->bindParam(':name', $product->name);
            $stmt->bindParam(':price', $product->price);
            $stmt->bindParam(':description', $product->description);
            $stmt->bindParam(':image', $product->image);
            $stmt->bindParam(':category_id', $product->category_id);
            $stmt->execute();

            $product->id = $this->connection->lastInsertId();

            return $this->getOne($product->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }


    function update($product, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE products SET name = :name, price = :price, description = :description, image = :image, category_id = :category_id WHERE id = :id");

            $stmt->bindParam(':name', $product->name);
            $stmt->bindParam(':price', $product->price);
            $stmt->bindParam(':description', $product->description);
            $stmt->bindParam(':image', $product->image);
            $stmt->bindParam(':category_id', $product->category_id);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $this->getOne($product->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
