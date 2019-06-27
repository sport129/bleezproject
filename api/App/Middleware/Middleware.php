<?php

namespace App\Middleware;

Class Middleware {
    public function verifyTokenValidate ($token) {
        $token = str_replace('Bearer ' , '', $token);
        $token = explode('.', $token);
        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];
        $valid = base64_encode(hash_hmac('sha256',"$header.$payload",'$2$@$5',true));
        if($signature == $valid){
            return true;
        }else{
            return false;
        }
    }
}