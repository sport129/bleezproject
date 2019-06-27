<?php

namespace App\Model;

use App\Database\ConnectionDB;

class UserModel extends ConnectionDB {
    protected $table;
    function __construct () {
        $this->table = 'users';
    }
    public function findUser ($username) {
        $stmt = ConnectionDB::prepare(
            "SELECT * FROM
                $this->table
            WHERE
                username = :username"
        );
        $stmt->execute(array(":username" => $username));
        return $stmt->fetch();
    }
    public function findUserToCreate ($dateToCreateUser) {
        $stmt = ConnectionDB::prepare(
            "SELECT * FROM
                $this->table
            WHERE
                username = :username
            OR  
                email = :email    "
        );
        $stmt->execute(array(":username" => $dateToCreateUser->username, ":email" => $dateToCreateUser->email));
        return $stmt->fetch();
    }

    public function createUser ($dateToCreateUser) {
        $stmt = ConnectionDB::prepare(
			"INSERT INTO 
				$this->table (username, password, email) 
			VALUES 
				(:username, :password, :email)"
		);
		$stmt->execute(
			array(
				":username"     => $dateToCreateUser->username, 
				":password"     => $dateToCreateUser->password, 
				":email" 	    => $dateToCreateUser->email
			)
        ); 
    }
}