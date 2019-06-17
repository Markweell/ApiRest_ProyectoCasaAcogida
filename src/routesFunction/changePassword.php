<?php
    /**
     * Recibe un token y una contraseña de una petición post y si el token es válido y no ha expirado,
     * modifica la contraseña del usuario cuyo id se encuentra en el token.
     */
    function changePassword($response, $request, $next){
        $resp = json_decode($response->getBody());
        $token = $resp->token;
        //Comentar si vamos a encriptar la contraseña
        $password = $resp->password;
        //Descomentar si vamos a encriptar la contraseña
        //$password = encrypt_password($resp->password);
        if(!validarToken($token))
            return json_encode(["status"=>"TOKEN_EXPIRED"]);

        $idUsuario = getIdOfToken($token);
    
        $conexion = \Conexion::getConnection();
        $valores = [":id"=>$idUsuario, ":password"=>$password];
        $consulta = $conexion->prepare('UPDATE usuarios SET password=:password where id = :id');

        if($consulta->execute($valores))
            return json_encode(["status"=>"PASSWORD_CHANGED"]);
        return json_encode(["status"=>"PASSWORD_ERROR"]);
    }
?>