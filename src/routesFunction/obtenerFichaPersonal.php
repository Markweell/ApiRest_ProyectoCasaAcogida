<?php

    function obtenerFichaPersonal($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $id = $resp->id;
        $consulta = $conexion->prepare('SELECT * FROM fichas_personas WHERE id = :id');
        $consulta->execute([':id'=>$id]);
        $resultadoMainData=$consulta->fetchAll();

        if($resultadoMainData)
            return json_encode(["status"=>"OPERATION_SUCCESS", "data" =>['mainData'=>$resultadoMainData]]);
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
?>