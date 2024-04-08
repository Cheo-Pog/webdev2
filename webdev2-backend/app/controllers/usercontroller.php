<?php

namespace Controllers;

use Services\UserService;

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
        $data = $this->createObjectFromPostedJson("Models\\User");
        
        $username = $data->username;
        $password = $data->password;

        // get user from db

        try{
        $user = $this->service->checkUsernamePassword($username, $password);
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
            'sub' => $user->username,
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 60 * 60, 
        ];


        // return jwt
        $jwt = JWT::encode($payload, $key, 'HS256');
        $this->respond($jwt);
    }
}
