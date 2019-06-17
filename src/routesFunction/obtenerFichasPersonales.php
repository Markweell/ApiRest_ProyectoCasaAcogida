<?php
    /**
     * Obtiene todas las fichas personales de la tabla ficha_personal.
     * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
     */
    function obtenerFichasPersonales($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $consulta = $conexion->prepare('SELECT id as "key", nombre as "name", apellido1 as "surname1", apellido2 as "surname2", image as "avatar" FROM fichas_personas');
        $consulta->execute();
        $resultadoBusqueda=$consulta->fetchAll();
        return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
    }
?>