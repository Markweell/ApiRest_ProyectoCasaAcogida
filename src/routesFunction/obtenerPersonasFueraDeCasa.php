<?php
/**
 * Obtiene todas los sexos de la tabla t_sexo.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerPersonasFueraDeCasa($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $jsonAEnviar = [];
    $personas = getPersonas($conexion);
    if (!$personas) 
        return json_encode(["status"=>"DATA_EMPTY"]);
    foreach ($personas as $persona) {
        $datosPersona = getDatosPersona($persona["id"]);
        if ($datosPersona)
            array_push($jsonAEnviar, ["id" => $persona['id'], "name" => $persona['nombre'], "surname1" => $persona['apellido1'], "surname2" => $persona['apellido2'], "image" => $persona['image']]);
    }
    if(!empty($jsonAEnviar))
        return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $jsonAEnviar]);
    return json_encode(["status"=>"DATA_EMPTY"]);
}


function getDatosPersona($idPersona)
{
    $conexion = \Conexion::getConnection();
    $valores = [":idPersona" => $idPersona];
    $consulta = $conexion->prepare('SELECT id, nombre, apellido1, apellido2, image from fichas_personas where id = :idPersona AND id NOT IN (SELECT registro.idFichaPersona FROM registro) OR id IN (SELECT registro.idFichaPersona FROM registro where registro.fecha_salida IS NOT NULL AND registro.id = (SELECT MAX(ID) FROM registro where registro.idFichaPersona = :idPersona))');
    //$consulta = $conexion->prepare('SELECT id, nombre, apellido1, apellido2, image from fichas_personas where id = :idPersona AND id NOT IN (SELECT registro.idFichaPersona FROM registro) OR id IN (SELECT registro.idFichaPersona FROM registro where registro.fecha_salida IS NOT NULL AND registro.fecha_salida <= CURDATE() AND registro.id = (SELECT MAX(ID) FROM registro where registro.idFichaPersona = :idPersona))');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}

