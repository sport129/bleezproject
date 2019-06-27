<?php

namespace App\Libries;

class jsonResponse {

    public function constructResponseJson ($httpResponse = 400, $statusResponse = 400, $message = '', $documents = []) {
        $dados = array(
            'status'    => $statusResponse,
            'message'   => $message,
            'documents' => $documents
        );
        http_response_code($httpResponse);
        return json_encode($dados);
    }
}