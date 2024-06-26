<?php

namespace Controllers;

use Exception;
use Models\User;
use Services\UserService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function login()
    {

        // get username and password from request
        $data = $this->createObjectFromPostedJson(User::class);

        $email = $data->email;
        $password = $data->password;

        if (!$email || !$password) {
            $this->respondWithError(400, "email and password are required");
            return;
        }

        // get user from db

        try {
            $user = $this->service->checkUsernamePassword($email, $password);
        } catch (Exception $e) {
            $this->respondWithError(401, $e);
        }
        // if the method returned false, the username and/or password were incorrect

        if (!$user) {
            $this->respondWithError(401, "invalid username or password");
            return;
        }

        // generate jwt

        $key = "Nekoarc";
        $payload = [
            'iss' => 'http://www.inholland.nl',
            'aud' => 'http://www.inholland.nl',
            'sub' => $user->email,
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 60 * 60,
        ];


        // return jwt
        $jwt = JWT::encode($payload, $key, 'HS256');
        $this->respond([$jwt, $user]);
    }

    public function getAll()
    {
        if($this->checkJWT()){return;}
        try {
            $users = $this->service->getAll();
            $this->respond($users);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getOne($id)
    {
        try {
            $user = $this->service->getOne($id);
            $user->password = "";
            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function update($id)
    {
        if($this->checkJWT()){return;}
        try {
            $user = $this->createObjectFromPostedJson(User::class);
            $check = $this->service->update($user, $id);
            if ($check) {
                $this->respond($user);
            } else {
                $this->respondWithError(401, "Password is incorrect");
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function updateAdmin($id)
    {
        if($this->checkJWT()){return;}
        try {
            $user = $this->createObjectFromPostedJson(User::class);
            $this->service->updateAdmin($user, $id);
            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function register()
    {
        try {
            $user = $this->createObjectFromPostedJson(User::class);
            $check = $this->service->register($user);
            if ($check == 0) {
                $this->respondWithError(401, "Email already exists");
                return;
            }
            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function delete($id)
    {
        if($this->checkJWT()){return;}
        try {
            $this->service->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
}
