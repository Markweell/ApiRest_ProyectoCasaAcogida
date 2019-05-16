<?php
    /**
     * Crea una nueva salida
     */
    function agregarNuevaSalida($response, $request, $next){
        // if(!validarToken(getTokenOfHeader()))
        //     return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $valores = obtenerDatosNuevaSalida($response);
        // if(comprobarDniExistente($conexion,$valores['dni']))
        //     return json_encode(["status"=>"DOCUMENTATION_EXISTS"]);
        

        if(dejarCama($valores, $conexion)){
            if(insertarSalida($valores, $conexion))
                return json_encode(["status"=>"OPERATION_SUCCESS"]);
            else
                return json_encode(["status"=>"OPERATION_ERROR"]);
        }else
            return json_encode(["status"=>"OPERATION_ERROR"]);
    }
    /**
     * Obtiene los datos que le llegan a la petición post y los devuelve como un array.
     */
    function obtenerDatosNuevaSalida($response){
        $resp = json_decode($response->getBody());
        $fecha_salida = $resp->departureDate." ".$resp->departureHour;
        $razon_salida = $resp->reasonDeparture;          
        $updated = date("Y-m-d H:i:s");
        $idRegistro = $resp->idRecord;
        $idRegistroCama = $resp->idRecordBed;
        $idUserUpdated = getIdOfToken(getTokenOfHeader());

        return [
            'fecha_salida'=>$fecha_salida,
            'razon_salida'=>$razon_salida,
            'updated'=>$updated,
            'idRegistro'=> $idRegistro,
            'idRegistroCama' => $idRegistroCama,
            'idUserUpdated'=>$idUserUpdated
        ];
    }
    /**
     * Inserta una cama a un registro
     */
    function dejarCama($valores, $conexion){
        $valoresConsulta = [ 
            ":fecha_salida"=>$valores['fecha_salida'], 
            ":updated"=>$valores['updated'],
            ":idRegistroCama"=>$valores['idRegistroCama'],
            ":idUserUpdated"=>$valores['idUserUpdated']];
        $consulta = $conexion->prepare('UPDATE r_registro_camas SET r_registro_camas.fecha_final = :fecha_salida, r_registro_camas.updated_at = :updated, r_registro_camas.idUsuario_updated_at = :idUserUpdated WHERE r_registro_camas.id = :idRegistroCama');
        return $consulta->execute($valoresConsulta);
    }

    /**
     * Inserta un registro de entrada
     */
    function insertarSalida($valores, $conexion){
        $valoresConsulta = [ 
            ":fecha_salida"=>$valores['fecha_salida'],
            ":razon_salida"=>$valores['razon_salida'], 
            ":updated"=>$valores['updated'],
            ":idRegistro"=>$valores['idRegistro'],
            ":idUserUpdated"=>$valores['idUserUpdated']];
            
        $consulta = $conexion->prepare('UPDATE registro SET registro.fecha_salida = :fecha_salida, registro.motivo_salida = :razon_salida, registro.updated_at = :updated, registro.idUsuario_updated_at = :idUserUpdated WHERE registro.id = :idRegistro');
        return $consulta->execute($valoresConsulta);
    }
?>