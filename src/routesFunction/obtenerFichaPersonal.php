<?php

    function obtenerFichaPersonal($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $id = $resp->id;
        $consulta = $conexion->prepare('SELECT * FROM ficha_personal WHERE id = :id');
        $consulta->execute([':id'=>$id]);
        $resultadoBusqueda=$consulta->fetchAll();
        return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
    }
?>