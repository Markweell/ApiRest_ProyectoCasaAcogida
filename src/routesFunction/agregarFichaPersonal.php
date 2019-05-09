<?php
    /**
     * Registra una ficha personal
     */
    function agregarFichaPersonal($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $valores = obtenerDatos($response);
        // if(comprobarDniExistente($conexion,$valores['dni']))
        //     return json_encode(["status"=>"DOCUMENTATION_EXISTS"]);
        
        $id_Ficha_Personal = getLastIdFichaPersonal($conexion);
        $urlImagen = getUrlImagen($valores['image'], $id_Ficha_Personal);

        if(insertarUsuario($valores, $conexion, $urlImagen)){
            return json_encode(["status"=>"OPERATION_SUCCESS"]);
        }else
            return json_encode(["status"=>"OPERATION_ERROR"]);
    }
    /**
     * Comprueba si existe un dni en la base de datos 
     */
    function comprobarDniExistente($conexion,$dni){
        if($dni==''){
            return false;
        }
        $consulta = $conexion->prepare('SELECT * from ficha_personal where dni=:dni');
        $resultado=$consulta->execute([":dni"=>$dni]);
        return $consulta->fetch();
    }
    /**
     * Obtiene los datos que le llegan a la petición post y los devuelve como un array.
     */
    function obtenerDatos($response){
        $resp = json_decode($response->getBody());
        $nombre = $resp->nombre ;              
        $apellido1 = $resp->apellido1;
        $apellido2 = $resp->apellido2 ? $resp->apellido2 : null;
        $fechaNacimiento = $resp->fechaNacimiento ? $resp->fechaNacimiento : null;
        $lugarNacimiento = $resp->lugarNacimiento ? $resp->lugarNacimiento : null;
        $sexo = $resp->sexo;
        $nacionalidad = $resp->nacionalidad ? $resp->nacionalidad : null;
        $document = $resp->document ? $resp->document : null;
        $documentType = $resp->documentType ? $resp->documentType : null;
        $observaciones = $resp->observaciones ? $resp->observaciones : null;
        $image = $resp->image;

        return ['nombre'=>$nombre,'apellido1'=>$apellido1 ,'apellido2'=>$apellido2,'fechaNacimiento'=>$fechaNacimiento,
        'lugarNacimiento'=>$lugarNacimiento,'sexo'=>$sexo,'nacionalidad'=>$nacionalidad,'document'=>$document,
        'documentType'=>$documentType,'observaciones'=>$observaciones, 'image'=>$image,];
    }
    /**
     * Define la url donde se aloja la foto y construlle el nombre de la foto en base al id de la ficha personal
     */
    function getUrlImagen($image, $id_Ficha_Personal){
        if($image==''){
            return URL_IMAGE.'image/StandarProfile.png';
        }else{
            decodeBase64Image($image, $id_Ficha_Personal);
            return URL_IMAGE.'image/imagenPerfil'.$id_Ficha_Personal.'.'.getExtension(substr($image, 11,1));
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
    function insertarUsuario($valores, $conexion, $urlImagen){
        $valoresConsulta = [":nombre"=>$valores['nombre'], ":apellido1"=>$valores['apellido1'],
        ":apellido2"=>$valores['apellido2'],":fechaNacimiento"=>$valores['fechaNacimiento'],
        ":lugarNacimiento"=>$valores['lugarNacimiento'],":sexo"=>$valores['sexo'],
        ":nacionalidad"=>$valores['nacionalidad'],":observaciones"=>$valores['observaciones'],":image"=>$urlImagen];
        // $valoresConsulta = [":nombre"=>$valores['nombre'],":apellido1"=>$valores['apellido1'],
        // ":apellido2"=>$valores['apellido2']];
        $consulta = $conexion->prepare('INSERT INTO fichas_personas(apellido1,apellido2,nombre,
        fecha_nacimiento,image,idNacionalidad,idPaisNacimiento,idSexo,observaciones) 
        VALUES (:apellido1,:apellido2,:nombre,:fechaNacimiento,:image,:nacionalidad,:lugarNacimiento,:sexo,:observaciones)');
        // $consulta = $conexion->prepare('INSERT INTO fichas_personas(apellido1,apellido2,nombre) 
        // VALUES (:apellido1,:apellido2,:nombre)');
        return $consulta->execute($valoresConsulta);
    }
    /**
     * Inserta la fecha de entrada de la persona.
     */
    function insertarFechas($valores, $conexion, $id_Ficha_Personal){
        $valoresFecha = [":fechaEntrada"=>$valores['fechaEntrada'], ":idFichaPersonal"=>$id_Ficha_Personal];
        $consulta = $conexion->prepare('INSERT INTO fecha_registro (fecha_entrada, id_ficha_personal) 
        VALUES (:fechaEntrada, :idFichaPersonal)');
        return $resultado = $consulta->execute($valoresFecha);
    }

?>