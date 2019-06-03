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
                                    ":orientacionSexual"=>$resp->orientacionSexual,
                                    ":numeroSS"=>$resp->numeroSS,
                                    ":estadoCivil"=>$resp->estadoCivil
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
                                        ":orientacionSexual"=>$resp->orientacionSexual,
                                        ":numeroSS"=>$resp->numeroSS,
                                        ":estadoCivil"=>$resp->estadoCivil
                                    ];

        if($valoresExpedientesPersonales[':formaIngreso']=='1'){
            $valoresExpedientesPersonales[':origenIngreso']=null;
        }
        if($valoresExpedientesPersonales[':fechaExpediente']==''){
            $valoresExpedientesPersonales[':fechaExpediente'] = date("Y-m-d");
        }
        $valoresDocumentosIdentificacion=[
            "documentacion"=>$resp->documentacion,
            "documentacionPerdida"=>$resp->documentacionPerdida,
            "tarjetaSanitaria"=>$resp->tarjetaSanitaria,
            "motivoAusenciaTarjetaSanitaria"=>$resp->motivoAusenciaTarjetaSanitaria
        ];

        updateFichasPersonasFromIdentifyingDataForm($conexion,$valoresFichasPersonas);
        updateExpedientesFromIdentifyingDataForm($conexion, $valoresExpedientesPersonales);
        updateIdentificationDocumentFromIdentifyingDataForm($conexion, $valoresDocumentosIdentificacion);
        return json_encode(
                ['updateFichasPersonas'=>updateFichasPersonasFromIdentifyingDataForm($conexion,$valoresFichasPersonas),
                'updateExpedientes'=>updateExpedientesFromIdentifyingDataForm($conexion, $valoresExpedientesPersonales),
                'updateDocumentacion'=>updateIdentificationDocumentFromIdentifyingDataForm($conexion, $valoresDocumentosIdentificacion)]
            );
       
    }
    
    function updateFichasPersonasFromIdentifyingDataForm($conexion,$valoresFichasPersonas){
        $consulta = $conexion->prepare("UPDATE fichas_personas, expedientes_evaluacion, registro SET
                                         fichas_personas.nombre = :nombre,
                                         fichas_personas.apellido1 = :apellido1,
                                         fichas_personas.apellido2 = :apellido2,
                                         fichas_personas.fecha_nacimiento = :fechaNacimiento,
                                         fichas_personas.fecha_empadronamiento = :fechaEmpadronamiento,
                                         fichas_personas.telefono = :telefono,
                                         fichas_personas.email = :email,
                                         fichas_personas.idNacionalidad = :nacionalidad,
                                         fichas_personas.idPoblacionEmpadronamiento = :municipioEmpadronamiento,
                                         fichas_personas.idPaisNacimiento = :paisNacimiento,
                                         fichas_personas.idProvinciaNacimiento = :provinciaNacimiento,
                                         fichas_personas.idPoblacionNacimiento = :municipioNacimiento,
                                         fichas_personas.idSexoEv = :sexoEv,
                                         fichas_personas.idOrientacionSexual = :orientacionSexual,
                                         fichas_personas.numero_ss = :numeroSS,
                                         fichas_personas.idEstadoCivil = :estadoCivil
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
                                        expedientes_evaluacion.idOrientacionSexual = :orientacionSexual,
                                        expedientes_evaluacion.numero_ss = :numeroSS,
                                        expedientes_evaluacion.idEstadoCivil = :estadoCivil
                                        WHERE expedientes_evaluacion.id = :id_expediente");
        $consulta->execute($valoresExpedientesPersonales);
        return $consulta->errorInfo();
    }

    function updateIdentificationDocumentFromIdentifyingDataForm($conexion, $valoresDocumentosIdentificacion){
        // $consulta = $conexion->prepare("");
        // $consulta->execute($valoresDocumentosIdentificacion);
        // return $consulta->errorInfo();
    }

?>