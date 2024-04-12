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
        $decoded = $this->checkForJwt();
        if (!$decoded) {
            return;
        }
        $users = $this->service->getAll();
        $this->respond($users);
    }

    public function getOne($id)
    {
        $decoded = $this->checkForJwt();
        if (!$decoded) {
            return;
        }
        $user = $this->service->getOne($id);
        $user->password = "";
        $this->respond($user);
    }
    public function update($id)
    {
        try {
            $decoded = $this->checkForJwt();
            if (!$decoded) {
                return;
            }
            $user = $this->createObjectFromPostedJson(User::class);
            $check = $this->service->update($user, $id);
            if ($check) {
                $this->respond($user);
            } else {
                $this->respondWithError(401, "Unauthorized");
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function updateAdmin($id)
    {
        $decoded = $this->checkForJwt();
        if (!$decoded) {
            return;
        }
        $user = $this->createObjectFromPostedJson(User::class);
        $this->service->updateAdmin($user, $id);
        $this->respond($user);
    }
    public function register()
    {
        $user = $this->createObjectFromPostedJson(User::class);
        $this->service->register($user);
        $this->respond($user);
    }
    public function delete($id)
    {
        $decoded = $this->checkForJwt();
        if (!$decoded) {
            return;
        }
        $this->service->delete($id);
        $this->respond("User deleted");
    }
}
