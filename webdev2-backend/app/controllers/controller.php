<?php

namespace Controllers;

use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Services\ProductService;

class Controller
{
    function checkForJwt()
    {
        // Check for token header
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->respondWithError(401, "No token provided");
            return null;
        }

        // Read JWT from header
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        // Strip the part "Bearer " from the header
        $arr = explode(" ", $authHeader);
        $jwt = $arr[1];

        // Decode JWT
        $secret_key = "Nekoarc";

        if ($jwt) {
            try {
                // Decode the JWT, passing $headers by reference
                $decoded = JWT::decode($jwt, new KEY($secret_key, 'HS256'));
                return $decoded;
            } catch (Exception $e) {
                $this->respondWithError(401, $e->getMessage());
                return null;
            }
        }
    }
    public function upload()
    {
        $url = $_SERVER['HTTP_HOST'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDirectory = '/app/public/uploads/';
            $path = 'http://' . $url . '/uploads/';

            $fileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $targetPath = $uploadDirectory . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Return the uploaded image path
                $this->respond($path . $fileName);
            } else {
                $this->respondWithError(401, "Error uploading file.");
                return;
            }
        } else {
            $this->respondWithError(404, "No file uploaded or file upload error occurred.");
        }
    }
    public function removeImage($fileName)
    {
        $uploadDirectory = '/app/public/uploads/';

        $filePath = $uploadDirectory . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath);
            $productService = new ProductService();
            $productService->removeImage('http://localhost/uploads/' . $fileName);

            $this->respond("File deleted successfully.");
        } else {
            $this->respondWithError(404, "File not found.");
        }
    }

    function checkJWT()
    {
        $decoded = $this->checkForJwt();
        if (!$decoded) {
            $this->respondWithError(401, "Unauthorized");
            return true;
        }
    }

    function respond($data)
    {
        $this->respondWithCode(200, $data);
    }

    function respondWithError($httpcode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpcode, $data);
    }

    private function respondWithCode($httpcode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpcode);
        echo json_encode($data);
    }

    function createObjectFromPostedJson($className)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $object = new $className();
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                continue;
            }
            $object->{$key} = htmlspecialchars($value);
        }
        return $object;
    }
}
