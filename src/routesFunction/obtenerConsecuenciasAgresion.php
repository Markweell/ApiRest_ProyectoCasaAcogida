<?php

function obtenerConsecuenciasAgresionFisicas(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM e_consecuencias_agresiones WHERE tipo = "Física" ');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}

function obtenerConsecuenciasAgresionPsicologicas(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM e_consecuencias_agresiones  WHERE tipo = "Psicológica" ');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}

function obtenerConsecuenciasAgresionSocioEconomicas(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM e_consecuencias_agresiones  WHERE tipo = "Socioeconómica" ');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>