<?php

namespace Routes;

use App\Controller\LoginController;
use Exception;

class api {
    protected $uri;
    protected $method;
    protected $json;

    function __construct () {
        $this->uri 	= urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->json = json_decode(file_get_contents('php://input'));
        $this->loginController = new LoginController;
    }

    public function routes () {
        try {
            if (!preg_match('/api/', $this->uri)) throw new Exception("URL INFORMADA ESTA ERRADA");
            if ($this->method == 'POST') {
                if ($this->uri == "/api/login") {
                    $dadosUser = $this->loginController->onSingIn($this->json);
                    echo $dadosUser;
                } else {
                    print_r("oir");
                    throw new Exception("URL INVALIDO");
                }
            } else if ($this->method == 'GET') {

            }else {
                throw new Exception("METÓDO INVÁLIDO");
            }
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }
}