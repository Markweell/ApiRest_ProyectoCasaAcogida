<?php
    /**
     * Obtiene todos los apoyos sociales
     * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
     */
    function obtenerApoyosSociales($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $consulta = $conexion->prepare('SELECT e_apoyo_social.id, e_apoyo_social.apoyo_social, e_tipo_apoyo_social.id as "idTipo", e_tipo_apoyo_social.tipo FROM `e_apoyo_social`,e_tipo_apoyo_social WHERE e_apoyo_social.id_tipo_apoyo_social = e_tipo_apoyo_social.id');
        $consulta->execute();
        $resultadoBusqueda=$consulta->fetchAll();
        if($resultadoBusqueda)
            return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
?>