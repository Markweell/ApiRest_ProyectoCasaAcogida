<?php
    /**
     * Recibe un token de una petición post y lo valida.
     */
    function validateToken($response, $request, $next){
        $resp = json_decode($response->getBody());
        $token = $resp->token;
        $comprobacionToken = validarToken($token);
        
        return json_encode($comprobacionToken);
    }   
?>