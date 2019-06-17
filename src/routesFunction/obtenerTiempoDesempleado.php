<?php
function obtenerTiempoDesempleado(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT id, tiempo_desempleo as "value" FROM t_tiempos_desempleo');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>