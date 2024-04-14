<?php
namespace Services;

use Repositories\ProductRepository;

class ProductService {

    private $repository;

    function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAll($offset, $limit);
    }
    public function GetByCategory($categoryId, $offset = NULL, $limit = NULL) {
        return $this->repository->GetByCategory($categoryId, $offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function insert($item) {       
        return $this->repository->insert($item);        
    }

    public function update($item, $id) {       
        return $this->repository->update($item, $id);        
    }

    public function delete($item) {       
        return $this->repository->delete($item);        
    }
    public function removeImage($item) {       
        return $this->repository->removeImage($item);        
    }
}

?>