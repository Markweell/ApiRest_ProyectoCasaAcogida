<?php
function obtenerInformeIngresosPorSexoAnnio($response, $request, $next){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $annio = $resp->annio;
    $consulta = $conexion->prepare('SELECT sexo, COUNT(registro.id) numero from registro, fichas_personas, t_sexo where registro.idFichaPersona = fichas_personas.id AND fichas_personas.idSexo = t_sexo.id AND YEAR(registro.fecha_ingreso) = :annio GROUP BY fichas_personas.idSexo');
    $consulta->execute([":annio"=>$annio]);
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>