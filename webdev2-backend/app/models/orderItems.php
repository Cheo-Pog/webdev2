<?php
namespace Models;

class OrderItems {

    public int $id;
    public string $order_id;
    public string $product_id;
    public string $product_name;
    public string $quantity;
    public string $price;

}