<?php
/**
 * Obtiene todas los sexos de la tabla t_sexo.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerCamasLibres($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $jsonAEnviar = [];
    $habitaciones = getHabitaciones();
    if (!$habitaciones) {
        return;
    }

    foreach ($habitaciones as $habitacion) {
        $datosHabitacion = ["id" => $habitacion["id"], "number" => $habitacion["habitacion"], "beds" => []];
        $camas = getCamasHabitacion($habitacion["id"]);
        if (!$camas) 
            return;
        foreach($camas as $cama){
            $idCama = $cama["id"];
            $numeroCama = $cama["cama"];
            $camaLibre = getDatosCamaLibre($idCama);
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

function getHabitaciones()
{
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT id, habitacion FROM `habitaciones`');
    $consulta->execute();
    return $consulta->fetchAll();
}

function getCamasHabitacion($idHabitacion)
{
    $conexion = \Conexion::getConnection();
    $valores = [":idHabitacion" => $idHabitacion];
    $consulta = $conexion->prepare('SELECT camas.id, camas.cama from camas where camas.idHabitacion = :idHabitacion');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}

function getDatosCamaLibre($idCama)
{
    $conexion = \Conexion::getConnection();
    $valores = [":idCama" => $idCama];
    $consulta = $conexion->prepare('SELECT id, cama from camas where id = :idCama AND id NOT IN (SELECT r_registro_camas.idCama FROM r_registro_camas) OR id IN (SELECT r_registro_camas.idCama FROM r_registro_camas where r_registro_camas.idCama = :idCama AND r_registro_camas.fecha_final IS NOT NULL)');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}
