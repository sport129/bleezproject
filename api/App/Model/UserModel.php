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
}