<?php

namespace App\Repositories;

use App\Model\ProductModel;

Class RegisterProductRepositorie {
    function __construct () {
        $this->productModel = new ProductModel;
    }
    public function registerProduct ($request) {
        if (!is_null($request->imagem)) $request->imagem = $this->trateImageToUpload($request->imagem);
        return $this->productModel->insertProduct($request);
    }
    public function updateProduct ($request) {
        if (!is_null($request->imagem)) $request->imagem = $this->trateImageToUpload($request->imagem);
        return $this->productModel->updateProduct($request);
    }
    private function trateImageToUpload ($imagem) { 
        return $imagem;
    }
}