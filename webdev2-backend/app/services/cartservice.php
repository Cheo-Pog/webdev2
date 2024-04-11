<?php
namespace Services;

use Repositories\CartRepository;

class CartService {

    private $repository;

    function __construct()
    {
        $this->repository = new CartRepository();
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function insert($item) {
        $check = $this->repository->checkDuplicate($item);
        if (isset($check)) {
            $item->quantity = $item->quantity + $check->quantity;
            return $this->repository->update($item, $check->id);
        }
        return $this->repository->insert($item);        
    }

    public function update($item, $id) {       
        return $this->repository->update($item, $id);        
    }

    public function delete($item) {       
        return $this->repository->delete($item);        
    }
}

?>