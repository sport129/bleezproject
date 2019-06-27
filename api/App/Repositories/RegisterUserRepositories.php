<?php

namespace App\Repositories;

use App\Model\UserModel;

class RegisterUserRepositories {
    function __construct () {
        $this->userModel            = new UserModel;
    }
    public function createUser ($request) {
        if (!empty($this->verifyUniqueUser($request))) return (object) array('status' => true, 'message' => 'Usuário Já Cadastrado');
        return $this->createAndSaveUser($request);
    }
    private function verifyUniqueUser ($dateToCreateUser) {
        return $this->userModel->findUserToCreate($dateToCreateUser);
    }
    private function createAndSaveUser ($dateToCreateUser) {
        $dateToCreateUser->password = $this->encryptPassword($dateToCreateUser->password);
        $responseToCreate = $this->userModel->createUser($dateToCreateUser);
        if (!$responseToCreate) return (object) array('status' => false, 'message' => 'Usuário Criado Com Sucesso');
        return (object) array('status' => true, 'message' => 'Não Foi Possível Criar o Usuário');
    }
    private function encryptPassword ($password) {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}