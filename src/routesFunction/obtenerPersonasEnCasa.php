<?php
/**
 * Obtiene todas las personas que se encuentran en la casa a día de hoy.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerPersonasEnCasa($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $jsonAEnviar = getPersonasEnCasa($conexion);
    if (!$jsonAEnviar) 
        return json_encode(["status"=>"DATA_EMPTY"]);
    return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $jsonAEnviar]);
}

