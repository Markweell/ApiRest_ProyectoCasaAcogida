<?php
/**
 * Obtiene todas las personas que se encuentran en la casa a día de hoy.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerInformeRegistrosEntreFechas($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $fecha1 = $resp->date1;
    $fecha2 = $resp->date2;
    $consulta = $conexion->prepare('select fichas_personas.id, fichas_personas.image, fichas_personas.nombre as "name", fichas_personas.apellido1 as "surname1", fichas_personas.apellido2 as "surname2", t_sexo.sexo, registro.fecha_ingreso as "entry_date" from registro, fichas_personas, t_sexo where registro.idFichaPersona = fichas_personas.id AND fichas_personas.idSexo = t_sexo.id AND registro.fecha_ingreso >= :fecha1 AND registro.fecha_ingreso <= :fecha2');
    $consulta->execute([":fecha1"=>$fecha1,":fecha2"=>$fecha2]);
    $resultadoBusqueda=$consulta->fetchAll();
    if (!$resultadoBusqueda) 
        return json_encode(["status"=>"DATA_EMPTY"]);
    return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $resultadoBusqueda]);
}

