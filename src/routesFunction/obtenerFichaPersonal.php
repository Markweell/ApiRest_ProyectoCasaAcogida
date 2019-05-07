<?php

    function obtenerFichaPersonal($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $id = $resp->id;
        $consulta = $conexion->prepare('SELECT * FROM ficha_personal WHERE id = :id');
        $consulta->execute([':id'=>$id]);
        $resultadoMainData=$consulta->fetchAll();

        $consulta = $conexion->prepare('SELECT * FROM fecha_registro WHERE id_ficha_personal = :id');
        $consulta->execute([':id'=>$id]);
        $resultadoDates=$consulta->fetchAll();
        if($resultadoMainData || $resultadoDates)
            return json_encode(["status"=>"OPERATION_SUCCESS", "data" =>['mainData'=>$resultadoMainData, 'dates'=>$resultadoDates] ]);
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
?>