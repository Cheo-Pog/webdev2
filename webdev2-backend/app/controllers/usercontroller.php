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

    public function login() {

        // get username and password from request
        $data = $this->createObjectFromPostedJson(User::class);
        
        $email = $data->email;
        $password = $data->password;

        // get user from db

        try{
        $user = $this->service->checkUsernamePassword($email, $password);
        }catch(Exception $e){
            $this->respondWithError(401, $e);
        }
        // if the method returned false, the username and/or password were incorrect

        if(!$user){
            $this->respondWithError(401, "invalid username or password");
            return;
        }

        // generate jwt

        $key = 'Nekoarc';
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
        $this->respond([$jwt, $user->id, $user->firstname]);
    }

    public function logout() {
        // check for jwt
        $decoded = $this->checkForJwt();
        if(!$decoded){
            return;
        }
        // logout
        $this->respond("logged out");
    }

    public function getAll() {
        $decoded = $this->checkForJwt();
        if(!$decoded){
            return;
        }
        $users = $this->service->getAll();
        $this->respond($users);
    }

    public function getOne($id) {
        $decoded = $this->checkForJwt();
        if(!$decoded){
            return;
        }
        $user = $this->service->getOne($id);
        $this->respond($user);
    }
}
