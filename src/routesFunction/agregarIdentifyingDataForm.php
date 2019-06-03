<?php
    /**
     * Registra una ficha personal
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
                                        ":estadoCivil"=>$resp->estadoCivil];
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
        //return json_encode($valoresDocumentosIdentificacion);


        updateFichasPersonasFromIdentifyingDataForm($conexion,$valoresFichasPersonas);
        updateExpedientesFromIdentifyingDataForm($conexion, $valoresExpedientesPersonales);
        return json_encode(['respuesta'=>updateExpedientesFromIdentifyingDataForm($conexion,$valoresExpedientesPersonales), 'datos'=> $valoresExpedientesPersonales]);
        //$valores = obtenerDatosIdentifyingDataForm($response);
        // $valoresCreated = getDatosCreatedAndUpdated(); 
        // $id_ficha_personal = getLastIdFichaPersonal($conexion);
        // $urlImagen = getUrlImagen($valores['image'], $id_ficha_personal);

        // if(
        //     insertarUsuario($valores,$valoresCreated, $conexion, $urlImagen) &
        //     agregaDocumentacionUsuario($valores, $valoresCreated, $conexion, $id_ficha_personal)){
        //         return json_encode(["status"=>"OPERATION_SUCCESS", "data"=>["id"=>$id_ficha_personal, 
        //         "name"=> $valores['nombre'].' '.$valores['apellido1'].' '.$valores['apellido2']]]);
        // }else
        //     return json_encode(["status"=>"OPERATION_ERROR"]);
    }
    // fichas_personas.fecha_nacimiento = :fechaNacimiento,
    // fichas_personas.fecha_empadronamiento = :fechaEmpadronamiento,
    
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
        return $consulta->execute($valoresFichasPersonas);
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

    /**
     * Obtiene los datos que le llegan a la petición post y los devuelve como un array.
     */
    function obtenerDatosIdentifyingDataForm($response){
        $resp = json_decode($response->getBody());
        $nombre = $resp->nombre ;              
        $apellido1 = $resp->apellido1;
        $apellido2 = $resp->apellido2 ? $resp->apellido2 : '';
        $fechaNacimiento = $resp->fechaNacimiento ? $resp->fechaNacimiento : null;
        $lugarNacimiento = $resp->lugarNacimiento ? $resp->lugarNacimiento : null;
        $sexo = $resp->sexo ? $resp->sexo : null;
        $nacionalidad = $resp->nacionalidad ? $resp->nacionalidad : null;
        $document = $resp->document ? $resp->document : null;
        $documentType = $resp->documentType ? $resp->documentType : null;
        $observaciones = $resp->observaciones ? $resp->observaciones : null;
        $image = $resp->image;

        return ['nombre'=>$nombre,'apellido1'=>$apellido1 ,'apellido2'=>$apellido2,'fechaNacimiento'=>$fechaNacimiento,
        'lugarNacimiento'=>$lugarNacimiento,'sexo'=>$sexo,'nacionalidad'=>$nacionalidad,'document'=>$document,
        'documentType'=>$documentType,'observaciones'=>$observaciones, 'image'=>$image];
        // return ['nombre'=>capitalize($nombre),'apellido1'=>capitalize($apellido1) ,'apellido2'=>capitalize($apellido2),'fechaNacimiento'=>$fechaNacimiento,
        // 'lugarNacimiento'=>$lugarNacimiento,'sexo'=>$sexo,'nacionalidad'=>$nacionalidad,'document'=>$document,
        // 'documentType'=>$documentType,'observaciones'=>$observaciones, 'image'=>$image];
    }
    
    // /**
    //  * Obtiene el último id de la tabla ficha_personal
    //  */
    // function getLastIdFichaPersonal($conexion){
    //     $res=$conexion->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'api_proyecto_php' AND TABLE_NAME = 'fichas_personas'");
    //     $res->execute();
    //     $rows = $res->fetch();
    //     return $rows['AUTO_INCREMENT'];
    // }

    // /**
    //  * Inserta una ficha personal en la base de datos
    //  */
    // function insertarUsuario($valores, $valoresCreated, $conexion, $urlImagen){

    //     $valoresConsulta = [":nombre"=>$valores['nombre'], ":apellido1"=>$valores['apellido1'],
    //     ":apellido2"=>$valores['apellido2'],":fechaNacimiento"=>$valores['fechaNacimiento'],
    //     ":lugarNacimiento"=>$valores['lugarNacimiento'],":sexo"=>$valores['sexo'],
    //     ":nacionalidad"=>$valores['nacionalidad'],":observaciones"=>$valores['observaciones'],
    //     ":image"=>$urlImagen, ":created_at"=>$valoresCreated['date'],
    //     ":idUsuario_created_at"=>$valoresCreated["user"]];

    //     $consulta = $conexion->prepare('INSERT INTO fichas_personas(apellido1,apellido2,nombre,
    //     fecha_nacimiento,image,idNacionalidad,idPaisNacimiento,idSexo,observaciones,created_at,
    //     idUsuario_created_at,updated_at, idUsuario_updated_at) 
    //     VALUES (:apellido1,:apellido2,:nombre,:fechaNacimiento,:image,:nacionalidad,:lugarNacimiento,
    //     :sexo,:observaciones,:created_at,:idUsuario_created_at,:created_at,:idUsuario_created_at)');

    //     return $consulta->execute($valoresConsulta); 
    // }

    // function agregaDocumentacionUsuario($valores, $valoresCreated,$conexion,$id_ficha_personal){
    //     if($valores['document'] == [""] || $valores['documentType'] == [""]){
    //         return true;
    //     }
    //     foreach($valores['document'] as $key=>$document){
    //         $valoresConsulta = [':idFichaPersonal'=>$id_ficha_personal,':documentType'=>$valores['documentType'][$key],
    //         ':document'=>$document, ':created_at'=>$valoresCreated['date'], ":idUsuario_created_at"=>$valoresCreated["user"] ];
    //         $consulta = $conexion->prepare('INSERT INTO inf_id_documentacion(idFichaPersonal, idTipoDocumento,
    //         numero_documento, created_at, updated_at, idUsuario_created_at, idUsuario_updated_at) 
    //         VALUES (:idFichaPersonal, :documentType, :document, :created_at, :created_at, :idUsuario_created_at, :idUsuario_created_at)');
    //         if(!($consulta->execute($valoresConsulta))){
    //             return false;
    //         }
    //     }
    //     return true; 

    // }

?>