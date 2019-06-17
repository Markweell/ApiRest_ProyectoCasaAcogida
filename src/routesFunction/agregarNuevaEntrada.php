<?php
    /**
     * Crea una nueva entrada
     */
    function agregarNuevaEntrada($response, $request, $next){
        // if(!validarToken(getTokenOfHeader()))
        //     return json_encode(["status"=>"SESSION_EXPIRED"]);
        $conexion = \Conexion::getConnection();
        $valores = obtenerDatosNuevaEntrada($response);
        // if(comprobarDniExistente($conexion,$valores['dni']))
        //     return json_encode(["status"=>"DOCUMENTATION_EXISTS"]);
        

        if(insertarRegistro($valores, $conexion)){
            $idRegistro = $conexion->lastInsertId();
            if(insertarCama($valores, $idRegistro, $conexion))
                return json_encode(["status"=>"OPERATION_SUCCESS"]);
            else
                return json_encode(["status"=>"OPERATION_ERROR"]);
        }else
            return json_encode(["status"=>"OPERATION_ERROR"]);
    }
    /**
     * Obtiene los datos que le llegan a la petición post y los devuelve como un array.
     */
    function obtenerDatosNuevaEntrada($response){
        $resp = json_decode($response->getBody());
        $fecha_ingreso = $resp->entryDate." ".$resp->entryHour;              
        $created_updated = date("Y-m-d H:i:s");
        $idBed = $resp->idBed;
        $idConserje = $resp->idConserje;
        $idPersonalFile = $resp->idPersonalFile;
        $idRoom = $resp->idRoom;

        return [
            'fecha_ingreso'=>$fecha_ingreso,
            'created_updated'=>$created_updated,
            'fecha_inicio'=> $resp->entryDate,
            'idBed'=>$idBed,
            'idConserje'=>$idConserje,
            'idPersonalFile'=>$idPersonalFile,
            'idRoom'=>$idRoom];
    }

    // /**
    //  * Obtiene el último id de la tabla ficha_personal
    //  */
    // function getLastIdRegistro($conexion){
    //     $res=$conexion->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'api_proyecto_php' AND TABLE_NAME = 'fichas_personas'");
    //     $res->execute();
    //     $rows = $res->fetch();
    //     return $rows['AUTO_INCREMENT'];
    // }

    /**
     * Inserta un registro de entrada
     */
    function insertarRegistro($valores, $conexion){
        $valoresConsulta = [ 
            ":fecha_ingreso"=>$valores['fecha_ingreso'], 
            ":created_updated"=>$valores['created_updated'],
            ":idUsuario_created_updated"=>$valores['idConserje'],
            ":idFichaPersona"=>$valores['idPersonalFile']];

        $consulta = $conexion->prepare('INSERT INTO registro(idFichaPersona,fecha_ingreso,
        created_at,updated_at,idUsuario_created_at,idUsuario_updated_at) 
        VALUES (:idFichaPersona,:fecha_ingreso,:created_updated,:created_updated,:idUsuario_created_updated,:idUsuario_created_updated)');
        return $consulta->execute($valoresConsulta);
    }
?>