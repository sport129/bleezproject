<?php

namespace App\Model;

use App\Database\ConnectionDB;

class UserToken extends ConnectionDB {
    protected $table;
    function __construct () {
        $this->table = 'userToken';
    }
    public function findTokenUser ($idUser) {
        $stmt = ConnectionDB::prepare(
            "SELECT * FROM
                $this->table
            WHERE
                userId = :userId"
        );
        $stmt->execute(array(":userId" => $idUser));
        return $stmt->fetch();
    }
    public function insertUserToken ($token, $userId) {
        $stmt = ConnectionDB::prepare(
			"INSERT INTO 
				$this->table (userId, token, time_expired) 
			VALUES 
				(:userId, :token, :time_expired)"
		);
		$stmt->execute(
			array(
				":userId" 		    => $userId, 
				":token" 		    => $token, 
				":time_expired" 	=> date('Y-m-d H:i:s')
			)
        ); 
        
        return $this->findTokenUser($userId);
    } 
}