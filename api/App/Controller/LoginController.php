<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\UserToken;
use App\Libries\jsonResponse;
use Exception;

class LoginController {
    function __construct () {
        $this->userModel = new UserModel;
        $this->userToken = new UserToken;
        $this->jsonResponse = new jsonResponse;
    }
    public function onSingIn ($request) {
        try {
            $findUser = $this->userModel->findUser($request->username);
            
            if (empty($findUser)) throw new Exception("Usuário Inválido");
            if (!password_verify($request->password, $findUser->password))  throw new Exception("Senha Inválida");
        
            $findTokenUser = $this->userToken->findTokenUser($findUser->id);

            if (empty($findTokenUser)) {
                $findTokenUser = $this->createUserToken($findUser);
            }

            $datatoReturn = array(
                'client'        => $findUser,
                'credentials'   => $findTokenUser
            );
            return $this->jsonResponse->constructResponseJson(200, 200, 'Logado Com Sucesso', $datatoReturn);
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());
        }
    }
    private function createUserToken ($datesUser) {
        try {
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
    
            $header = json_encode($header);
            $header = base64_encode($header);
    
            $payload = json_encode($datesUser);
            $payload = base64_encode($payload);
    
            $signature = hash_hmac('sha256',"$header.$payload",'$2$@$5',true);
            $signature = base64_encode($signature);
    
            $token = "$header.$payload.$signature";
    
            $userToken = $this->userToken->insertUserToken($token, $datesUser->id);

            if (empty($userToken)) throw new Exception("Não foi possivel gerar o token");

            return $userToken;
        } catch (Exception $e) {
            return $this->jsonResponse->constructResponseJson(400, 400, $e->getMessage());
        }
    }
}