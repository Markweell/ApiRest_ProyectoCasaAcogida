<?php

function obtenerFichaPersonal($response, $request, $next){
    if(!validarToken(getTokenOfHeader()))
        return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $id = $resp->id;
    $consulta = $conexion->prepare('SELECT * FROM fichas_personas WHERE id = :id');
    $consulta->execute([':id'=>$id]);
    $resultadoMainData=$consulta->fetchAll();
    if($resultadoMainData===[])
        return json_encode(["status"=>"DATA_EMPTY"]);
    if($resultadoMainData[0]['idNacionalidad']){
        $resultadoMainData[0]['nacionalidad'] = subConsulta($conexion,'nacionalidad','t_paises',$resultadoMainData[0]['idNacionalidad'])['nacionalidad'];
    }
    if($resultadoMainData[0]['idPaisNacimiento']){
        $resultadoMainData[0]['paisNacimiento'] = subConsulta($conexion,'nacionalidad','t_paises',$resultadoMainData[0]['idPaisNacimiento'])['nacionalidad'];
    }
    if($resultadoMainData[0]['idSexo']){
        $resultadoMainData[0]['sexo'] = subConsulta($conexion,'sexo','t_sexo',$resultadoMainData[0]['idSexo'])['sexo'];
    }
    if($resultadoMainData)
        return json_encode(["status"=>"OPERATION_SUCCESS", "data" =>['mainData'=>$resultadoMainData]]);
}
function subConsulta($conexion,$campo,$tabla,$id){
    $consulta = $conexion->prepare('SELECT '.$campo.' FROM '.$tabla.' WHERE id = :id');
    $consulta->execute([':id'=>$id]);
    $resultadoConsulta=$consulta->fetchAll();
    return $resultadoConsulta[0];
}
?>