<?php

function obtenerFichaPersonal($response, $request, $next){
    // if(!validarToken(getTokenOfHeader()))
    //     return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $id = $resp->id;
    $valor=[':id'=>$id];

    $consulta = $conexion->prepare(
        'SELECT 
            fichas_personas.*,
            t_paises1.nacionalidad,
            t_sexo.sexo,
            t_paises2.nacionalidad as "lugarNacimiento"
        FROM fichas_personas 
            LEFT JOIN t_paises AS t_paises1 
                ON fichas_personas.idNacionalidad = t_paises1.id 
            LEFT JOIN t_sexo 
                ON fichas_personas.idSexo = t_sexo.id 
            LEFT JOIN t_paises AS t_paises2 
                ON fichas_personas.idPaisNacimiento = t_paises2.id
        WHERE fichas_personas.id = :id');
    $consulta->execute($valor);
    $resultadoMainData=$consulta->fetchAll();
    $resultadoFechas = obtenerFechas_ingreso($conexion,$valor);
    $resultadoDocumentacion = obtenerDocumentacion($conexion,$valor);
    if($resultadoMainData)
        return json_encode(["status"=>"OPERATION_SUCCESS",
                            "data" =>[  'mainData'=>$resultadoMainData,
                                        'fechas'=>$resultadoFechas['datos'],
                                        'camaActual'=>$resultadoFechas['camaActual'],
                                        'habitacionActual'=>$resultadoFechas['habitacionActual'],
                                        'idRegistroCama'=>$resultadoFechas['idRegistroCama'],
                                        'idRegistro'=>$resultadoFechas['idRegistro'],
                                        'documentacion'=>$resultadoDocumentacion]]);
}

function obtenerFechas_ingreso($conexion,$valor){
    $consulta = $conexion->prepare('SELECT registro.id, registro.fecha_ingreso, registro.fecha_salida, expedientes_evaluacion.id "idExpediente", expedientes_evaluacion.fecha_evaluacion  FROM `registro`,expedientes_evaluacion WHERE registro.id = expedientes_evaluacion.idRegistro AND idFichaPersona = :id ORDER BY `registro`.`fecha_ingreso` ASC');
    $consulta->execute($valor);
    $resultadoMainData=$consulta->fetchAll();
    $habitacionActual = '';
    $camaActual = '';
    $idRegistroCama = '';
    $idRegistro = '';
    $datos = [];
    
    foreach ($resultadoMainData as $key => $value) {
        $fechasIngreso = [  'nRegistro'=>$key+1,
                            'fechaEntrada'=>$value['fecha_ingreso'],
                            'fechaSalida'=>$value['fecha_salida'],
                            'idExpediente'=>$value['idExpediente'],
                            'expedient_started'=> $value['fecha_evaluacion'],
                            'estancia'=>[]];
        $consulta = $conexion->prepare(
            'SELECT  r_registro_camas.*,camas.cama,habitaciones.habitacion FROM r_registro_camas,
                        camas,
                        habitaciones  
            WHERE r_registro_camas.idCama = camas.id 
                AND camas.idHabitacion=habitaciones.id 
                AND r_registro_camas.idRegistro = :id ');
        $consulta->execute([':id'=>$value['id']]);
        $resultadoMainData=$consulta->fetchAll();
        foreach ($resultadoMainData as $key1 => $value1) {
            
            if($value1['fecha_final'] == null || strtotime($value1['fecha_final'])>time()){
                $habitacionActual = $value1['habitacion'];
                $camaActual = $value1['cama'];
                $idRegistroCama = $value1['id'];
                $idRegistro = $value1['idRegistro'];
            }
            $estancia=[ 'nHabitacion'=>$value1['habitacion'],
                        'nCama'=>$value1['cama'],
                        'fechaInicioCama'=>$value1['fecha_inicio'], 
                        'fechaFinalCama'=>$value1['fecha_final']];
            array_push($fechasIngreso['estancia'],$estancia);
        }
        array_push($datos, $fechasIngreso);
    }
    return ['datos'=>$datos, 'camaActual'=>$camaActual, 'habitacionActual'=>$habitacionActual, 'idRegistroCama'=>$idRegistroCama, 'idRegistro'=>$idRegistro];
}
function obtenerDocumentacion($conexion,$valor){
    $consulta = $conexion->prepare('SELECT t_tipos_documento.documento, inf_id_documentacion.numero_documento 
                                        FROM inf_id_documentacion, t_tipos_documento 
                                        WHERE inf_id_documentacion.idFichaPersonal = :id 
                                            AND inf_id_documentacion.idTipoDocumento = t_tipos_documento.id
                                            AND inf_id_documentacion.numero_documento is not null
                                            AND inf_id_documentacion.numero_documento != ""');
    $consulta->execute($valor);
    $resultadoMainData=$consulta->fetchAll();
    return $resultadoMainData;
}

?>