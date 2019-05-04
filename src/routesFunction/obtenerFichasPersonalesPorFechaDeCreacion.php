<?php
/**
 * Recibe una fecha por post y te devuelve todas las fichas personales con esa fecha de creación.
 * @return resultados en formato json de la consulta.
 */
function obtenerFichasPersonalesPorFechaDeCreacion($response, $request, $next){
    
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $fechaEntrada = $resp->fechaEntrada;
    $valores = [":fechaEntrada"=>$fechaEntrada];
    $consulta = $conexion->prepare('SELECT ficha_personal.id as "key", ficha_personal.nombre as "name", ficha_personal.apellidos as "surname", ficha_personal.dni as "documentation", ficha_personal.image as "avatar"  FROM `fecha_registro`, ficha_personal where ficha_personal.id = fecha_registro.id_ficha_personal and fecha_registro.fecha_entrada = :fechaEntrada GROUP BY fecha_registro.id_ficha_personal');
    //'SELECT id as "key", nombre as "name", apellidos as "surname", dni as "documentation", image as "avatar"  FROM ficha_personal where id IN (SELECT id_ficha_personal from fecha_registro where fecha_entrada = :fechaEntrada )'
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetchAll();

    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>