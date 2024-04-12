<?php
namespace Models;
use Models\OrderItems;

class Order {

    public int $id;
    public string $user_id;
    public string $total_price;
    public string $order_date;
    public array $order_items;

}