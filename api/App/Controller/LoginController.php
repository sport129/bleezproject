<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\UserToken;
use App\Libries\jsonResponse;
use App\Repositories\UserTokenRepositories;
use Exception;

class LoginController {

    function __construct () {
        $this->userModel            = new UserModel;
        $this->userToken            = new UserToken;
        $this->jsonResponse         = new jsonResponse;
        $this->userTokenRepositorie = new UserTokenRepositories;
    }
    public function onSingIn ($request) {
        try {
            if ($this->validatorLogin ($request)) throw new Exception("Dados Invalidos");

            $findUser = $this->userModel->findUser($request->username);
            
            if (empty($findUser)) throw new Exception("Usuário Inválido");
            if (!password_verify($request->password, $findUser->password))  throw new Exception("Senha Inválida");
        
            $tokenUser = $this->userToken->findTokenUser($findUser->id);
    
            if (empty($tokenUser)) $tokenUser = $this->createUserToken($findUser);
            
            $datatoReturn = array(
                'client'        => $findUser,
                'credentials'   => $tokenUser
            );

            return $this->jsonResponse->constructResponseJson(200, 200, 'Logado Com Sucesso', $datatoReturn);
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(401, 401, $e->getMessage());
        }
    }
    private function createUserToken ($datesUser) {
        try {
            $createTokenRepository = $this->userTokenRepositorie->createTokenUser($datesUser);
            
            $userToken = $this->userToken->insertUserToken($createTokenRepository, $datesUser->id);

            if (empty($createTokenRepository)) throw new Exception("Não foi possivel gerar o token");

            return $userToken;
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());
        }
    }
    private function validatorLogin ($request) {
        if ($request->username == '' || $request->password == '') return true;
        return false;
    }
}