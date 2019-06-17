<?php
function obtenerCentrosSocialesRedCohabita(){
    // if(!validarToken(getTokenOfHeader()))
    //         return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM t_tipo_centro_cohabita');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>