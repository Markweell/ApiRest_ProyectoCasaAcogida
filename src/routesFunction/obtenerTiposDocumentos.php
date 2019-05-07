<?php
    /**
     * Obtiene todas los tipos de documentos.
     * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
     */
    function obtenerTiposDocumentos($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $consulta = $conexion->prepare('SELECT * FROM t_tipos_documento');
        $consulta->execute();
        $resultadoBusqueda=$consulta->fetchAll();
        return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
    }
?>