
<?php
function obtenerTiposAusenciaDocumento(){
    // if(!validarToken(getTokenOfHeader()))
    //         return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM t_tipos_ausencia_documento');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    if(!$resultadoBusqueda){
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>