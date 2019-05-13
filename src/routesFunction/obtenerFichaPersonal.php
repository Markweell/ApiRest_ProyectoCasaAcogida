<?php

function obtenerFichaPersonal($response, $request, $next){
    if(!validarToken(getTokenOfHeader()))
        return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $id = $resp->id;
    $consulta = $conexion->prepare(
        'SELECT 
            fichas_personas.*,
            t_paises1.nacionalidad,
            t_sexo.sexo,
            t_paises2.nacionalidad as "lugarNacimiento"
        FROM fichas_personas 
            LEFT JOIN t_paises AS t_paises1 
                ON fichas_personas.idNacionalidad = t_paises1.id 
            LEFT JOIN t_sexo 
                ON fichas_personas.idSexo = t_sexo.id 
            LEFT JOIN t_paises AS t_paises2 
                ON fichas_personas.idPaisNacimiento = t_paises2.id 
        WHERE fichas_personas.id = :id');
        
    $consulta->execute([':id'=>$id]);
    $resultadoMainData=$consulta->fetchAll();

    if($resultadoMainData)
        return json_encode(["status"=>"OPERATION_SUCCESS",
                            "data" =>['mainData'=>$resultadoMainData]]);
}
?>