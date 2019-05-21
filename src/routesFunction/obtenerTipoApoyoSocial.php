<?php
    /**
     * Obtiene todas los parentescos de la tabla t_parentescos.
     * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
     */
    function obtenerTipoApoyoSocial($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $consulta = $conexion->prepare('SELECT * FROM e_tipo_apoyo_social');
        $consulta->execute();
        $resultadoBusqueda=$consulta->fetchAll();
        if($resultadoBusqueda)
            return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
?>