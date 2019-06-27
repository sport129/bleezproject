<?php

namespace App\Repositories;

class UserTokenRepositories {

    public function createTokenUser ($dataUser) {
        $header     = $this->fetchHeader();
        $payload    = $this->fetchPayload($dataUser);
        $signature  = $this->fetchSignature($header, $payload);
        return "$header.$payload.$signature";
    }

    private function fetchHeader () {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $header = base64_encode(json_encode($header));
        return $header;
    }

    private function fetchPayload ($dataUser) {
        $dataUser = (array) $dataUser;
        return  base64_encode(json_encode($dataUser));
    }

    private function fetchSignature ($header, $payload) {
        return base64_encode(hash_hmac('sha256',"$header.$payload",'$2$@$5',true));
    }
}