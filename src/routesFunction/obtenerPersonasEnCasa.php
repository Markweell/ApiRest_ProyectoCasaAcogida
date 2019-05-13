<?php
/**
 * Obtiene todas los sexos de la tabla t_sexo.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerPersonasEnCasa($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $jsonAEnviar = getPersonasEnCasa();
    if (!$jsonAEnviar) 
        return json_encode(["status"=>"DATA_EMPTY"]);
    return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $jsonAEnviar]);
}



function getPersonasEnCasa()
{
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare(
        'SELECT fichas_personas.id,
                fichas_personas.image,
                fichas_personas.nombre as "name",
                fichas_personas.apellido1 as "surname1",
                fichas_personas.apellido2 as "surname2",
                registro.fecha_ingreso as "entry_date",
                registro.fecha_salida as "departure_date",
                habitaciones.habitacion as "room",
                camas.cama as "bed" 
        FROM fichas_personas, registro, r_registro_camas, camas, habitaciones
        WHERE fichas_personas.id = registro.idFichaPersona 
            AND registro.id = r_registro_camas.idRegistro 
            AND r_registro_camas.idCama = camas.id 
            AND camas.idHabitacion = habitaciones.id 
            AND registro.fecha_salida IS NULL OR registro.fecha_salida > CURDATE()');
    $consulta->execute();
    return $consulta->fetchAll();
}

