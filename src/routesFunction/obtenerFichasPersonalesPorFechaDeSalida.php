<?php
/**
 * Recibe una fecha por post y te devuelve todas las fichas personales con esa fecha de salida.
 * @return resultados en formato json de la consulta.
 */
function obtenerFichasPersonalesPorFechaDeSalida($response, $request, $next){
    
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $fechaSalida = $resp->fechaSalida;
    $valores = [":fechaSalida"=>$fechaSalida];
    $consulta = $conexion->prepare('SELECT id as "key", nombre as "name", apellidos as "surname", dni as "documentation", image as "avatar"  FROM ficha_personal where id IN (SELECT id_ficha_personal from fecha_registro where fecha_salida = :fechaSalida )');
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetchAll();

    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>