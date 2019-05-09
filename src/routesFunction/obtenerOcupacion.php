<?php
/**
 * Obtiene todas los sexos de la tabla t_sexo.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerOcupacion($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $jsonAEnviar = [];
    $habitaciones = getHabitaciones($conexion);
    if (!$habitaciones) {
        return;
    }
    
    foreach ($habitaciones as $habitacion) {
        $datosHabitacion = ["id" => $habitacion["id"], "room" => $habitacion["habitacion"], "beds" => []];
        $camas = getCamasHabitacion($conexion, $habitacion["id"]);
        if (!$camas) 
            return;
        foreach($camas as $cama){
            $idCama = $cama["id"];
            $numeroCama = $cama["cama"];
            $registroCama = getDatosRegistroCama($conexion, $idCama);
            //var_dump($registroCama);
            //var_dump($registroCama);
            if(!$registroCama)
                array_push($datosHabitacion["beds"], ["number" => $numeroCama, "occupant" => '']);
            else{
                $fecha_final = $registroCama[0]["fecha_final"];
                if($fecha_final && strtotime($fecha_final) < strtotime(date("d-m-Y"))){
                    array_push($datosHabitacion["beds"], ["number" => $numeroCama, "occupant" => '']);
                } else {
                    $idRegistro = $registroCama[0]['idRegistro'];
                    $datosPersona = getDatosPersonaPorRegistro($conexion, $idRegistro);
                    //var_dump($datosPersona);
                    array_push($datosHabitacion["beds"], ["number" => $numeroCama, "occupant" => ["id" => $datosPersona[0]['id'], "name" => $datosPersona[0]['nombre'], "surname1" => $datosPersona[0]['apellido1'], "surname2" => $datosPersona[0]['apellido2'], "image" => $datosPersona[0]['image']]]);
                }
            }
        }
        array_push($jsonAEnviar, $datosHabitacion);
    }
    return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $jsonAEnviar]);
}

function getDatosRegistroCama($conexion,$idCama)
{
    $valores = [":idCama" => $idCama];
    $consulta = $conexion->prepare('SELECT * FROM `r_registro_camas` where id = (SELECT MAX(id) from r_registro_camas where idCama = :idCama)');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}

function getDatosPersonaPorRegistro($conexion,$idRegistro)
{
    $valores = [":idRegistro" => $idRegistro];
    $consulta = $conexion->prepare('SELECT fichas_personas.id, fichas_personas.nombre, fichas_personas.apellido1, fichas_personas.apellido2, fichas_personas.image FROM fichas_personas, registro WHERE fichas_personas.id = registro.idFichaPersona AND registro.id = :idRegistro');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}

