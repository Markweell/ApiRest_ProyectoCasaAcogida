<?php
/**
 * Obtiene todas los sexos de la tabla t_sexo.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerCamasLibres($response, $request, $next)
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
        $datosHabitacion = ["id" => $habitacion["id"], "number" => $habitacion["habitacion"], "type"=>$habitacion["tipo_habitacion"], "beds" => []];
        $camas = getCamasHabitacion($conexion, $habitacion["id"]);
        if (!$camas) 
            return;
        foreach($camas as $cama){
            $idCama = $cama["id"];
            $numeroCama = $cama["cama"];
            $camaLibre = getDatosCamaLibre($conexion, $idCama);
            //var_dump($datosHabitacion["beds"]);
            if($camaLibre)
                array_push($datosHabitacion["beds"], ["id" => $idCama, "number" => $numeroCama]);
        }
        if(!empty(end($datosHabitacion)))
            array_push($jsonAEnviar, $datosHabitacion);
    }
    if(!empty($jsonAEnviar))
        return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $jsonAEnviar]);
    return json_encode(["status"=>"DATA_EMPTY"]);
}
