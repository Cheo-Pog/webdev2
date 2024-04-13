<?php
namespace Services;

use Repositories\OrderRepository;

class OrderService {

    private $repository;

    function __construct()
    {
        $this->repository = new OrderRepository();
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }
}

?>