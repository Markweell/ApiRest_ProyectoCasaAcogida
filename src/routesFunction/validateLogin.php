<?php

    /**
     * Recibe una petición post con un email y una password, comprueba que existen en la base de datos y
     * en el caso de que existan, devuelve una json con id, nombre y token generado en base al id del usuario 
     */
    function validateLogin($response, $request, $next){
        $resp = json_decode($response->getBody());
        $email = $resp->email;              
        $password = $resp->password;
        $conexion = \Conexion::getConnection();
        //Comentar si usamos contraseña encriptada
        $valores = [":email"=>$email, ":password"=>$password];
        //Descomentar si usamos contraseña encriptada
        // $valores = [":email"=>$email];
        //Comentar si usamos contraseña encriptada
        $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email and password = :password');
        //Descomentar si usamos contraseña encriptada
        // $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email');
        $consulta->execute($valores);
        $resultadoBusqueda=$consulta->fetch();
        if(!$resultadoBusqueda)
            return json_encode(false);
        // Descomentar si usamos contraseña encriptada
        // if(!password_verify($password,$resultadoBusqueda["password"]))
        //     return json_encode(false);
        $idUsuario = $resultadoBusqueda['id'];
        $nombreUsuario = $resultadoBusqueda['nombre'];
        $perfil = $resultadoBusqueda['perfil'];
        $token = generateTokenLogin($idUsuario, $nombreUsuario, $perfil);
        return json_encode($token);
        // return json_encode(["id"=>$idUsuario,"nombre"=>$nombreUsuario, "token"=>$token]);
    }
?>