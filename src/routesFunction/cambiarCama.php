<?php
    /**
     * Cambia de cama
     */
    function cambiarCama($response, $request, $next){
        // if(!validarToken(getTokenOfHeader()))
        //     return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $valores = obtenerDatosCambioCama($response);
        // if(comprobarDniExistente($conexion,$valores['dni']))
        //     return json_encode(["status"=>"DOCUMENTATION_EXISTS"]);
        

        if(dejarCama($valores, $conexion)){
            if(insertarCama($valores, $valores['idRegistro'],$conexion))
                return json_encode(["status"=>"OPERATION_SUCCESS"]);
            else
                return json_encode(["status"=>"OPERATION_ERROR"]);
        }else
            return json_encode(["status"=>"OPERATION_ERROR"]);
    }
    /**
     * Obtiene los datos que le llegan a la petición post y los devuelve como un array.
     */
    function obtenerDatosCambioCama($response){
        $resp = json_decode($response->getBody());
        $fechaInicioFinal = date("Y-m-d");
        $createdUpdated = date("Y-m-d H:i:s");
        $idRegistroCamas = $resp->idRegistroCamas;
        $idCama = $resp->idCama;
        $idRegistro = $resp->idRegistro;
        $idUserUpdated = getIdOfToken(getTokenOfHeader());

        return [
            'fecha_entrada'=>$fechaInicioFinal,
            'fecha_salida'=>$fechaInicioFinal,
            'updated'=>$createdUpdated,
            'idRegistroCama'=>$idRegistroCamas,
            'idCama'=> $idCama,
            'idBed'=> $idCama,
            'idRegistro' =>$idRegistro,
            'fecha_inicio' =>$fechaInicioFinal,
            'created_updated'=>$fechaInicioFinal,
            'idUsuario_created_updated'=>$idUserUpdated,
            'idUserUpdated' => $idUserUpdated,
            'idConserje' => $idUserUpdated,
        ];
    }
?>