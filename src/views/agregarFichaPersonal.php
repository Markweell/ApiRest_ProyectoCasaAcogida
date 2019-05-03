<?php
    /**
     * Registra una ficha personal
     */
    function agregarFichaPersonal($response, $request, $next){
        if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $valores = obtenerDatos($response);
        if(comprobarDniExistente($conexion,$valores['dni']))
            return json_encode(["status"=>"DOCUMENTATION_EXISTS"]);

        $id_Ficha_Personal = getLastIdFichaPersonal($conexion);
        $urlImagen = getUrlImagen($valores['image'], $id_Ficha_Personal);

        if(
            insertarUsuario($valores, $conexion, $urlImagen) 
            && insertarFechas($valores, $conexion, $id_Ficha_Personal)
            ){
            auditChange(
                $conexion,
                getIdOfToken(getTokenOfHeader()),
                $id_Ficha_Personal,
                "INSERT");
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
        $nombre = $resp->nombre;              
        $apellidos = $resp->apellidos;
        $dni = $resp->dni;
        $image = $resp->image;
        $fechaEntrada = $resp->fechaEntrada;
        return ['nombre'=>$nombre,'apellidos'=>$apellidos , 'dni'=> $dni, 'image'=>$image, 'fechaEntrada'=>$fechaEntrada];
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
        $res=$conexion->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'api_proyecto_php' AND TABLE_NAME = 'ficha_personal'");
        $res->execute();
        $rows = $res->fetch();
        return $rows['AUTO_INCREMENT'];
    }

    /**
     * Inserta una ficha personal en la base de datos
     */
    function insertarUsuario($valores, $conexion, $urlImagen){
        $valoresConsulta = [":nombre"=>$valores['nombre'], ":apellidos"=>$valores['apellidos'],":dni"=>$valores['dni'],":image"=>$urlImagen];
        $consulta = $conexion->prepare('INSERT INTO ficha_personal(id, nombre, apellidos, dni, image) 
        VALUES (NULL, :nombre, :apellidos, :dni, :image)');
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