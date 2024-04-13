<?php

namespace Controllers;

use Exception;
use Services\OrderService;

class OrderController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new OrderService();
    }

    public function getAll()
    {
        if($this->checkJWT()){return;}
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $orders = $this->service->getAll($offset, $limit);

        $this->respond($orders);
    }

    public function getOne($id)
    {
        if($this->checkJWT()){return;}
        $product = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the product is not found in the DB
        if (!$product) {
            $this->respondWithError(404, "Product not found");
            return;
        }

        $this->respond($product);
    }

}
