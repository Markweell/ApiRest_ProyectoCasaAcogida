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
        $resultadoDocumentacion = obtenerDocumentacionDelExpediente($conexion,$valor);
        if($resultadoMainData)
            return json_encode(["status"=>"OPERATION_SUCCESS",
                                "data" =>['mainData'=>$resultadoMainData,'documentacion'=>$resultadoDocumentacion]]);
    }
    function obtenerDocumentacionDelExpediente($conexion,$valor){
         $consulta = $conexion->prepare('SELECT inf_id_documentacion.*, t_tipos_documento.documento
            FROM inf_id_documentacion 
            LEFT JOIN t_tipos_documento 
                ON inf_id_documentacion.idTipoDocumento = t_tipos_documento.id
            WHERE inf_id_documentacion.idFichaPersonal = 
                (SELECT registro.idFichaPersona FROM registro where registro.id =
                     (SELECT expedientes_evaluacion.idRegistro FROM expedientes_evaluacion WHERE expedientes_evaluacion.id=:id))');
        $consulta->execute($valor);
        return $consulta->fetchAll();
    }


?>