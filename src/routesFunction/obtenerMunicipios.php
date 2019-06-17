<?php
    /**
     * Obtiene todos los municipios de una provincia.
     * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
     */
    function obtenerMunicipios($response, $request, $next){
        // if(!validarToken(getTokenOfHeader()))
        //     return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $consulta = $conexion->prepare('SELECT * FROM t_poblaciones WHERE idProvincia = :idProvincia');
        $consulta->execute([":idProvincia"=>$resp->idProvincia]);
        $resultadoBusqueda=$consulta->fetchAll();
        if($resultadoBusqueda)
            return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
?>