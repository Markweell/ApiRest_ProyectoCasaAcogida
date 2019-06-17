<?php
function obtenerTiposSituacionLaboral(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT id, situacion_laboral as "value" FROM e_situaciones_laborales');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>