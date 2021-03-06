<?php

namespace App\Controller;

use Exception;
use App\Libries\jsonResponse;
use App\Repositories\RegisterProductRepositorie;

Class RegisterNewProductController {
    function __construct () {
        $this->jsonResponse                  = new jsonResponse;
        $this->registerProductRepositories   = new RegisterProductRepositorie;
    }
    public function inputImage ($temp, $localstorage, $request) {
        try {
            $produto = json_decode($request->scalar);

            if (move_uploaded_file($temp, "public/img/".$localstorage)) {
                
                $response = $this->registerProductRepositories->insertimage($produto->produto->id, $localstorage);
                
                if ($response) {
                    return $this->jsonResponse->constructResponseJson(200, 200, 'Imagem Cadastrada com Sucesso', $response);
                } else {
                    throw new Exception("Não foi Possível cadastrar imagem");
                
                }
            } else {
                throw new Exception("Não foi Possível cadastrar imagem");  
            }   

        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());
        }
    }
    public function getImagesProduct ($request) {
        try {
            $response = $this->registerProductRepositories->getImagesProduct($request);

            if ($response) {
                return $this->jsonResponse->constructResponseJson(200, 200, 'Imagens Consultadas Com Sucesso', $response);
            } else {
                throw new Exception("Sem Imagens Cadastradas");
            }

        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());
        }
    }
    public function registerNewProduct ($request) {
        try {
            $validador = $this->validatorProduct($request);

            if ($validador) throw new Exception("Parametros Inválidos");

            $response = $this->registerProductRepositories->registerProduct($request);

            if ($response) {
                return $this->jsonResponse->constructResponseJson(200, 200, 'Produto Cadastrado Com Sucesso');
            } else {
                throw new Exception("Não Foi Possível Realizar o Cadastro do Produto");
            }

        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage()); 
        }
    }
    public function updateProduct ($request) {
        try {
            $validador = $this->validatorProduct($request);

            if ($validador) throw new Exception("Parametros Inválidos");

            $response = $this->registerProductRepositories->updateProduct($request);

            if ($response) {
                return $this->jsonResponse->constructResponseJson(200, 200, 'Produto Atualizado Com Sucesso');
            } else {
                throw new Exception("Não Foi Possível Realizar a Atualização do Produto");
            }

        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());  
        }
    }
    public function getProducts () {
        try {
            $response = $this->registerProductRepositories->getAllProducts();

            if (empty($response)) throw new Exception("Não Foi Possível Realizar a Consulta");

            return $this->jsonResponse->constructResponseJson(200, 200, 'Listagem Consultada com Sucesso', $response);
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage()); 
        }
    }
    public function consultProduct ($request) {
        try {
            $response =  $this->registerProductRepositories->consultProduct($request);

            if (empty($response)) throw new Exception("Não Foi Possível Realizar a Consulta");

            return $this->jsonResponse->constructResponseJson(200, 200, 'Produto Consultado com Sucesso', $response);
        }catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage()); 
        }
    }
    public function deletarProduto ($request) {
        try {
            $response =  $this->registerProductRepositories->deletarProduto($request);

            if (empty($response)) throw new Exception("Não Foi Possível Deletar o Produto");
            
            return $this->jsonResponse->constructResponseJson(200, 200, 'Produto Apagado Com Sucesso', $response);
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage()); 
        }
    }
    private function validatorProduct ($request) {
        if ($request->nome == '' || $request->preco == '') return true;
        return false;
    }
}