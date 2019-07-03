<?php

namespace App\Controller;

use App\Libries\jsonResponse;
use App\Repositories\RegisterUserRepositories;
use Exception;

class RegisterUserController {
    function __construct () {
        $this->jsonResponse         = new jsonResponse;
        $this->registerRepositories = new RegisterUserRepositories;
    }
    public function registerUser ($request) {
        try {
            if ($this->validatorRegister($request)) throw new Exception("Dados Inválidos");
            
            $response = $this->registerRepositories->createUser($request);
            
            if ($response->status) throw new Exception($response->message);
            
            return $this->jsonResponse->constructResponseJson(200, 200, $response->message);
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());
        }   
        
    }
    private function validatorRegister ($request) {
        if ($request->username == '' || $request->password == '' || $request->email == '') return true;
        return false;
    }
}