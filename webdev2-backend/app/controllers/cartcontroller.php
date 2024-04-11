<?php

namespace Controllers;
use Models\ShoppingCart;
use Services\CartService;

use Exception;

class CartController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new CartService();
    }

    public function getAll()
    {
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $shoppingcart = $this->service->getAll($offset, $limit);

        $this->respond($shoppingcart);
    }

    public function getOne($id)
    {
        $shoppingcart = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the product is not found in the DB
        if (!$shoppingcart) {
            $this->respondWithError(404, "Shoppingcart not found");
            return;
        }

        $this->respond($shoppingcart);
    }

    public function create()
    {
        try {
            $shoppingcart = $this->createObjectFromPostedJson(ShoppingCart::class);
            $this->service->insert($shoppingcart);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($shoppingcart);
    }

    public function update($id)
    {
        try {
            $shoppingcart = $this->createObjectFromPostedJson("Models\\shoppingcart");
            $this->service->update($shoppingcart, $id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($shoppingcart);
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
