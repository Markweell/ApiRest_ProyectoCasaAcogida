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
    $fechaCreacion = $resp->fechaCreacion;
    $valores = [":fechaCreacion"=>$fechaCreacion];
    $consulta = $conexion->prepare('SELECT id as "key", nombre as "name", apellidos as "surname", dni as "documentation", image as "avatar" FROM ficha_personal where fecha_creacion = :fechaCreacion');
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetchAll();

    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>