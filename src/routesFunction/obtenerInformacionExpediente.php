<?php
    function obtenerInformacionExpediente($response, $request, $next){
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $id = $resp->id;
        $valor=[':id'=>$id];

        $consulta = $conexion->prepare(
            'SELECT 
            fichas_personas.*,
            expedientes_evaluacion.*,
            registro.*
        FROM expedientes_evaluacion 
            LEFT JOIN registro
                ON expedientes_evaluacion.idRegistro = registro.id
            LEFT JOIN fichas_personas
                ON registro.idFichaPersona = fichas_personas.id
        WHERE expedientes_evaluacion.id = :id');
        $consulta->execute($valor);
        $resultadoMainData=$consulta->fetchAll();
        $resultadoDocumentacion = obtenerDocumentacionDelExpediente($conexion,$valor);
        if($resultadoMainData)
            return json_encode(["status"=>"OPERATION_SUCCESS",
                                "data" =>['mainData'=>$resultadoMainData,'documentacion'=>$resultadoDocumentacion]]);
    }
    function obtenerDocumentacionDelExpediente($conexion,$valor){
         $consulta = $conexion->prepare('SELECT inf_id_documentacion.*, t_tipos_documento.documento
            FROM inf_id_documentacion 
            LEFT JOIN t_tipos_documento 
                ON inf_id_documentacion.idTipoDocumento = t_tipos_documento.id
            WHERE inf_id_documentacion.idFichaPersonal = 
                (SELECT registro.idFichaPersona FROM registro where registro.id =
                     (SELECT expedientes_evaluacion.idRegistro FROM expedientes_evaluacion WHERE expedientes_evaluacion.id=:id))');
        $consulta->execute($valor);
        return $consulta->fetchAll();
    }
    function obtenerInformacionExpedienteSinParametrizar($response, $request, $next){
        $conexion = \Conexion::getConnection();
        $resp = json_decode($response->getBody());
        $id = $resp->id;
        $valor=[':id'=>$id];

        $consulta = $conexion->prepare(
            "SELECT 
                    expedientes_evaluacion.idRegistro AS 'Registro',
                    expedientes_evaluacion.numero_expediente_tecnico as 'Número expediente técnico',
                    expedientes_evaluacion.numero_expediente_centro as 'Número expediente del centro',
                    expedientes_evaluacion.numero_ingreso as 'Número ingreso',
                    registro.fecha_ingreso as 'Fecha ingreso', 
                    registro.fecha_salida as 'Fecha salida',
                    expedientes_evaluacion.fecha_evaluacion as 'Fecha evaluación',
                    fichas_personas.nombre as 'Nombre', 
                    fichas_personas.apellido1 as 'Primer apellido',
                    fichas_personas.apellido2 as 'Segundo apellido',
                    fichas_personas.fecha_nacimiento as 'Fecha Nacimiento',
                    nacionalidad.nacionalidad as 'Nacionalidad', 
                    poblacionesEmpadronamiento.poblacion AS 'Municipio Empadronamiento',
                    fichas_personas.fecha_empadronamiento as 'Fecha empadronamiento',
                    fichas_personas.telefono as 'Teléfono',
                    fichas_personas.email as 'Email',
                    paisNacimiento.nacionalidad AS 'Pais de nacimiento',
                    provinciaNacimiento.provincia AS 'Provincia Nacimiento',
                    municipioNacimiento.poblacion AS 'Municipio Nacimiento',
                    t_sexo_ev.sexo as 'Sexo evaluación',
                    t_sexo.sexo as 'Sexo',
                    t_orientacion_sexual.orientacion_sexual AS 'Orientación sexual',
                    fichas_personas.numero_ss as 'Número Seguridad Social',
                    expedientes_evaluacion.numero_asSNS as 'Nº Asistencia Sanitaria Sevicio Nacional Salud',
                    t_estados_civiles.estado_civil as 'Estado Civil',
                    t_formas_ingreso.forma_ingreso as 'Forma Ingreso',
                    t_origen_ingreso.origen_ingreso as 'Origen Ingreso',
                    t_permiso_residencia.tipo as 'Tipo permiso residencia',
                    expedientes_evaluacion.renovacionPermisoPermanencia as 'Fecha renovación permiso permanencia'
                FROM
                    fichas_personas
                        LEFT JOIN t_estados_civiles
                            on fichas_personas.idEstadoCivil = t_estados_civiles.id
                        LEFT JOIN t_paises as nacionalidad
                            on fichas_personas.idNacionalidad = nacionalidad.id
                        Left Join t_poblaciones AS poblacionesEmpadronamiento
                            on fichas_personas.idPoblacionEmpadronamiento = poblacionesEmpadronamiento.id
                        LEFT JOIN t_paises as paisNacimiento
                            ON fichas_personas.idPaisNacimiento = paisNacimiento.id
                        LEFT JOIN t_provincias AS provinciaNacimiento
                            on fichas_personas.idProvinciaNacimiento = provinciaNacimiento.id
                        LEFT JOIN t_poblaciones as municipioNacimiento
                            ON fichas_personas.idPoblacionNacimiento = municipioNacimiento.id
                        LEFT JOIN t_sexo_ev
                            ON fichas_personas.idSexoEv = t_sexo_ev.id
                        LEFT JOIN t_sexo
                            ON fichas_personas.idSexo = t_sexo.id
                        LEFT JOIN t_orientacion_sexual
                            ON fichas_personas.idOrientacionSexual = t_orientacion_sexual.id
                        LEFT JOIN registro
                            on registro.idFichaPersona = fichas_personas.id
                        LEFT JOIN expedientes_evaluacion
                            ON expedientes_evaluacion.idRegistro = registro.id
                        LEFT JOIN t_formas_ingreso
                            on expedientes_evaluacion.idFormaIngreso = t_formas_ingreso.id
                        LEFT JOIN t_origen_ingreso
                            on expedientes_evaluacion.idOrigenIngreso = t_origen_ingreso.id
                        LEFT JOIN t_permiso_residencia
                            ON expedientes_evaluacion.idPermisoResidencia = t_permiso_residencia.id
                WHERE expedientes_evaluacion.id = :id");
        $consulta->execute($valor);
        $resultadoMainData=$consulta->fetchAll();
        $resultadoDocumentacion = obtenerDocumentacionDelExpedienteSinParametrizar($conexion,$valor);
        if($resultadoMainData)
            return json_encode(["status"=>"OPERATION_SUCCESS",
                                "data" =>['mainData'=>$resultadoMainData,'documentacion'=>$resultadoDocumentacion]]);
    }
    function obtenerDocumentacionDelExpedienteSinParametrizar($conexion,$valor){
        $consulta = $conexion->prepare(
            'SELECT 
                t_tipos_documento.documento,
                inf_id_documentacion.numero_documento,
                inf_id_documentacion.idTipoAusenciaDocumento
            FROM 
                inf_id_documentacion
                    LEFT JOIN t_tipos_documento
                        ON inf_id_documentacion.idTipoDocumento = t_tipos_documento.id
                    LEFT JOIN fichas_personas
                        ON fichas_personas.id = inf_id_documentacion.idFichaPersonal
            WHERE
                fichas_personas.id = 
                    (SELECT registro.idFichaPersona FROM registro where registro.id =
                     (SELECT expedientes_evaluacion.idRegistro FROM expedientes_evaluacion WHERE expedientes_evaluacion.id=:id))');
       $consulta->execute($valor);
       return $consulta->fetchAll();
   }

?>