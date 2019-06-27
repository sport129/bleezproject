<?php

namespace App\Model;
use App\Database\ConnectionDB;

Class ProductModel extends ConnectionDB {
    protected $table;
    function __construct () {
        $this->table = 'tb_produtos';
    }
    public function insertProduct ($product) {
        $stmt = ConnectionDB::prepare(
			"INSERT INTO 
				$this->table (nome, preco, descricao, imagem, created_at) 
			VALUES 
				(:nome, :preco, :descricao, :imagem, :created_at)"
		);
		return $stmt->execute(
			array(
				":nome"             => $product->nome, 
				":preco"            => $product->preco, 
                ":descricao" 	    => $product->descricao,
                ":imagem"           => $product->imagem,
                ":created_at"       => date("Y-m-d H:i:s")
			)
        );
    }
    public function updateProduct ($product) {
        $stmt = ConnectionDB::prepare(
			"UPDATE
				$this->table 
            SET
                nome = :nome, preco = :preco, descricao = :descricao, imagem = :imagem
			WHERE
                id = :id"
		);
		return $stmt->execute(
			array(
                ":id"               => $product->id,
				":nome"             => $product->nome, 
				":preco"            => $product->preco, 
                ":descricao" 	    => $product->descricao,
                ":imagem"           => $product->imagem
			)
        );
    }
}