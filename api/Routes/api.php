<?php

namespace Routes;

use App\Controller\LoginController;
use App\Controller\RegisterUserController;
use App\Controller\RegisterNewProductController;
use App\Middleware\Middleware;
use Exception;

class api {
    protected $uri;
    protected $method;
    protected $json;

    function __construct () {
        $this->uri 	                        = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->method                       = $_SERVER['REQUEST_METHOD'];
        $this->json                         = json_decode(file_get_contents('php://input'));
        $this->loginController              = new LoginController;
        $this->registerController           = new RegisterUserController;
        $this->middleware                   = new Middleware;
        $this->registerNewProductController = new RegisterNewProductController;
        header("Access-Control-Allow-Origin: *");
    }

    public function routes () {
        try {
            if (!preg_match('/api/', $this->uri)) throw new Exception("URL INFORMADA ESTA ERRADA");
            $this->permissionSession();
            if ($this->method == 'POST') {
                if ($this->uri == "/api/login") {
                    $dadosUser = $this->loginController->onSingIn($this->json);
                    echo $dadosUser;
                } else if ($this->uri == "/api/registerUser") {
                    echo $this->registerController->registerUser($this->json);
                } else if ($this->middlewareroute()) {
                    if ($this->uri == "/api/registerProduct"){
                        echo $this->registerNewProductController->registerNewProduct($this->json);
                    } else if ($this->uri == "/api/updateProduct") {
                        echo $this->registerNewProductController->updateProduct($this->json);
                    } else if ($this->uri == "/api/consultProduct") {
                        echo $this->registerNewProductController->consultProduct($this->json);
                    } else if ($this->uri == "/api/delProduct") { 
                        echo $this->registerNewProductController->deletarProduto($this->json);
                    } else if ($this->uri == "/api/testeUpload") {
                        header('Access-Control-Allow-Origin: *');
                        echo $this->registerNewProductController->inputImage($_FILES["file"]["tmp_name"], "public/img/".$_FILES['file']['name'], $_REQUEST["dados"]);
                    }else {
                        throw new Exception("URL INVALIDO");
                    }
                } else {
                    throw new Exception("URL INVALIDO");
                }
            } else if ($this->method == 'GET') {
                if ($this->middlewareroute()) {
                    if ($this->uri == "/api/getProducts") {
                        echo $this->registerNewProductController->getProducts();
                    } else {
                        throw new Exception("URL INVALIDO");
                    }
                } else {
                    throw new Exception("URL INVALIDO");
                }
            }else {
                throw new Exception("METÓDO INVÁLIDO");
            }
        }catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
    private function permissionSession () {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
            exit(0);
        }
    }
    private function middlewareroute () {
        if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'])) { 
            return false;
        } else { 
            $verifyToken = $this->middleware->verifyTokenValidate($_SERVER['HTTP_AUTHORIZATION']);
            if ($verifyToken) { 
                return true;
            } else {
                return false;
            }
        }
    } 
}