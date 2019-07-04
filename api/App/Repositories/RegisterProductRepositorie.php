<?php

namespace App\Repositories;

use App\Model\ProductModel;

Class RegisterProductRepositorie {
    function __construct () {
        $this->productModel = new ProductModel;
    }
    public function registerProduct ($request) {
        return $this->productModel->insertProduct($request);
    }
    public function updateProduct ($request) {
        return $this->productModel->updateProduct($request);
    }
    public function getAllProducts () {
        $produtos = $this->productModel->getProducts();
        for ($i = 0; $i < count($produtos); $i++){ 
            $produtos[$i]->created_at = date("d/m/Y H:i:s", strtotime($produtos[$i]->created_at));
        }
        return $produtos;
    }
    public function consultProduct ($request) {
        return $this->productModel->consultProduct($request);
    }
    public function getImagesProduct ($request) {
        $imagens = $this->productModel->consultImageProduct($request);
        for ($i = 0; $i < count($imagens); $i++){
            $imagens[$i]->linkimg = 'http://'.$_SERVER['HTTP_HOST'].'/public/img/'.$imagens[$i]->linkimg;
        }
        return $imagens; 
    }
    public function deletarProduto ($request) {
        return $this->productModel->deletarProduto($request);
    }
    public function insertimage ($idproduct, $linkimage) {
        return $this->productModel->insertimage($idproduct, $linkimage);
    }
}