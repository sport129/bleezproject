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
				$this->table (nome, preco, descricao, created_at) 
			VALUES 
				(:nome, :preco, :descricao, :created_at)"
		);
		return $stmt->execute(
			array(
				":nome"             => $product->nome, 
				":preco"            => $product->preco, 
                ":descricao" 	    => $product->descricao,
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
    public function consultImageProduct ($product) {
        $stmt = ConnectionDB::prepare(
            "SELECT * FROM 
                tb_imgproduct
            WHERE
                tb_imgproduct.id_produto = :id
            AND status = 1" 
        );
        $stmt->execute(
            array(
                ":id" => $product->id
            )
        );
        return $stmt->fetchAll();
    }
    public function getProducts () {
        $stmt = ConnectionDB::prepare("SELECT * FROM $this->table WHERE  status = 1 ORDER BY id DESC ");
        $stmt->execute();
		return $stmt->fetchAll();
    }
    public function consultProduct ($product) {
        $stmt = ConnectionDB::prepare(
            "SELECT * FROM
                $this->table
            WHERE
                id = :id"
        );
        $stmt->execute(array(":id" => $product->id));
        return $stmt->fetch();
    }   
    public function deletarProduto ($produto) {
        $stmt = ConnectionDB::prepare(
        "UPDATE  
				$this->table 
            SET
                status = 0
			WHERE 
				id = :id"
        );
        $this->deletImageProduct ($produto);
        return $stmt->execute(array(":id" => $produto->id)); 
    }
    public function deletImageProduct ($produto) {
        $stmt = ConnectionDB::prepare( 
            "UPDATE 
                tb_imgproduct
            SET
                status = 0
            WHERE
                id_produto = :id"
        );
        return $stmt->execute(array(":id" => $produto->id)); 
    }
    public function insertimage ($id, $linkimg) {
        $stmt =  ConnectionDB::prepare(
            "INSERT INTO 
                tb_imgproduct (id_produto, linkimg)
            VALUES 
				(:id_produto, :linkimg)"
        );
        return $stmt->execute(
			array(
				":id_produto"       => $id, 
				":linkimg"          => $linkimg,
			)
        );
    }
}