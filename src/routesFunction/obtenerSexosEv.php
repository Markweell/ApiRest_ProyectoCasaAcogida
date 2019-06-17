<?php

function obtenerSexosEv(){
    // if(!validarToken(getTokenOfHeader()))
    //         return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM t_sexo_ev');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    if(!$resultadoBusqueda){
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}

?>