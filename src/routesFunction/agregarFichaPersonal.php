<?php
    /**
     * Registra una ficha personal
     */
    function agregarFichaPersonal($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);

        $conexion = \Conexion::getConnection();

        $valores = obtenerDatos($response);
        $valoresCreated = getDatosCreatedAndUpdated(); 
        $id_ficha_personal = getLastIdFichaPersonal($conexion);
        $urlImagen = getUrlImagen($valores['image'], $id_ficha_personal);

        if(
            insertarUsuario($valores,$valoresCreated, $conexion, $urlImagen) &
            agregaDocumentacionUsuario($valores, $valoresCreated, $conexion, $id_ficha_personal)){
                return json_encode(["status"=>"OPERATION_SUCCESS", "data"=>["id"=>$id_ficha_personal, 
                "name"=> $valores['nombre'].' '.$valores['apellido1'].' '.$valores['apellido2']]]);
        }else
            return json_encode(["status"=>"OPERATION_ERROR"]);
    }

    /**
     * Obtiene los datos que le llegan a la petición post y los devuelve como un array.
     */
    function obtenerDatos($response){
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
    }
    /**
     * Define la url donde se aloja la foto y construlle el nombre de la foto en base al id de la ficha personal
     */
    function getUrlImagen($image, $id_ficha_personal){
        if($image==''){
            return URL_IMAGE.'image/StandarProfile.png';
        }else{
            decodeBase64Image($image, $id_ficha_personal);
            return URL_IMAGE.'image/imagenPerfil'.$id_ficha_personal.'.'.getExtension(substr($image, 11,1));
        }
    }
    /**
     * Obtiene el último id de la tabla ficha_personal
     */
    function getLastIdFichaPersonal($conexion){
        $res=$conexion->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'api_proyecto_php' AND TABLE_NAME = 'fichas_personas'");
        $res->execute();
        $rows = $res->fetch();
        return $rows['AUTO_INCREMENT'];
    }

    /**
     * Inserta una ficha personal en la base de datos
     */
    function insertarUsuario($valores, $valoresCreated, $conexion, $urlImagen){

        $valoresConsulta = [":nombre"=>$valores['nombre'], ":apellido1"=>$valores['apellido1'],
        ":apellido2"=>$valores['apellido2'],":fechaNacimiento"=>$valores['fechaNacimiento'],
        ":lugarNacimiento"=>$valores['lugarNacimiento'],":sexo"=>$valores['sexo'],
        ":nacionalidad"=>$valores['nacionalidad'],":observaciones"=>$valores['observaciones'],
        ":image"=>$urlImagen, ":created_at"=>$valoresCreated['date'],
        ":idUsuario_created_at"=>$valoresCreated["user"]];

        $consulta = $conexion->prepare('INSERT INTO fichas_personas(apellido1,apellido2,nombre,
        fecha_nacimiento,image,idNacionalidad,idPaisNacimiento,idSexo,observaciones,created_at,
        idUsuario_created_at,updated_at, idUsuario_updated_at) 
        VALUES (:apellido1,:apellido2,:nombre,:fechaNacimiento,:image,:nacionalidad,:lugarNacimiento,
        :sexo,:observaciones,:created_at,:idUsuario_created_at,:created_at,:idUsuario_created_at)');

        return $consulta->execute($valoresConsulta); 
    }

    function agregaDocumentacionUsuario($valores, $valoresCreated,$conexion,$id_ficha_personal){
        if($valores['document'] == [""] || $valores['documentType'] == [""]){
            return true;
        }
        foreach($valores['document'] as $key=>$document){
            $valoresConsulta = [':idFichaPersonal'=>$id_ficha_personal,':documentType'=>$valores['documentType'][$key],
            ':document'=>$document, ':created_at'=>$valoresCreated['date'], ":idUsuario_created_at"=>$valoresCreated["user"] ];
            $consulta = $conexion->prepare('INSERT INTO inf_id_documentacion(idFichaPersonal, idTipoDocumento,
            numero_documento, created_at, updated_at, idUsuario_created_at, idUsuario_updated_at) 
            VALUES (:idFichaPersonal, :documentType, :document, :created_at, :created_at, :idUsuario_created_at, :idUsuario_created_at)');
            if(!($consulta->execute($valoresConsulta))){
                return false;
            }
        }
        return true; 

    }

?>