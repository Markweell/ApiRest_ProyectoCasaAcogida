<?php

function obtenerFichaPersonal($response, $request, $next){
    if(!validarToken(getTokenOfHeader()))
        return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $id = $resp->id;
    $valor=[':id'=>$id];
    // $consulta = $conexion->prepare(
    //     'SELECT 
    //         fichas_personas.*,
    //         t_paises1.nacionalidad,
    //         t_sexo.sexo,
    //         t_paises2.nacionalidad as "lugarNacimiento"
    //     FROM fichas_personas 
    //         LEFT JOIN t_paises AS t_paises1 
    //             ON fichas_personas.idNacionalidad = t_paises1.id 
    //         LEFT JOIN t_sexo 
    //             ON fichas_personas.idSexo = t_sexo.id 
    //         LEFT JOIN t_paises AS t_paises2 
    //             ON fichas_personas.idPaisNacimiento = t_paises2.id 
    //     WHERE fichas_personas.id = :id');
        
    // $consulta->execute($valor);
    // $resultadoMainData=$consulta->fetchAll();
    
    $consulta = $conexion->prepare(
        'SELECT 
            fichas_personas.*,
            t_paises1.nacionalidad,
            t_sexo.sexo,
            t_paises2.nacionalidad as "lugarNacimiento",
            registro.fecha_ingreso,
            registro.fecha_salida,
            r_registro_camas.idCama,
            r_registro_camas.fecha_inicio AS "asignacionCama",
            r_registro_camas.fecha_final AS "abandonoCama",
            camas.cama AS "numeroCama",
            habitaciones.habitacion AS "habitacion"
        FROM fichas_personas 
            LEFT JOIN t_paises AS t_paises1 
                ON fichas_personas.idNacionalidad = t_paises1.id 
            LEFT JOIN t_sexo 
                ON fichas_personas.idSexo = t_sexo.id 
            LEFT JOIN t_paises AS t_paises2 
                ON fichas_personas.idPaisNacimiento = t_paises2.id
            LEFT JOIN registro
   	            ON fichas_personas.id = registro.idFichaPersona
            LEFT JOIN r_registro_camas
   	            ON registro.id = r_registro_camas.idRegistro
            LEFT JOIN camas
   	            ON r_registro_camas.idCama = camas.id
            LEFT JOIN habitaciones
   	            ON camas.idHabitacion = habitaciones.habitacion
        WHERE fichas_personas.id = :id');
    $consulta->execute($valor);
    $resultadoMainData=$consulta->fetchAll();

    if($resultadoMainData)
        return json_encode(["status"=>"OPERATION_SUCCESS",
                            "data" =>['mainData'=>$resultadoMainData]]);
}
?>