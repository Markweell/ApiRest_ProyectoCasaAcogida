<?php
    function obtenerInformacionExpediente($response, $request, $next){
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $id = $resp->id;
        $valor=[':id'=>$id];

        $consulta = $conexion->prepare(
            'SELECT 
            fichas_personas.*,
            expedientes_evaluacion.*,
            registro.*
        FROM expedientes_evaluacion 
            LEFT JOIN registro
                ON expedientes_evaluacion.idRegistro = registro.id
            LEFT JOIN fichas_personas
                ON registro.idFichaPersona = fichas_personas.id
        WHERE expedientes_evaluacion.id = :id');
        $consulta->execute($valor);
        $resultadoMainData=$consulta->fetchAll();
        $resultadoFechas = obtenerFechas_ingreso($conexion,$valor);
        $resultadoDocumentacion = obtenerDocumentacion($conexion,$valor);
        if($resultadoMainData)
            return json_encode(["status"=>"OPERATION_SUCCESS",
                                "data" =>['mainData'=>$resultadoMainData]]);
    }


?>