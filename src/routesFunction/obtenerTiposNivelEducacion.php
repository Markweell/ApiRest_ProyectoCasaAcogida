<?php
function obtenerTiposNivelEducacion(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT id, nivel_estudios as "value" FROM t_niveles_estudios');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>