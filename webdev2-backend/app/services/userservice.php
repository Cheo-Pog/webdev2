<?php
namespace Services;

use Repositories\UserRepository;

class UserService {

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function checkUsernamePassword($email, $password) {
        return $this->repository->checkUsernamePassword($email, $password);
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }
    public function update($item, $id) {
        $check = $this->repository->getOne($id);
        if(password_verify($item->password, $check->password)){
            $item->password = password_hash($item->password, PASSWORD_DEFAULT);
            return $this->repository->update($item, $id);        
        }
        return false;
    }
    public function updateAdmin($item, $id) {
        $item->password = password_hash($item->password, PASSWORD_DEFAULT);
        return $this->repository->update($item, $id);        
    }
    public function register($item) {
        $check = $this->repository->getByEmail($item->email);
        if($check){
            return 0;
        }
        $item->password = password_hash($item->password, PASSWORD_DEFAULT);
        return $this->repository->insert($item);        
    }
    public function delete($id) {
        return $this->repository->delete($id);        
    }
}

?>