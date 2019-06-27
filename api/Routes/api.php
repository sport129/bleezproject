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
    }

    public function routes () {
        try {
            if (!preg_match('/api/', $this->uri)) throw new Exception("URL INFORMADA ESTA ERRADA");
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
                    } else {
                        throw new Exception("URL INVALIDO");
                    }
                } else {
                    throw new Exception("URL INVALIDO");
                }
            } else if ($this->method == 'GET') {
                if ($this->middlewareroute()) {
                    
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