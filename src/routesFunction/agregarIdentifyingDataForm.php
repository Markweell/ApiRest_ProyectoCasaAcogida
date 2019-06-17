<?php
    /**
     * Recibe los datos mandados por el primer formulario, y hace los update en la base de datos correspondientes.
     */
    function agregarIdentifyingDataForm($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody()); 
        $idTecnico = getIdOfToken(getTokenOfHeader());

        $valoresFichasPersonas = [":id_expediente"=>$resp->id_expediente,
                                    ":fechaExpediente"=>$resp->fechaExpediente,
                                    ":nombre"=>$resp->nombre,
                                    ":apellido1"=>$resp->apellido1,
                                    ":apellido2"=>$resp->apellido2,
                                    ":fechaNacimiento"=>$resp->fechaNacimiento,
                                    ":fechaEmpadronamiento"=>$resp->fechaEmpadronamiento,
                                    ":telefono"=>$resp->telefono,
                                    ":email"=>$resp->email,
                                    ":nacionalidad"=> $resp->nacionalidad ? $resp->nacionalidad: null ,
                                    ":municipioEmpadronamiento"=>$resp->municipioEmpadronamiento ? $resp->municipioEmpadronamiento: null,
                                    ":paisNacimiento"=>$resp->paisNacimiento ? $resp->paisNacimiento: null,
                                    ":provinciaNacimiento"=>$resp->provinciaNacimiento ? $resp->provinciaNacimiento: null,
                                    ":municipioNacimiento"=>$resp->municipioNacimiento ? $resp->municipioNacimiento: null,
                                    ":sexoEv"=>$resp->sexoEv,
                                    ":sexo"=>null,
                                    ":orientacionSexual"=>$resp->orientacionSexual,
                                    ":numeroSS"=>$resp->numeroSS,
                                    ":estadoCivil"=>$resp->estadoCivil,
                                    ":edad"=>$resp->edad,
                                    ":tecnico"=>$idTecnico,
                                    ":fechaActual"=>date("Y-m-d H:i:s")
                                ];
                                
        $valoresExpedientesPersonales = [":id_expediente"=>$resp->id_expediente,
                                    ":fechaExpediente"=>$resp->fechaExpediente,
                                    ":formaIngreso"=>$resp->formaIngreso,
                                    ":origenIngreso"=>$resp->origenIngreso,
                                    ":fechaEmpadronamiento"=>$resp->fechaEmpadronamiento,
                                    ":nacionalidad"=>$resp->nacionalidad,
                                    ":municipioEmpadronamiento"=>$resp->municipioEmpadronamiento,
                                    ":telefono"=>$resp->telefono,
                                    ":email"=>$resp->email,
                                    ":sexoEv"=>$resp->sexoEv,
                                    ":sexo"=>null,
                                    ":orientacionSexual"=>$resp->orientacionSexual,
                                    ":numeroSS"=>$resp->numeroSS,
                                    ":estadoCivil"=>$resp->estadoCivil,
                                    ":numeroasSNS"=>$resp->nAsistenciaSanitariaServicioNacionalSalud,
                                    ":asistenciaSanitaria"=>$resp->asistenciaSanitaria,
                                    ":renovacionPermisoResidencia"=>$resp->renovacionPermisoResidencia,
                                    ":tipoPermisoResidencia"=>$resp->tipoPermisoResidencia,
                                    ":tecnico"=>$idTecnico,
                                    ":fechaActual"=>date("Y-m-d H:i:s")
                                ];

        if($valoresExpedientesPersonales[':formaIngreso']=='1'){
            $valoresExpedientesPersonales[':origenIngreso']=null;
        }
        if($valoresExpedientesPersonales[':fechaExpediente']==''){
            $valoresExpedientesPersonales[':fechaExpediente'] = date("Y-m-d H:i:s");
            $valoresFichasPersonas[':fechaExpediente'] = date("Y-m-d H:i:s");
            updatedCampoCreated($conexion, $idTecnico, $resp->id_expediente);
        }
        if($valoresExpedientesPersonales[':sexoEv'] == '1' || $valoresExpedientesPersonales[':sexoEv'] == '2' || $valoresExpedientesPersonales[':sexoEv'] == '3'){
            $valoresExpedientesPersonales[':sexo'] = 1;
            $valoresFichasPersonas[':sexo'] = 1;
        }elseif($valoresExpedientesPersonales[':sexoEv'] == '4' || $valoresExpedientesPersonales[':sexoEv'] == '5' || $valoresExpedientesPersonales[':sexoEv'] == '6'){
            $valoresExpedientesPersonales[':sexo'] = 2;
            $valoresFichasPersonas[':sexo'] = 2;

        }
        $valoresDocumentosIdentificacion=[
            "id_expediente"=>$resp->id_expediente,
            "documentacion"=>$resp->documentacion,
            "documentacionPerdida"=>$resp->documentacionPerdida
        ];

        return json_encode([
                'updateFichasPersonas'=>updateFichasPersonasFromIdentifyingDataForm($conexion,$valoresFichasPersonas),
                'updateExpedientes'=>updateExpedientesFromIdentifyingDataForm($conexion, $valoresExpedientesPersonales),
                'updateDocumentacion'=>updateIdentificationDocumentFromIdentifyingDataForm($conexion, $valoresDocumentosIdentificacion,$idTecnico),
                'arrayDocumentacion' => $valoresDocumentosIdentificacion]
            );
       
    }
    function updatedCampoCreated($conexion, $idTecnico, $id_expediente){
        $consulta = $conexion->prepare("UPDATE fichas_personas, expedientes_evaluacion, registro SET
                                        expedientes_evaluacion.idUsuario_created_at = :tecnico,
                                        expedientes_evaluacion.created_at = :fechaActual
                                        WHERE fichas_personas.id =
                                        (SELECT registro.idFichaPersona WHERE registro.id =
                                            (SELECT expedientes_evaluacion.idRegistro WHERE expedientes_evaluacion.id = :id_expediente))");
        $consulta->execute([":tecnico"=>$idTecnico,
                            ":fechaActual"=>date("Y-m-d H:i:s"),
                            ":id_expediente"=>$id_expediente]);
        return $consulta->errorInfo();
    }
    function updateFichasPersonasFromIdentifyingDataForm($conexion,$valoresFichasPersonas){
        $consulta = $conexion->prepare("UPDATE fichas_personas, expedientes_evaluacion, registro SET
                                         fichas_personas.nombre = :nombre,
                                         fichas_personas.apellido1 = :apellido1,
                                         fichas_personas.apellido2 = :apellido2,
                                         fichas_personas.fecha_evaluacion = :fechaExpediente, 
                                         fichas_personas.fecha_nacimiento = :fechaNacimiento,
                                         fichas_personas.edad = :edad,
                                         fichas_personas.fecha_empadronamiento = :fechaEmpadronamiento,
                                         fichas_personas.telefono = :telefono,
                                         fichas_personas.email = :email,
                                         fichas_personas.idNacionalidad = :nacionalidad,
                                         fichas_personas.idPoblacionEmpadronamiento = :municipioEmpadronamiento,
                                         fichas_personas.idPaisNacimiento = :paisNacimiento,
                                         fichas_personas.idProvinciaNacimiento = :provinciaNacimiento,
                                         fichas_personas.idPoblacionNacimiento = :municipioNacimiento,
                                         fichas_personas.idSexoEv = :sexoEv,
                                         fichas_personas.idSexo = :sexo,
                                         fichas_personas.idOrientacionSexual = :orientacionSexual,
                                         fichas_personas.numero_ss = :numeroSS,
                                         fichas_personas.idEstadoCivil = :estadoCivil,
                                         fichas_personas.idUsuario_updated_at = :tecnico,
                                         fichas_personas.updated_at = :fechaActual
                                          WHERE fichas_personas.id =
                                            (SELECT registro.idFichaPersona WHERE registro.id =
                                                (SELECT expedientes_evaluacion.idRegistro WHERE expedientes_evaluacion.id = :id_expediente))");
        $consulta->execute($valoresFichasPersonas);
        return $consulta->errorInfo();
    }
    function updateExpedientesFromIdentifyingDataForm($conexion,$valoresExpedientesPersonales){
        $consulta = $conexion->prepare("UPDATE expedientes_evaluacion SET
                                        expedientes_evaluacion.fecha_evaluacion = :fechaExpediente,
                                        expedientes_evaluacion.idFormaIngreso = :formaIngreso,
                                        expedientes_evaluacion.idOrigenIngreso = :origenIngreso,
                                        expedientes_evaluacion.fecha_empadronamiento = :fechaEmpadronamiento,
                                        expedientes_evaluacion.idNacionalidad = :nacionalidad,
                                        expedientes_evaluacion.idPoblacionEmpadronamiento = :municipioEmpadronamiento,
                                        expedientes_evaluacion.telefono = :telefono,
                                        expedientes_evaluacion.email = :email,
                                        expedientes_evaluacion.idSexoEv = :sexoEv,
                                        expedientes_evaluacion.idSexo = :sexo,
                                        expedientes_evaluacion.idOrientacionSexual = :orientacionSexual,
                                        expedientes_evaluacion.numero_ss = :numeroSS,
                                        expedientes_evaluacion.idEstadoCivil = :estadoCivil,
                                        expedientes_evaluacion.idPermisoResidencia = :tipoPermisoResidencia,
                                        expedientes_evaluacion.renovacionPermisoPermanencia = :renovacionPermisoResidencia,
                                        expedientes_evaluacion.numero_asSNS = :numeroasSNS,
                                        expedientes_evaluacion.asistenciaSanitaria = :asistenciaSanitaria,
                                        expedientes_evaluacion.idUsuario_updated_at = :tecnico,
                                        expedientes_evaluacion.updated_at = :fechaActual
                                        WHERE expedientes_evaluacion.id = :id_expediente");
        $consulta->execute($valoresExpedientesPersonales);
        return $consulta->errorInfo();
    }

    function updateIdentificationDocumentFromIdentifyingDataForm($conexion, $valoresDocumentosIdentificacion, $idTecnico){
        $id_expediente = $valoresDocumentosIdentificacion["id_expediente"];
        $documentacionQuePosee = obtenerIdDocumentacionDelExpediente($conexion, $id_expediente);
        $idFichaPersonal = obtenerIdFichaPersonalByExpediente($conexion, $id_expediente);
        $respuestaBD = array();
        
        if(isset($valoresDocumentosIdentificacion["documentacion"]->documentacion)){
            foreach( $valoresDocumentosIdentificacion["documentacion"]->documentacion as $documento){
                if(in_array($documento->tipo, $documentacionQuePosee)){
                    $consulta = $conexion->prepare("UPDATE inf_id_documentacion set 
                                                inf_id_documentacion.numero_documento = :numero,
                                                inf_id_documentacion.idTipoAusenciaDocumento = null,
                                                inf_id_documentacion.numero_denuncia = null 
                                                WHERE inf_id_documentacion.idTipoDocumento = :tipo 
                                                AND inf_id_documentacion.idFichaPersonal = 
                                                    (SELECT registro.idFichaPersona FROM registro WHERE registro.id = 
                                                        (SELECT expedientes_evaluacion.idRegistro FROM expedientes_evaluacion WHERE id = :id_expediente))");
                                                 
                    $consulta->execute([":numero"=>$documento->numero, ":tipo"=>$documento->tipo, ":id_expediente"=>$id_expediente]);
                    array_push($respuestaBD, ["respuestaPara"=>$documento->tipo, "tipoConsulta" => 'update', "respuesta"=>$consulta->errorInfo()]);
                }else{
                    $consulta = $conexion->prepare("INSERT INTO inf_id_documentacion (idFichaPersonal, idTipoDocumento, numero_documento, created_at, updated_at, idUsuario_created_at, idUsuario_updated_at) 
                                                    VALUES (:idFichaPersonal, :idTipoDocumento, :numero, :idTecnico, :idTecnico, :idTecnico, :idTecnico)");   
                    $consulta->execute([":idFichaPersonal"=>$idFichaPersonal, ":idTipoDocumento"=>$documento->tipo, ":numero"=>$documento->numero, ":idTecnico"=>$idTecnico]);
                    array_push($respuestaBD, ["respuestaPara"=>$documento->tipo, "tipoConsulta" => 'insert', "respuesta"=>$consulta->errorInfo()]);
                }
            }
        }

        if(isset($valoresDocumentosIdentificacion["documentacion"]->otraDocumentacion)){
            $tipoOtraDocumentacion = $valoresDocumentosIdentificacion["documentacion"]->otraDocumentacion->tipo;
            $numeroOtraDocumentacion = $valoresDocumentosIdentificacion["documentacion"]->otraDocumentacion->numero;
            $consulta = $conexion->prepare("SELECT id, documento FROM t_tipos_documento WHERE documento = :documento ");
            $consulta->execute([":documento"=>$tipoOtraDocumentacion]);
            $resultado = $consulta->fetch();

            if($resultado){
                $idTipoDocumento = $resultado["id"];
            }else{
                $consulta = $conexion->prepare("INSERT INTO t_tipos_documento(documento) values (:tipo) ");
                $consulta->execute([":tipo"=>$tipoOtraDocumentacion]);
                $idTipoDocumento = $conexion->lastInsertId();
                array_push($respuestaBD, ["respuestaPara"=>$tipoOtraDocumentacion, "tipoConsulta" => 'insert', "respuesta"=>$consulta->errorInfo()]);
            }

            if(in_array($idTipoDocumento, $documentacionQuePosee)){
                $consulta = $conexion->prepare("UPDATE inf_id_documentacion set 
                                                inf_id_documentacion.numero_documento = :numero,
                                                inf_id_documentacion.idTipoAusenciaDocumento = null,
                                                inf_id_documentacion.numero_denuncia = null 
                                                WHERE inf_id_documentacion.idTipoDocumento = :tipo 
                                                AND inf_id_documentacion.idFichaPersonal = 
                                                    (SELECT registro.idFichaPersona FROM registro WHERE registro.id = 
                                                        (SELECT expedientes_evaluacion.idRegistro FROM expedientes_evaluacion WHERE id = :id_expediente))");
                                                 
                $consulta->execute([":numero"=>$numeroOtraDocumentacion, ":tipo"=>$idTipoDocumento, ":id_expediente"=>$id_expediente]);
                array_push($respuestaBD, ["respuestaPara"=>$idTipoDocumento, "tipoConsulta" => 'update', "respuesta"=>$consulta->errorInfo()]);
            }else{
                $consulta = $conexion->prepare("INSERT INTO inf_id_documentacion (idFichaPersonal, idTipoDocumento, numero_documento, created_at, updated_at, idUsuario_created_at, idUsuario_updated_at) 
                                                        VALUES (:idFichaPersonal, :idTipoDocumento, :numero, :idTecnico, :idTecnico, :idTecnico, :idTecnico)");   
                $consulta->execute([":idFichaPersonal"=>$idFichaPersonal, ":idTipoDocumento"=>$idTipoDocumento, ":numero"=>$numeroOtraDocumentacion, ":idTecnico"=>$idTecnico]);
                array_push($respuestaBD, ["respuestaPara"=>$numeroOtraDocumentacion, "tipoConsulta" => 'insert', "respuesta"=>$consulta->errorInfo()]);
            }
        }
        return insertarDocumentacionPerdida($valoresDocumentosIdentificacion["documentacionPerdida"], $documentacionQuePosee, $conexion, $idFichaPersonal, $idTecnico);
       
        return $respuestaBD;
    }

    function obtenerIdDocumentacionDelExpediente($conexion,$id_expediente){
        $consulta = $conexion->prepare("SELECT inf_id_documentacion.idTipoDocumento FROM inf_id_documentacion WHERE inf_id_documentacion.idFichaPersonal = 
                                (SELECT registro.idFichaPersona FROM registro WHERE registro.id =
                                    (SELECT expedientes_evaluacion.idRegistro FROM expedientes_evaluacion WHERE id = :idExpediente))");
        $consulta->execute([":idExpediente"=>$id_expediente]);
        $documentacionQuePosee = $consulta->fetchAll();
        $documentacionQuePoseeArray = array();
        foreach ($documentacionQuePosee as $documento){
            array_push($documentacionQuePoseeArray, $documento["idTipoDocumento"]);
        }
        return $documentacionQuePoseeArray;
    }

    function insertarDocumentacionPerdida($documentacionPerdida, $docQuePosee, $conexion, $idFichaPersonal, $idTecnico){
        if(isset($documentacionPerdida)){
            foreach($documentacionPerdida as $documento){
                if(in_array($documento->tipo, $docQuePosee)){
                    updateInfIdDocumentacion($conexion, null, $documento->motivoPerdida, null, $documento->tipo, $idFichaPersonal);
                }else{
                    $consulta = $conexion->prepare("INSERT INTO inf_id_documentacion (idFichaPersonal, idTipoDocumento, numero_documento, idTipoAusenciaDocumento, created_at, updated_at, idUsuario_created_at, idUsuario_updated_at) 
                                    VALUES (:idFichaPersonal, :idTipoDocumento, :numero, :idTipoAusenciaDocumento, :idTecnico, :idTecnico, :idTecnico, :idTecnico)");   
                    $consulta->execute([":idFichaPersonal"=>$idFichaPersonal,
                                        ":idTipoDocumento"=>$documento->tipo,
                                        ":numero"=>null,
                                        "idTipoAusenciaDocumento"=> $documento->motivoPerdida,
                                        ":idTecnico"=>$idTecnico]);
                }
            }
        }
    }
    
    function updateInfIdDocumentacion($conexion, $numeroDocumento, $idTipoAusenciaDocumento, $numero_denuncia, $idTipoDocumento, $idFichaPersonal){
        $consulta = $conexion->prepare("UPDATE inf_id_documentacion set 
                                        inf_id_documentacion.numero_documento = :numeroDocumento,
                                        inf_id_documentacion.idTipoAusenciaDocumento = :motivoAusencia,
                                        inf_id_documentacion.numero_denuncia = :numeroDenuncia
                                        WHERE inf_id_documentacion.idTipoDocumento = :tipoDocumento 
                                        AND inf_id_documentacion.idFichaPersonal = :idFichaPersonal");
        $consulta->execute([
            ":numeroDocumento"=> $numeroDocumento,
            ":motivoAusencia"=> $idTipoAusenciaDocumento,
            ":numeroDenuncia"=> $numero_denuncia,
            ":tipoDocumento"=> $idTipoDocumento,
            ":idFichaPersonal"=> $idFichaPersonal]);

        return $consulta->errorInfo();
    }
    function insertInfIdDocumentacion($conexion){
        $consulta = $conexion->prepare("INSERT INTO inf_id_documentacion (idFichaPersonal, idTipoDocumento, numero_documento, created_at, updated_at, idUsuario_created_at, idUsuario_updated_at) 
                    VALUES (:idFichaPersonal, :idTipoDocumento, :numero, :idTecnico, :idTecnico, :idTecnico, :idTecnico)");   
        $consulta->execute([":idFichaPersonal"=>$idFichaPersonal, ":idTipoDocumento"=>$idTipoDocumento, ":numero"=>$numeroOtraDocumentacion, ":idTecnico"=>$idTecnico]);
        array_push($respuestaBD, ["respuestaPara"=>$numeroOtraDocumentacion, "tipoConsulta" => 'insert', "respuesta"=>$consulta->errorInfo()]);
    }
   

?>