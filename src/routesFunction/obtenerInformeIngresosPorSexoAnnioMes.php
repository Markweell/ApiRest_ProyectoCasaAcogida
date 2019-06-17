<?php
function obtenerInformeIngresosPorSexoAnnioMes($response, $request, $next){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    setlocale(LC_TIME, 'es_ES');
    $array = [];
    $arrayHombres = [];
    $arrayMujeres = [];
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $annio = $resp->annio;
    for ($i = 1; $i <= 12; $i++) {
        $consulta = $conexion->prepare('SELECT MONTHNAME(registro.fecha_ingreso) mes , COUNT(registro.id) hombres from registro, fichas_personas, t_sexo where registro.idFichaPersona = fichas_personas.id AND fichas_personas.idSexo = t_sexo.id AND fichas_personas.idSexo = 1 AND YEAR(registro.fecha_ingreso) = :annio AND MONTH(registro.fecha_ingreso) = :mes GROUP BY MONTH(registro.fecha_ingreso)');
        $consulta->execute([":annio"=>$annio, ":mes"=>$i]);
        $resultadoBusqueda=$consulta->fetchAll();
        if($resultadoBusqueda)
            array_push($arrayHombres, $resultadoBusqueda[0]);
        else{
            array_push($arrayHombres, [ "mes"=> obtenerMes($i), "hombres"=>0]);
        }
    }
    array_push($array, $arrayHombres);
    for ($i = 1; $i <= 12; $i++) {
        $consulta = $conexion->prepare('SELECT MONTHNAME(registro.fecha_ingreso) mes, COUNT(registro.id) mujeres from registro, fichas_personas, t_sexo where registro.idFichaPersona = fichas_personas.id AND fichas_personas.idSexo = t_sexo.id AND fichas_personas.idSexo = 2 AND YEAR(registro.fecha_ingreso) = :annio AND MONTH(registro.fecha_ingreso) = :mes GROUP BY MONTH(registro.fecha_ingreso)');
    $consulta->execute([":annio"=>$annio, ":mes"=>$i]);
    $resultadoBusqueda=$consulta->fetchAll();
        if($resultadoBusqueda)
            array_push($arrayMujeres, $resultadoBusqueda[0]);
        else{
            array_push($arrayMujeres, [ "mes"=> obtenerMes($i), "mujeres"=>0]);
        }
    }
    
    array_push($array, $arrayMujeres);
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $array]);
}
function obtenerMes($numero){
    setlocale(LC_TIME, 'es_ES');
    $fecha = DateTime::createFromFormat('!m', $numero);
    return strtolower(strftime("%B", $fecha->getTimestamp()));
}
?>