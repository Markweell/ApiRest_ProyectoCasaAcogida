<?php
/**
 * Obtiene todas los sexos de la tabla t_sexo.
 * @return Object con un status que define el exito o fracaso de la operación. Si la operación tuvo éxito este objeto tiene un clave 'data' con el resultado de la consulta.
 */
function obtenerExpedientesEvaluacionDePersonasEnCasa($response, $request, $next)
{
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $jsonAEnviar = [];
    $personasEnCasa = getPersonasEnCasa($conexion);
    if (!$personasEnCasa) {
        return json_encode(["status"=>"DATA_EMPTY"]);
    }
    
    foreach ($personasEnCasa as $persona) {
        //var_dump($persona);
        if($persona["departure_date"] == NULL){
            $datosExpedienteRegistro = getDatosExpedienteRegistro($conexion, $persona["idRegistro"]);
            $estadoExpediente;
            //var_dump($datosExpedienteRegistro);-+
            if($datosExpedienteRegistro){
                if($datosExpedienteRegistro["created_at"] == NULL)
                    $expedienteComenzado = false;
                 else
                    $expedienteComenzado = true;

            array_push($jsonAEnviar, ["id"=>$persona['id'], "idExpedient"=>$datosExpedienteRegistro["idExpedient"],"image"=>$persona['image'],"name"=>$persona['name'],
                "surname1"=>$persona['surname1'],"surname2"=>$persona['surname2'],"entry_date"=>$persona["entry_date"],"expedient_started"=>$expedienteComenzado]);
            }
        }
    }
    return json_encode(["status"=>"OPERATION_SUCCESS","data"=> $jsonAEnviar]);
}

function getDatosExpedienteRegistro($conexion,$idRegistro)
{
    $valores = [":idRegistro" => $idRegistro];
    $consulta = $conexion->prepare('SELECT id as "idExpedient", created_at FROM expedientes_evaluacion WHERE expedientes_evaluacion.idRegistro = :idRegistro');
    $consulta->execute($valores);
    return $consulta->fetch();
}

