<?php
namespace Models;
use Models\Product;

class ShoppingCart {

    public int $id;
    public int $user_id;
    public int $product_id;
    public int $quantity;
    public float $total_price;
    public Product $product;
}