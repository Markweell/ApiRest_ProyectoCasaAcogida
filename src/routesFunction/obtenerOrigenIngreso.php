<?php
function obtenerOrigenIngreso(){
    // if(!validarToken(getTokenOfHeader()))
    //         return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM t_origen_ingreso');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>