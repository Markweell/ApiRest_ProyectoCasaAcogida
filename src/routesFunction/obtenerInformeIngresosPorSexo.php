<?php
function obtenerInformeIngresosPorSexo(){
    if(!validarToken(getTokenOfHeader()))
            return json_encode(["status"=>"SESSION_EXPIRED"]);
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT sexo, COUNT(registro.id) numero from registro, fichas_personas, t_sexo where registro.idFichaPersona = fichas_personas.id AND fichas_personas.idSexo = t_sexo.id GROUP BY fichas_personas.idSexo');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode(["status"=>"OPERATION_SUCCESS", "data" => $resultadoBusqueda]);
}
?>