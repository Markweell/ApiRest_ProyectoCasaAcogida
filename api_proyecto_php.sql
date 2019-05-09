-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2019 a las 14:25:09
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_proyecto_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agresores_delitos_odio`
--

CREATE TABLE `agresores_delitos_odio` (
  `id` int(11) NOT NULL,
  `idDelitoOdio` int(11) NOT NULL,
  `edad_agresor` int(11) DEFAULT NULL,
  `descripcion_agresor` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agresores_violencia_genero`
--

CREATE TABLE `agresores_violencia_genero` (
  `id` int(11) NOT NULL,
  `idViolenciaGenero` int(11) NOT NULL,
  `idNacionalidad` int(11) NOT NULL,
  `parentesco` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camas`
--

CREATE TABLE `camas` (
  `id` int(11) NOT NULL,
  `idHabitacion` int(11) NOT NULL,
  `cama` int(11) DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) DEFAULT NULL,
  `idUsuario_updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `camas`
--

INSERT INTO `camas` (`id`, `idHabitacion`, `cama`, `observaciones`, `created_at`, `updated_at`, `idUsuario_created_at`, `idUsuario_updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, NULL, NULL, NULL, NULL, NULL),
(3, 1, 3, NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, NULL, NULL, NULL, NULL, NULL),
(5, 2, 1, NULL, NULL, NULL, NULL, NULL),
(6, 2, 2, NULL, NULL, NULL, NULL, NULL),
(7, 2, 3, NULL, NULL, NULL, NULL, NULL),
(8, 2, 4, NULL, NULL, NULL, NULL, NULL),
(9, 3, 1, NULL, NULL, NULL, NULL, NULL),
(10, 3, 2, NULL, NULL, NULL, NULL, NULL),
(11, 3, 3, NULL, NULL, NULL, NULL, NULL),
(12, 3, 4, NULL, NULL, NULL, NULL, NULL),
(13, 4, 1, NULL, NULL, NULL, NULL, NULL),
(14, 4, 2, NULL, NULL, NULL, NULL, NULL),
(15, 4, 3, NULL, NULL, NULL, NULL, NULL),
(16, 4, 4, NULL, NULL, NULL, NULL, NULL),
(17, 4, 5, NULL, NULL, NULL, NULL, NULL),
(18, 5, 1, NULL, NULL, NULL, NULL, NULL),
(19, 5, 2, NULL, NULL, NULL, NULL, NULL),
(20, 5, 3, NULL, NULL, NULL, NULL, NULL),
(21, 5, 4, NULL, NULL, NULL, NULL, NULL),
(22, 5, 5, NULL, NULL, NULL, NULL, NULL),
(23, 6, 1, NULL, NULL, NULL, NULL, NULL),
(24, 6, 2, NULL, NULL, NULL, NULL, NULL),
(25, 6, 3, NULL, NULL, NULL, NULL, NULL),
(26, 6, 4, NULL, NULL, NULL, NULL, NULL),
(27, 6, 5, NULL, NULL, NULL, NULL, NULL),
(28, 7, 1, NULL, NULL, NULL, NULL, NULL),
(29, 7, 2, NULL, NULL, NULL, NULL, NULL),
(30, 7, 3, NULL, NULL, NULL, NULL, NULL),
(31, 7, 4, NULL, NULL, NULL, NULL, NULL),
(32, 7, 5, NULL, NULL, NULL, NULL, NULL),
(33, 8, 1, NULL, NULL, NULL, NULL, NULL),
(34, 8, 2, NULL, NULL, NULL, NULL, NULL),
(35, 9, 1, NULL, NULL, NULL, NULL, NULL),
(36, 9, 2, NULL, NULL, NULL, NULL, NULL),
(37, 10, 1, NULL, NULL, NULL, NULL, NULL),
(38, 10, 2, NULL, NULL, NULL, NULL, NULL),
(39, 11, 1, NULL, NULL, NULL, NULL, NULL),
(40, 11, 2, NULL, NULL, NULL, NULL, NULL),
(41, 12, 1, NULL, NULL, NULL, NULL, NULL),
(42, 12, 2, NULL, NULL, NULL, NULL, NULL),
(43, 13, 1, NULL, NULL, NULL, NULL, NULL),
(44, 13, 2, NULL, NULL, NULL, NULL, NULL),
(45, 14, 1, NULL, NULL, NULL, NULL, NULL),
(46, 14, 2, NULL, NULL, NULL, NULL, NULL),
(47, 15, 1, NULL, NULL, NULL, NULL, NULL),
(48, 15, 2, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_social`
--

CREATE TABLE `centro_social` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `centro_social` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `numeros_ingresos` int(11) DEFAULT NULL,
  `numeros_expedientes_tecnicos` int(11) DEFAULT NULL,
  `numeros_expedientes_centro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermedades`
--

CREATE TABLE `enfermedades` (
  `id` int(11) NOT NULL,
  `idFichaPersona` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idTipoEnfermedad` int(11) NOT NULL,
  `enfermedad` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes_evaluacion`
--

CREATE TABLE `expedientes_evaluacion` (
  `id` int(11) NOT NULL,
  `idRegistro` int(11) NOT NULL,
  `numero_expediente_tecnico` int(11) NOT NULL,
  `numero_expediente_centro` int(11) NOT NULL,
  `numero_ingreso` int(11) NOT NULL COMMENT 'Campo calculado que acumula el número de ingresos.',
  `fecha_evaluacion` datetime DEFAULT NULL,
  `idFormaIngreso` int(11) NOT NULL,
  `idOrigenIngreso` int(11) NOT NULL,
  `idNacionalidad` int(11) NOT NULL,
  `idPoblacionEmpadronamiento` int(11) NOT NULL,
  `fecha_empadronamiento` date DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ndias_sin_hogar` int(11) DEFAULT NULL,
  `nmeses_sin_hogar` int(11) DEFAULT NULL,
  `nanios_sin_hogar` int(11) DEFAULT NULL,
  `idPoblacionProcedenciaInmediata` int(11) NOT NULL,
  `idProvinciaProcedenciaInmediata` int(11) NOT NULL,
  `idPaisProcedenciaInmediata` int(11) NOT NULL,
  `tipo_vivienda` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea1_vivienda` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea2_vivienda` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea3_vivienda` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idNivelEstudios` int(11) NOT NULL,
  `idTiempoDesempleo` int(11) NOT NULL,
  `idContratoLaboral` int(11) NOT NULL,
  `idTipoContrato` int(11) NOT NULL,
  `e_ocupacion_principal` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idCuantiaEconomica` int(11) NOT NULL,
  `idSexoEv` int(11) NOT NULL,
  `idOrientacionSexual` int(11) NOT NULL,
  `numero_ss` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idEstadoCivil` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL,
  `idSexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_apoyo_social`
--

CREATE TABLE `e_apoyo_social` (
  `id` int(11) NOT NULL,
  `tipo` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apoyo_social` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_apoyo_social`
--

INSERT INTO `e_apoyo_social` (`id`, `tipo`, `apoyo_social`) VALUES
(1, 'Formal', 'Servicios sociales'),
(2, 'Formal', 'Asociaciones/fundaciones'),
(3, 'Formal', 'Servicios sanitarios'),
(4, 'Formal ', 'Red Cohabita'),
(5, 'No formal', 'Expareja'),
(6, 'No formal', 'Amigos/amigas'),
(7, 'No formal', 'Vecinos/vecinas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_causas_procedimientos_judiciales`
--

CREATE TABLE `e_causas_procedimientos_judiciales` (
  `id` int(11) NOT NULL,
  `causas_procedimiento_judiciall` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_causas_procedimientos_judiciales`
--

INSERT INTO `e_causas_procedimientos_judiciales` (`id`, `causas_procedimiento_judiciall`) VALUES
(1, 'Violencia de género'),
(2, 'Violencia intrafamiliar'),
(3, 'Delitos de odio'),
(4, 'Deiitos de robo'),
(5, 'Amenazas/intimidación'),
(6, 'Agresiones'),
(7, 'Tráfico de sustancias'),
(8, 'Abusos sexuales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_centros_sociales`
--

CREATE TABLE `e_centros_sociales` (
  `id` int(11) NOT NULL,
  `centro_social` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_consecuencias_agresiones`
--

CREATE TABLE `e_consecuencias_agresiones` (
  `id` int(11) NOT NULL,
  `tipo` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `consecuencia` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_consecuencias_agresiones`
--

INSERT INTO `e_consecuencias_agresiones` (`id`, `tipo`, `consecuencia`) VALUES
(1, 'Física', 'Contusión'),
(2, 'Física', 'Traumatismo'),
(3, 'Física', 'Pérdida de piezas dentales'),
(4, 'Psicológica', 'Miedo'),
(5, 'Psicológica', 'Ira'),
(6, 'Psicológica', 'Indefensión'),
(7, 'Psicológica', 'Indiferencia'),
(8, 'Socioeconómica', 'Pérdida de bienes materiales'),
(9, 'Socioeconómica', 'Pérdida de bienes económicos'),
(10, 'Socioeconómica', 'Pérdida de documentación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_enfermedades`
--

CREATE TABLE `e_enfermedades` (
  `id` int(11) NOT NULL,
  `idTipoEnfermedad` int(11) NOT NULL,
  `enfermedad` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_enfermedades`
--

INSERT INTO `e_enfermedades` (`id`, `idTipoEnfermedad`, `enfermedad`) VALUES
(1, 1, 'Respiratorias'),
(2, 1, 'Dermatológicas'),
(3, 1, 'Musculoesqueléticas'),
(4, 1, 'Neurológicas'),
(5, 1, 'Oncológicas'),
(6, 1, 'Sensoriales'),
(7, 3, 'VIH'),
(8, 3, 'VHB'),
(9, 3, 'VHC'),
(10, 3, 'TBC'),
(11, 3, 'ETS'),
(12, 2, 'Trastornos afectivos'),
(13, 2, 'Trastornos de ansiedad'),
(14, 2, 'Trastornos psicóticos'),
(15, 2, 'Trastornos de personalidad'),
(16, 5, 'Juegos patológicos'),
(17, 4, 'Alcohol'),
(18, 4, 'Cannabis'),
(19, 4, 'Cocaìna'),
(20, 4, 'Heroína'),
(21, 4, 'Cocaína+heroína(base)'),
(22, 4, 'Benzodiacepinas'),
(23, 4, 'Metadona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_motivos_estancias`
--

CREATE TABLE `e_motivos_estancias` (
  `id` int(11) NOT NULL,
  `motivo_estancia` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_motivos_estancias`
--

INSERT INTO `e_motivos_estancias` (`id`, `motivo_estancia`) VALUES
(1, 'laboral'),
(2, 'familiar'),
(3, 'sanitario'),
(4, 'vivienda'),
(5, 'economico'),
(6, 'adicciones'),
(7, 'violencia de genero'),
(8, 'legal'),
(9, 'salida de otro recurso residencial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_motivos_renuncias`
--

CREATE TABLE `e_motivos_renuncias` (
  `id` int(11) NOT NULL,
  `motivo_renuncia` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_motivos_renuncias`
--

INSERT INTO `e_motivos_renuncias` (`id`, `motivo_renuncia`) VALUES
(1, 'No tendrá utilidad alguna'),
(2, 'Miedo a represalias por parte de los agresores'),
(3, 'Maltrato institucional/Miedo a doble victimización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_ocupaciones_principales`
--

CREATE TABLE `e_ocupaciones_principales` (
  `id` int(11) NOT NULL,
  `ocupacion_principal` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_ocupaciones_principales`
--

INSERT INTO `e_ocupaciones_principales` (`id`, `ocupacion_principal`) VALUES
(1, 'Construcción.'),
(2, 'Hostelería'),
(3, 'Limpieza / Empleo del hogar.'),
(4, 'Agricultura.'),
(5, ' Logística.'),
(6, 'Servicios sanitarios/ atención a la dependencia.'),
(7, 'Comercial.'),
(8, 'Fuerzas de seguridad.'),
(9, 'Servicios de protección y vigilancia.'),
(10, 'Carece de experiencia profesional.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_resoluciones_procedimientos_judiciales`
--

CREATE TABLE `e_resoluciones_procedimientos_judiciales` (
  `id` int(11) NOT NULL,
  `tipo_resolucion` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_resoluciones_procedimientos_judiciales`
--

INSERT INTO `e_resoluciones_procedimientos_judiciales` (`id`, `tipo_resolucion`) VALUES
(1, 'Trabajos en beneficio a la comunidad'),
(2, 'Ingreso en centro penitenciario'),
(3, 'Indemnización económica'),
(4, 'Orden de alejamiento'),
(5, 'Arresto docimiliario'),
(6, 'Prohibición de tenencia de armas'),
(7, 'Dispositivo de localización'),
(8, 'Libertad vigilada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_situaciones_laborales`
--

CREATE TABLE `e_situaciones_laborales` (
  `situacion_laboral` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_situaciones_laborales`
--

INSERT INTO `e_situaciones_laborales` (`situacion_laboral`, `id`) VALUES
('Desempleado', '1'),
('Ocupado', '2'),
('Baja laboral', '3'),
('Incapacidad laboral', '4'),
('Jubilado', '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_tipos_documentos`
--

CREATE TABLE `e_tipos_documentos` (
  `id` int(11) NOT NULL,
  `tipo_documento` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_tipos_documentos`
--

INSERT INTO `e_tipos_documentos` (`id`, `tipo_documento`) VALUES
(1, 'DNI'),
(2, 'NIE'),
(3, 'PASAPORTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_tipos_ingresos`
--

CREATE TABLE `e_tipos_ingresos` (
  `id` int(11) NOT NULL,
  `tipo_ingreso` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `e_tipos_ingresos`
--

INSERT INTO `e_tipos_ingresos` (`id`, `tipo_ingreso`) VALUES
(1, 'Prestación por desempleo.'),
(2, 'Subsidio por desempleo.'),
(3, 'Subsidio familiar (SEPE).'),
(4, 'Subsidio mayores de 55 años.'),
(5, 'Subsidio por excarcelación.'),
(6, 'Subsidio extraordinario de desempleo.'),
(7, 'Renta Activa de Inserción.'),
(8, 'Pensión contributiva por jubilación.'),
(9, 'Pensión no contributiva por discapacidad.'),
(10, 'Pensión no contributiva por jubilación'),
(11, 'Pensión por orfandad.'),
(12, 'Renta mínima de inserción social.'),
(13, 'Incapacidad laboral transitoria / Incapacidad temporal.'),
(14, 'Incapacidad laboral permanente.'),
(15, 'Prestación por hijos a cargo (INSS).'),
(16, 'Baja por maternidad/ paternidad.'),
(17, 'Ayuda económica familiar (Servicios Sociales Comunitarios).'),
(18, 'Ayuda de emergencia (Servicios Sociales Comunitarios).');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_tipos_viviendas`
--

CREATE TABLE `e_tipos_viviendas` (
  `id` int(11) NOT NULL,
  `tipo_vivienda` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas_personas`
--

CREATE TABLE `fichas_personas` (
  `id` int(11) NOT NULL,
  `apellido1` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido2` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idNacionalidad` int(11) NOT NULL,
  `idPoblacionEmpadronamiento` int(11) NOT NULL,
  `fecha_empadronamiento` date DEFAULT NULL,
  `fecha_evaluacion` datetime DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idPaisNacimiento` int(11) NOT NULL,
  `idProvinciaNacimiento` int(11) NOT NULL,
  `idPoblacionNacimiento` int(11) NOT NULL,
  `tipo_vivienda` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea1_vivienda` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea2_vivienda` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea3_vivienda` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idNivelEstudios` int(11) NOT NULL,
  `idTiempoDesempleo` int(11) NOT NULL,
  `idContratoLaboral` int(11) NOT NULL,
  `idTipoContrato` int(11) NOT NULL,
  `e_ocupacion_principal` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idCuantiaEconomica` int(11) NOT NULL,
  `idSexoEv` int(11) NOT NULL,
  `idOrientacionSexual` int(11) NOT NULL,
  `numero_ss` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idEstadoCivil` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL,
  `idSexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `habitacion` int(11) NOT NULL,
  `idTipoHabitacion` int(11) NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `localizacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) DEFAULT NULL,
  `idUsuario_updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `habitacion`, `idTipoHabitacion`, `capacidad`, `localizacion`, `observaciones`, `created_at`, `updated_at`, `idUsuario_created_at`, `idUsuario_updated_at`) VALUES
(1, 1, 1, 4, NULL, 'Módulo de inserción', NULL, NULL, NULL, NULL),
(2, 2, 1, 4, NULL, 'Módulo abierto', NULL, NULL, NULL, NULL),
(3, 3, 1, 4, NULL, 'Módulo de inserción', NULL, NULL, NULL, NULL),
(4, 4, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 14, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_actuaciones_expedientes`
--

CREATE TABLE `inf_actuaciones_expedientes` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `fechahora` datetime DEFAULT NULL,
  `actuacion` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_do_delitos_odio`
--

CREATE TABLE `inf_do_delitos_odio` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idTipoViolencia` int(11) NOT NULL,
  `fechahora` datetime DEFAULT NULL,
  `idLugarAgresion` int(11) NOT NULL,
  `descripcion_lugar_agresion` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idMomentoAgresion` int(11) NOT NULL,
  `elementos_intimidatorios` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idTipoAgresion` int(11) NOT NULL,
  `descripcion` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `consecuencias` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `denuncia_agresion_te` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `denuncia_favorable_te` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones_denuncia` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `motivos_renuncia_denuncia` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `solicitud_apoyo_te` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `solicitud_apoyo_servicios_te` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `motivos_renuncia_solicitud_apoyo_te` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_fl_datos_economicos`
--

CREATE TABLE `inf_fl_datos_economicos` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idConceptoIngreso` int(11) NOT NULL,
  `e_tipo_ingreso` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `importe` int(11) DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_id_documentacion`
--

CREATE TABLE `inf_id_documentacion` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL COMMENT 'Expediente de evaluación donde se establecen las características del documento.\n',
  `idTipoDocumento` int(11) NOT NULL,
  `numero_documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idTipoAusenciaDocumento` int(11) NOT NULL,
  `numero_denuncia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_uptaded_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_sf_apoyo_social`
--

CREATE TABLE `inf_sf_apoyo_social` (
  `int` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `apoyo_social_e` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_sf_familia`
--

CREATE TABLE `inf_sf_familia` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_sf_motivos_estancia`
--

CREATE TABLE `inf_sf_motivos_estancia` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `motivo_estancia` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_sf_relacion_familia`
--

CREATE TABLE `inf_sf_relacion_familia` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_sf_r_expedientes_evaluacion_personas_contacto`
--

CREATE TABLE `inf_sf_r_expedientes_evaluacion_personas_contacto` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idPersonaContacto` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inf_vg_violencia_genero`
--

CREATE TABLE `inf_vg_violencia_genero` (
  `id` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idTipoViolencia` int(11) NOT NULL,
  `fechahora` datetime DEFAULT NULL,
  `idLugarAgresion` int(11) NOT NULL,
  `descripcion_lugar_agresion` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idAmbitoAgresion` int(11) NOT NULL,
  `idMomentoAgresion` int(11) NOT NULL,
  `elementos_intimidatorios` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idTipoAgresion` int(11) NOT NULL,
  `descripcion` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `consecuencias` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `denuncia_agresion_te` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `denuncia_favorable_te` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones_denuncia` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `motivos_renuncia_denuncia` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `solicitud_apoyo_te` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `solicitud_apoyo_servicios_te` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `motivos_renuncia_solicitud_apoyo` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas_contacto`
--

CREATE TABLE `personas_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido1` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido2` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea1` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea2` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_linea3` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idPoblacion` int(11) NOT NULL,
  `idProvincias` int(11) NOT NULL,
  `idPaises` int(11) NOT NULL,
  `telefono1` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono2` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos_judiciales`
--

CREATE TABLE `procedimientos_judiciales` (
  `id` int(11) NOT NULL,
  `idFichaPersonal` int(11) NOT NULL,
  `idExpedienteEvaluacion` int(11) NOT NULL,
  `idEstadoProdcedimientoJudicial` int(11) NOT NULL,
  `idTipoProcedimientoJudicial` int(11) NOT NULL,
  `idTipoResolucionesProcedimientosJudiciales` int(11) NOT NULL,
  `e_causa_procedimiento_judicial` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `e_resolucion_procedimiento_judicial_medida_cautelar` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'En función de que sea sentencia firme o proceso abierto estamos hablando de sentencia o medidas cautelares',
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id` int(11) NOT NULL,
  `idFichaPersona` int(11) NOT NULL,
  `numero_ingreso` int(11) DEFAULT NULL COMMENT 'Utilizamos el campo numeros_ingreso de la tabla config para actualizar este contador.',
  `fecha_ingreso` datetime DEFAULT NULL,
  `fecha_salida` datetime DEFAULT NULL,
  `motivo_salida` mediumtext COLLATE utf8_spanish_ci,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `r_registro_camas`
--

CREATE TABLE `r_registro_camas` (
  `id` int(11) NOT NULL,
  `idCama` int(11) NOT NULL,
  `idRegistro` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `observaciones` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idUsuario_created_at` int(11) NOT NULL,
  `idUsuario_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testigos_delitos_odio`
--

CREATE TABLE `testigos_delitos_odio` (
  `id` int(11) NOT NULL,
  `idDelitoOdio` int(11) NOT NULL,
  `edad_testigo` int(11) DEFAULT NULL,
  `descripcion_testigo` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `presta_ayuda` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `idSexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `te_confirmacion`
--

CREATE TABLE `te_confirmacion` (
  `confirmacion` char(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `te_confirmacion`
--

INSERT INTO `te_confirmacion` (`confirmacion`) VALUES
('No'),
('Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo`) VALUES
(1, 'conserje'),
(2, 'tecnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_ambitos_agresion`
--

CREATE TABLE `t_ambitos_agresion` (
  `ambito_agresion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_ambitos_agresion`
--

INSERT INTO `t_ambitos_agresion` (`ambito_agresion`, `id`) VALUES
('Afectivo', 1),
('Sexual', 2),
('Laboral', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_conceptos_ingresos_economicos`
--

CREATE TABLE `t_conceptos_ingresos_economicos` (
  `id` int(11) NOT NULL,
  `concepto_economico` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_conceptos_ingresos_economicos`
--

INSERT INTO `t_conceptos_ingresos_economicos` (`id`, `concepto_economico`) VALUES
(1, 'Actividad laboral'),
(2, 'Prestaciones/Pensiones/Subsidios'),
(3, 'Actividad no regulada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_contratos_laboral`
--

CREATE TABLE `t_contratos_laboral` (
  `id` int(11) NOT NULL,
  `idContratoLaboral` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_contratos_laboral`
--

INSERT INTO `t_contratos_laboral` (`id`, `idContratoLaboral`) VALUES
(1, 'Si'),
(2, 'No'),
(3, 'Autónomo'),
(4, 'Sin experiencia profesional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_cuantias_economicas`
--

CREATE TABLE `t_cuantias_economicas` (
  `id` int(11) NOT NULL,
  `cuantia_economica` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_cuantias_economicas`
--

INSERT INTO `t_cuantias_economicas` (`id`, `cuantia_economica`) VALUES
(1, 'Menos de 300 euros'),
(2, 'De 300 a 500 euros'),
(3, 'De 500 a 700 euros'),
(4, 'De 700 a 900 euros'),
(5, 'Más de 900 euros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_estados_civiles`
--

CREATE TABLE `t_estados_civiles` (
  `id` int(11) NOT NULL,
  `estado_civil` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_estados_civiles`
--

INSERT INTO `t_estados_civiles` (`id`, `estado_civil`) VALUES
(1, 'Soltero/soltera'),
(2, 'Casado/casada'),
(3, 'Separado/separada'),
(4, 'Divorciado/Divorciada'),
(5, 'Viudo/viuda'),
(6, 'Pareja de hecho'),
(7, 'Pareja análoga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_estados_procedimientos_judiciales`
--

CREATE TABLE `t_estados_procedimientos_judiciales` (
  `id` int(11) NOT NULL,
  `estado_procedimiento_judiciall` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_estados_procedimientos_judiciales`
--

INSERT INTO `t_estados_procedimientos_judiciales` (`id`, `estado_procedimiento_judiciall`) VALUES
(1, 'Anterior'),
(2, 'Actual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_formas_ingreso`
--

CREATE TABLE `t_formas_ingreso` (
  `id` int(11) NOT NULL,
  `forma_ingreso` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_formas_ingreso`
--

INSERT INTO `t_formas_ingreso` (`id`, `forma_ingreso`) VALUES
(1, 'Acceso directo'),
(2, 'Derivación'),
(3, 'Emergencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_lugares_agresion`
--

CREATE TABLE `t_lugares_agresion` (
  `lugar_agresion` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_lugares_agresion`
--

INSERT INTO `t_lugares_agresion` (`lugar_agresion`, `id`) VALUES
('Vía pública', 1),
('Espacio privado', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_momentos_agresion`
--

CREATE TABLE `t_momentos_agresion` (
  `momento_agresion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_momentos_agresion`
--

INSERT INTO `t_momentos_agresion` (`momento_agresion`, `id`) VALUES
('Mañana', 1),
('Tarde', 2),
('Noche', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_niveles_estudios`
--

CREATE TABLE `t_niveles_estudios` (
  `id` int(11) NOT NULL,
  `nivel_estudios` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_niveles_estudios`
--

INSERT INTO `t_niveles_estudios` (`id`, `nivel_estudios`) VALUES
(1, 'No sabe ni leer ni escribir'),
(2, 'No ha finalizado la Educación Primaria Obligatoria.'),
(3, 'Ha finalizado la Educación Primaria Obligatoria.'),
(4, 'No ha finalizado la Educación Secundaria Obligatoria.'),
(5, 'Ha finalizado la Educación Secundaria Obligatoria.'),
(6, 'No ha finalizado Bachillerato o Ciclo Formativo de Grado Medio.'),
(7, 'Ha finalizado Bachillerato o Ciclo Formativo de Grado Medio.'),
(8, 'Ha finalizado estudios superiores (Ciclo formativo de Grado Superior).'),
(9, 'Estudios Universitarios.'),
(10, 'Estudio de Postgrado.'),
(11, 'Formación no reglada / Acciones formativas orientadas al empleo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_orientacion_sexual`
--

CREATE TABLE `t_orientacion_sexual` (
  `id` int(11) NOT NULL,
  `orientacion_sexual` varchar(15) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_orientacion_sexual`
--

INSERT INTO `t_orientacion_sexual` (`id`, `orientacion_sexual`) VALUES
(1, 'Bisexual'),
(2, 'Heterosexual'),
(3, 'Homosexual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_origen_ingreso`
--

CREATE TABLE `t_origen_ingreso` (
  `id` int(11) NOT NULL,
  `origen_ingreso` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_origen_ingreso`
--

INSERT INTO `t_origen_ingreso` (`id`, `origen_ingreso`) VALUES
(1, 'Servicios Sociales/Ayuntamiento'),
(2, 'Hostipal/Servicios de salud'),
(3, 'Salud Mental'),
(4, 'Red Cohabita'),
(5, 'Centro de Protección de Menores/Juventud'),
(6, 'Adicciones'),
(7, 'Centro Penitenciario/Centro de Reforma'),
(8, 'Servicios de Empleo'),
(9, 'Inmigración'),
(10, 'Mujer'),
(11, 'Policía/Fuerzas de seguridad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_paises`
--

CREATE TABLE `t_paises` (
  `id` int(11) NOT NULL,
  `codigo` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nacionalidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_parentescos`
--

CREATE TABLE `t_parentescos` (
  `parentesco` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_parentescos`
--

INSERT INTO `t_parentescos` (`parentesco`, `id`) VALUES
('padre/madre', 1),
('hermanos/hermanas', 2),
('hijos/hijas', 3),
('marido/mujer/pareja', 4),
('primos/primas', 5),
('tios/tias', 6),
('sobrinos/sobrinas', 7),
('abuelos/abuelas', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_poblaciones`
--

CREATE TABLE `t_poblaciones` (
  `id` int(11) NOT NULL,
  `poblacion` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idProvincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_provincias`
--

CREATE TABLE `t_provincias` (
  `id` int(11) NOT NULL,
  `codigo` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provincia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_servicios`
--

CREATE TABLE `t_servicios` (
  `id` int(11) NOT NULL,
  `servicio` varchar(65) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_servicios`
--

INSERT INTO `t_servicios` (`id`, `servicio`) VALUES
(1, 'Servicios policiales'),
(2, 'Servicios sanitarios'),
(3, 'Servicios sociales'),
(4, 'Servicios específicos PSH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_sexo`
--

CREATE TABLE `t_sexo` (
  `sexo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_sexo`
--

INSERT INTO `t_sexo` (`sexo`, `id`) VALUES
('Hombre', 1),
('Mujer', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_sexo_ev`
--

CREATE TABLE `t_sexo_ev` (
  `id` int(11) NOT NULL,
  `sexo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_sexo_ev`
--

INSERT INTO `t_sexo_ev` (`id`, `sexo`) VALUES
(1, 'Hombre cisgénero'),
(2, 'Hombre transgénero'),
(3, 'Hombre transexual'),
(4, 'Mujer cisgénero'),
(5, 'Mujer transgénero'),
(6, 'Mujer transexual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tiempos_desempleo`
--

CREATE TABLE `t_tiempos_desempleo` (
  `id` int(11) NOT NULL,
  `tiempo_desempleo` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tiempos_desempleo`
--

INSERT INTO `t_tiempos_desempleo` (`id`, `tiempo_desempleo`) VALUES
(1, 'Menos de seis meses'),
(2, 'Seis meses a un año'),
(3, 'Un año a tres años'),
(4, 'Tres años a seis años'),
(5, 'Seis años a nueve años'),
(6, 'Nueve años a doce años'),
(7, 'Más de doce años');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_agresion`
--

CREATE TABLE `t_tipos_agresion` (
  `tipo_agresion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_agresion`
--

INSERT INTO `t_tipos_agresion` (`tipo_agresion`, `id`) VALUES
('Por un individuo', 1),
('Por un grupo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_ausencia_documento`
--

CREATE TABLE `t_tipos_ausencia_documento` (
  `id` int(11) NOT NULL,
  `ausencia_documento` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_ausencia_documento`
--

INSERT INTO `t_tipos_ausencia_documento` (`id`, `ausencia_documento`) VALUES
(1, 'Robo'),
(2, 'Extravío'),
(3, 'Carencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_contrato`
--

CREATE TABLE `t_tipos_contrato` (
  `id` int(11) NOT NULL,
  `tipo_contrato` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_contrato`
--

INSERT INTO `t_tipos_contrato` (`id`, `tipo_contrato`) VALUES
(1, 'Temporal'),
(2, 'Indefinido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_documento`
--

CREATE TABLE `t_tipos_documento` (
  `id` int(11) NOT NULL,
  `documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_documento`
--

INSERT INTO `t_tipos_documento` (`id`, `documento`) VALUES
(1, 'DNI'),
(2, 'TIE'),
(3, 'Pasaporte'),
(4, 'DNI - País origen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_enfermedades`
--

CREATE TABLE `t_tipos_enfermedades` (
  `id` int(11) NOT NULL,
  `tipo_enfermedad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_enfermedades`
--

INSERT INTO `t_tipos_enfermedades` (`id`, `tipo_enfermedad`) VALUES
(1, 'Enfermedad física'),
(2, 'Enfermedad mental'),
(3, 'Enfermedad infecciosa'),
(4, 'Adicciones con sustancias'),
(5, 'Adicciones sin sustancias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_habitaciones`
--

CREATE TABLE `t_tipos_habitaciones` (
  `id` int(11) NOT NULL,
  `tipo_habitacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_habitaciones`
--

INSERT INTO `t_tipos_habitaciones` (`id`, `tipo_habitacion`) VALUES
(1, 'Familia'),
(2, 'Mujeres'),
(3, 'Hombres'),
(4, 'Doble');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_procedimientos_judiciales`
--

CREATE TABLE `t_tipos_procedimientos_judiciales` (
  `id` int(11) NOT NULL,
  `estado_procedimiento_judiciall` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_procedimientos_judiciales`
--

INSERT INTO `t_tipos_procedimientos_judiciales` (`id`, `estado_procedimiento_judiciall`) VALUES
(1, 'Sentencia'),
(2, 'Procedimiento abierto'),
(3, 'Sanción administrativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_resoluciones_procedimientos_judiciales`
--

CREATE TABLE `t_tipos_resoluciones_procedimientos_judiciales` (
  `id` int(11) NOT NULL,
  `tipo_resolucion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_resoluciones_procedimientos_judiciales`
--

INSERT INTO `t_tipos_resoluciones_procedimientos_judiciales` (`id`, `tipo_resolucion`) VALUES
(1, 'Favorable'),
(2, 'Condena judicial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_tipos_violencia`
--

CREATE TABLE `t_tipos_violencia` (
  `id` int(11) NOT NULL,
  `tipo_violencia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_tipos_violencia`
--

INSERT INTO `t_tipos_violencia` (`id`, `tipo_violencia`) VALUES
(1, 'Verbal'),
(2, 'Física'),
(3, 'Sexual'),
(4, 'Económica/Patrimonial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `tipo_usuario_id`) VALUES
(1, 'conserje', 'conserje@gmail.com', 'conserje', 1),
(2, 'tecnico', 'tecnico@gmail.com', 'tecnico', 2),
(3, 'conserje2', 'conserje2@gmail.com', 'conserje2', 1),
(4, 'tecnico2', 'tecnico2@gmail.com', 'tecnico2', 2),
(5, 'conserje3', 'conserje3@gmail.com', 'conserje3', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agresores_delitos_odio`
--
ALTER TABLE `agresores_delitos_odio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agresores_delitos_odio1_idx` (`idDelitoOdio`),
  ADD KEY `fk_agresores_delitos_odio_te_sexo1_idx` (`idSexo`);

--
-- Indices de la tabla `agresores_violencia_genero`
--
ALTER TABLE `agresores_violencia_genero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agresores_violencia_genero_violencia_genero1_idx` (`idViolenciaGenero`),
  ADD KEY `fk_agresores_violencia_genero_t_paises1_idx` (`idNacionalidad`);

--
-- Indices de la tabla `camas`
--
ALTER TABLE `camas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_camas_habitaciones1_idx` (`idHabitacion`),
  ADD KEY `i1camas` (`cama`),
  ADD KEY `fk_camas_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_camas_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `centro_social`
--
ALTER TABLE `centro_social`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_centro_social_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`);

--
-- Indices de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enfermedades_t_tipos_enfermedades1_idx` (`idTipoEnfermedad`),
  ADD KEY `fk_enfermedades_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_enfermedades_usuarios2_idx` (`idUsuario_updated_at`),
  ADD KEY `fk_enfermedades_fichas_personas1_idx` (`idFichaPersona`),
  ADD KEY `fk_enfermedades_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`);

--
-- Indices de la tabla `expedientes_evaluacion`
--
ALTER TABLE `expedientes_evaluacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_expediente_tecncio_UNIQUE` (`numero_expediente_tecnico`),
  ADD UNIQUE KEY `numero_expediente_centro_UNIQUE` (`numero_expediente_centro`),
  ADD KEY `fk_expedientes_evaluacion_t_origen_ingreso1_idx` (`idOrigenIngreso`),
  ADD KEY `fk_expedientes_evaluacion_t_poblaciones1_idx` (`idPoblacionProcedenciaInmediata`),
  ADD KEY `fk_expedientes_evaluacion_t_provincias1_idx` (`idProvinciaProcedenciaInmediata`),
  ADD KEY `fk_expedientes_evaluacion_t_paises1_idx` (`idPaisProcedenciaInmediata`),
  ADD KEY `fk_expedientes_evaluacion_te_niveles_estudios1_idx` (`idNivelEstudios`),
  ADD KEY `fk_expedientes_evaluacion_t_tiempos_desempleo1_idx` (`idTiempoDesempleo`),
  ADD KEY `fk_expedientes_evaluacion_t_contratos_laboral1_idx` (`idContratoLaboral`),
  ADD KEY `fk_expedientes_evaluacion_t_tipos_contrato1_idx` (`idTipoContrato`),
  ADD KEY `fk_expedientes_evaluacion_t_cuantias_economicas1_idx` (`idCuantiaEconomica`),
  ADD KEY `fk_expedientes_evaluacion_t_paises2_idx` (`idNacionalidad`),
  ADD KEY `fk_expedientes_evaluacion_t_poblaciones2_idx` (`idPoblacionEmpadronamiento`),
  ADD KEY `fk_expedientes_evaluacion_t_sexo_ev1_idx` (`idSexoEv`),
  ADD KEY `fk_expedientes_evaluacion_te_orientacion_sexual1_idx` (`idOrientacionSexual`),
  ADD KEY `fk_expedientes_evaluacion_t_estados_civiles1_idx` (`idEstadoCivil`),
  ADD KEY `fk_expedientes_evaluacion_registro1_idx` (`idRegistro`),
  ADD KEY `fk_expedientes_evaluacion_t_formas_ingreso1_idx` (`idFormaIngreso`),
  ADD KEY `fk_expedientes_evaluacion_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_expedientes_evaluacion_usuarios2_idx` (`idUsuario_updated_at`),
  ADD KEY `fk_expedientes_evaluacion_te_sexo1_idx` (`idSexo`);

--
-- Indices de la tabla `e_apoyo_social`
--
ALTER TABLE `e_apoyo_social`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_causas_procedimientos_judiciales`
--
ALTER TABLE `e_causas_procedimientos_judiciales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_centros_sociales`
--
ALTER TABLE `e_centros_sociales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_consecuencias_agresiones`
--
ALTER TABLE `e_consecuencias_agresiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_enfermedades`
--
ALTER TABLE `e_enfermedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_t_enfermedades_t_tipos_enfermedades1_idx` (`idTipoEnfermedad`);

--
-- Indices de la tabla `e_motivos_estancias`
--
ALTER TABLE `e_motivos_estancias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_motivos_renuncias`
--
ALTER TABLE `e_motivos_renuncias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_ocupaciones_principales`
--
ALTER TABLE `e_ocupaciones_principales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_resoluciones_procedimientos_judiciales`
--
ALTER TABLE `e_resoluciones_procedimientos_judiciales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_situaciones_laborales`
--
ALTER TABLE `e_situaciones_laborales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_tipos_documentos`
--
ALTER TABLE `e_tipos_documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_tipos_ingresos`
--
ALTER TABLE `e_tipos_ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_tipos_viviendas`
--
ALTER TABLE `e_tipos_viviendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fichas_personas`
--
ALTER TABLE `fichas_personas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expedientes_evaluacion_te_niveles_estudios1_idx` (`idNivelEstudios`),
  ADD KEY `fk_expedientes_evaluacion_t_tiempos_desempleo1_idx` (`idTiempoDesempleo`),
  ADD KEY `fk_expedientes_evaluacion_t_contratos_laboral1_idx` (`idContratoLaboral`),
  ADD KEY `fk_expedientes_evaluacion_t_tipos_contrato1_idx` (`idTipoContrato`),
  ADD KEY `fk_expedientes_evaluacion_t_cuantias_economicas1_idx` (`idCuantiaEconomica`),
  ADD KEY `fk_expedientes_evaluacion_t_paises2_idx` (`idNacionalidad`),
  ADD KEY `fk_expedientes_evaluacion_t_poblaciones2_idx` (`idPoblacionEmpadronamiento`),
  ADD KEY `fk_expedientes_evaluacion_t_paises3_idx` (`idPaisNacimiento`),
  ADD KEY `fk_expedientes_evaluacion_t_provincias2_idx` (`idProvinciaNacimiento`),
  ADD KEY `fk_expedientes_evaluacion_t_poblaciones3_idx` (`idPoblacionNacimiento`),
  ADD KEY `fk_expedientes_evaluacion_t_sexo_ev1_idx` (`idSexoEv`),
  ADD KEY `fk_expedientes_evaluacion_te_orientacion_sexual1_idx` (`idOrientacionSexual`),
  ADD KEY `fk_expedientes_evaluacion_t_estados_civiles1_idx` (`idEstadoCivil`),
  ADD KEY `fk_fichas_personas_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_fichas_personas_usuarios2_idx` (`idUsuario_updated_at`),
  ADD KEY `fk_fichas_personas_te_sexo1_idx` (`idSexo`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `habitacion_UNIQUE` (`habitacion`),
  ADD KEY `fk_habitaciones_t_tipos_habitaciones1_idx` (`idTipoHabitacion`),
  ADD KEY `fk_habitaciones_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_habitaciones_usuarios2_idx` (`idUsuario_updated_at`),
  ADD KEY `i1habitaciones` (`habitacion`);

--
-- Indices de la tabla `inf_actuaciones_expedientes`
--
ALTER TABLE `inf_actuaciones_expedientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_actuaciones_expedientes_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_actuaciones_expedientes_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_actuaciones_expedientes_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `inf_do_delitos_odio`
--
ALTER TABLE `inf_do_delitos_odio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_delitos_odio_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_delitos_odio_te_confirmacion5_idx` (`denuncia_agresion_te`),
  ADD KEY `fk_delitos_odio_te_confirmacion6_idx` (`denuncia_favorable_te`),
  ADD KEY `fk_delitos_odio_te_confirmacion7_idx` (`solicitud_apoyo_te`),
  ADD KEY `fk_delitos_odio_t_tipos_violencia1_idx` (`idTipoViolencia`),
  ADD KEY `fk_delitos_odio_te_lugares_agresion1_idx` (`idLugarAgresion`),
  ADD KEY `fk_delitos_odio_t_momentos_agresion1_idx` (`idMomentoAgresion`),
  ADD KEY `fk_delitos_odio_te_tipos_agresion2_idx` (`idTipoAgresion`),
  ADD KEY `fk_inf_do_delitos_odio_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_inf_do_delitos_odio_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `inf_fl_datos_economicos`
--
ALTER TABLE `inf_fl_datos_economicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_datos_economicos_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_datos_economicos_t_conceptos_ingresos_economicos1_idx` (`idConceptoIngreso`),
  ADD KEY `fk_datos_economicos_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_datos_economicos_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `inf_id_documentacion`
--
ALTER TABLE `inf_id_documentacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documentacion_t_tipos_documento1_idx` (`idTipoDocumento`),
  ADD KEY `fk_documentacion_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_documentacion_t_tipos_ausencia_documento1_idx` (`idTipoAusenciaDocumento`),
  ADD KEY `fk_documentacion_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_documentacion_usuarios2_idx` (`idUsuario_uptaded_at`),
  ADD KEY `i1documentacion` (`numero_documento`);

--
-- Indices de la tabla `inf_sf_apoyo_social`
--
ALTER TABLE `inf_sf_apoyo_social`
  ADD PRIMARY KEY (`int`),
  ADD KEY `fk_inf_sf_apoyo_social_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`);

--
-- Indices de la tabla `inf_sf_familia`
--
ALTER TABLE `inf_sf_familia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Familia_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_inf_sf_familia_t_parentescos1_idx` (`idParentesco`);

--
-- Indices de la tabla `inf_sf_motivos_estancia`
--
ALTER TABLE `inf_sf_motivos_estancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_motivos_estancia_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`);

--
-- Indices de la tabla `inf_sf_relacion_familia`
--
ALTER TABLE `inf_sf_relacion_familia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Familia_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_relacion_familia_t_parentescos1_idx` (`idParentesco`);

--
-- Indices de la tabla `inf_sf_r_expedientes_evaluacion_personas_contacto`
--
ALTER TABLE `inf_sf_r_expedientes_evaluacion_personas_contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personas_contacto_has_expedientes_evaluacion_expedientes_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_personas_contacto_has_expedientes_evaluacion_personas_co_idx` (`idPersonaContacto`),
  ADD KEY `fk_r_expedientes_evaluacion_personas_contacto_t_parentescos_idx` (`idParentesco`);

--
-- Indices de la tabla `inf_vg_violencia_genero`
--
ALTER TABLE `inf_vg_violencia_genero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_delitos_odio_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_delitos_odio_te_confirmacion5_idx` (`denuncia_agresion_te`),
  ADD KEY `fk_delitos_odio_te_confirmacion6_idx` (`denuncia_favorable_te`),
  ADD KEY `fk_delitos_odio_te_confirmacion7_idx` (`solicitud_apoyo_te`),
  ADD KEY `fk_inf_vg_violencia_genero_t_tipos_violencia1_idx` (`idTipoViolencia`),
  ADD KEY `fk_inf_vg_violencia_genero_t_ambitos_agresion1_idx` (`idAmbitoAgresion`),
  ADD KEY `fk_inf_vg_violencia_genero_t_momentos_agresion1_idx` (`idMomentoAgresion`),
  ADD KEY `fk_inf_vg_violencia_genero_t_lugares_agresion1_idx` (`idLugarAgresion`),
  ADD KEY `fk_inf_vg_violencia_genero_t_tipos_agresion1_idx` (`idTipoAgresion`),
  ADD KEY `fk_inf_vg_violencia_genero_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_inf_vg_violencia_genero_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `personas_contacto`
--
ALTER TABLE `personas_contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personas_contacto_t_poblaciones1_idx` (`idPoblacion`),
  ADD KEY `fk_personas_contacto_t_provincias1_idx` (`idProvincias`),
  ADD KEY `fk_personas_contacto_t_paises1_idx` (`idPaises`);

--
-- Indices de la tabla `procedimientos_judiciales`
--
ALTER TABLE `procedimientos_judiciales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_procedimientos_judiciales_expedientes_evaluacion1_idx` (`idExpedienteEvaluacion`),
  ADD KEY `fk_procedimientos_judiciales_t_estados_procedimientos_judic_idx` (`idEstadoProdcedimientoJudicial`),
  ADD KEY `fk_procedimientos_judiciales_t_tipos_procedimientos_judicia_idx` (`idTipoProcedimientoJudicial`),
  ADD KEY `fk_procedimientos_judiciales_t_tipos_resoluciones_procedimi_idx` (`idTipoResolucionesProcedimientosJudiciales`),
  ADD KEY `fk_procedimientos_judiciales_fichas_personas1_idx` (`idFichaPersonal`),
  ADD KEY `fk_procedimientos_judiciales_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_procedimientos_judiciales_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_registro_fichas_personas1_idx` (`idFichaPersona`),
  ADD KEY `fk_registro_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_registro_usuarios2_idx` (`idUsuario_updated_at`),
  ADD KEY `i1registro` (`numero_ingreso`),
  ADD KEY `i2registro` (`fecha_salida`),
  ADD KEY `i3registro` (`numero_ingreso`);

--
-- Indices de la tabla `r_registro_camas`
--
ALTER TABLE `r_registro_camas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_camas_has_registro_registro1_idx` (`idRegistro`),
  ADD KEY `fk_camas_has_registro_camas1_idx` (`idCama`),
  ADD KEY `fk_camas_has_registro_usuarios1_idx` (`idUsuario_created_at`),
  ADD KEY `fk_camas_has_registro_usuarios2_idx` (`idUsuario_updated_at`);

--
-- Indices de la tabla `testigos_delitos_odio`
--
ALTER TABLE `testigos_delitos_odio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agresores_delitos_odio1_idx` (`idDelitoOdio`),
  ADD KEY `fk_testigos_te_confirmacion1_idx` (`presta_ayuda`),
  ADD KEY `fk_testigos_delitos_odio_te_sexo1_idx` (`idSexo`);

--
-- Indices de la tabla `te_confirmacion`
--
ALTER TABLE `te_confirmacion`
  ADD PRIMARY KEY (`confirmacion`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_ambitos_agresion`
--
ALTER TABLE `t_ambitos_agresion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_conceptos_ingresos_economicos`
--
ALTER TABLE `t_conceptos_ingresos_economicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_contratos_laboral`
--
ALTER TABLE `t_contratos_laboral`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_cuantias_economicas`
--
ALTER TABLE `t_cuantias_economicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_estados_civiles`
--
ALTER TABLE `t_estados_civiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_estados_procedimientos_judiciales`
--
ALTER TABLE `t_estados_procedimientos_judiciales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_formas_ingreso`
--
ALTER TABLE `t_formas_ingreso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_lugares_agresion`
--
ALTER TABLE `t_lugares_agresion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_momentos_agresion`
--
ALTER TABLE `t_momentos_agresion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_niveles_estudios`
--
ALTER TABLE `t_niveles_estudios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_orientacion_sexual`
--
ALTER TABLE `t_orientacion_sexual`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_origen_ingreso`
--
ALTER TABLE `t_origen_ingreso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_paises`
--
ALTER TABLE `t_paises`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`);

--
-- Indices de la tabla `t_parentescos`
--
ALTER TABLE `t_parentescos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_poblaciones`
--
ALTER TABLE `t_poblaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poblaciones_t_provincias_idx` (`idProvincia`);

--
-- Indices de la tabla `t_provincias`
--
ALTER TABLE `t_provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_servicios`
--
ALTER TABLE `t_servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_sexo`
--
ALTER TABLE `t_sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_sexo_ev`
--
ALTER TABLE `t_sexo_ev`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tiempos_desempleo`
--
ALTER TABLE `t_tiempos_desempleo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_agresion`
--
ALTER TABLE `t_tipos_agresion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_ausencia_documento`
--
ALTER TABLE `t_tipos_ausencia_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_contrato`
--
ALTER TABLE `t_tipos_contrato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_documento`
--
ALTER TABLE `t_tipos_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_enfermedades`
--
ALTER TABLE `t_tipos_enfermedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_habitaciones`
--
ALTER TABLE `t_tipos_habitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_procedimientos_judiciales`
--
ALTER TABLE `t_tipos_procedimientos_judiciales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_resoluciones_procedimientos_judiciales`
--
ALTER TABLE `t_tipos_resoluciones_procedimientos_judiciales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `t_tipos_violencia`
--
ALTER TABLE `t_tipos_violencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_tipo_usuario1_idx` (`tipo_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agresores_delitos_odio`
--
ALTER TABLE `agresores_delitos_odio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `agresores_violencia_genero`
--
ALTER TABLE `agresores_violencia_genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `camas`
--
ALTER TABLE `camas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `centro_social`
--
ALTER TABLE `centro_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expedientes_evaluacion`
--
ALTER TABLE `expedientes_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `e_apoyo_social`
--
ALTER TABLE `e_apoyo_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `e_causas_procedimientos_judiciales`
--
ALTER TABLE `e_causas_procedimientos_judiciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `e_centros_sociales`
--
ALTER TABLE `e_centros_sociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `e_consecuencias_agresiones`
--
ALTER TABLE `e_consecuencias_agresiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `e_enfermedades`
--
ALTER TABLE `e_enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `e_motivos_estancias`
--
ALTER TABLE `e_motivos_estancias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `e_motivos_renuncias`
--
ALTER TABLE `e_motivos_renuncias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `e_ocupaciones_principales`
--
ALTER TABLE `e_ocupaciones_principales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `e_resoluciones_procedimientos_judiciales`
--
ALTER TABLE `e_resoluciones_procedimientos_judiciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `e_tipos_documentos`
--
ALTER TABLE `e_tipos_documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `e_tipos_ingresos`
--
ALTER TABLE `e_tipos_ingresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `e_tipos_viviendas`
--
ALTER TABLE `e_tipos_viviendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas_personas`
--
ALTER TABLE `fichas_personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `inf_actuaciones_expedientes`
--
ALTER TABLE `inf_actuaciones_expedientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_do_delitos_odio`
--
ALTER TABLE `inf_do_delitos_odio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_fl_datos_economicos`
--
ALTER TABLE `inf_fl_datos_economicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_id_documentacion`
--
ALTER TABLE `inf_id_documentacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_sf_apoyo_social`
--
ALTER TABLE `inf_sf_apoyo_social`
  MODIFY `int` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_sf_familia`
--
ALTER TABLE `inf_sf_familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_sf_motivos_estancia`
--
ALTER TABLE `inf_sf_motivos_estancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_sf_relacion_familia`
--
ALTER TABLE `inf_sf_relacion_familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_sf_r_expedientes_evaluacion_personas_contacto`
--
ALTER TABLE `inf_sf_r_expedientes_evaluacion_personas_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inf_vg_violencia_genero`
--
ALTER TABLE `inf_vg_violencia_genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas_contacto`
--
ALTER TABLE `personas_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procedimientos_judiciales`
--
ALTER TABLE `procedimientos_judiciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `r_registro_camas`
--
ALTER TABLE `r_registro_camas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `testigos_delitos_odio`
--
ALTER TABLE `testigos_delitos_odio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_ambitos_agresion`
--
ALTER TABLE `t_ambitos_agresion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_conceptos_ingresos_economicos`
--
ALTER TABLE `t_conceptos_ingresos_economicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_contratos_laboral`
--
ALTER TABLE `t_contratos_laboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_cuantias_economicas`
--
ALTER TABLE `t_cuantias_economicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t_estados_civiles`
--
ALTER TABLE `t_estados_civiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `t_estados_procedimientos_judiciales`
--
ALTER TABLE `t_estados_procedimientos_judiciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_formas_ingreso`
--
ALTER TABLE `t_formas_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_lugares_agresion`
--
ALTER TABLE `t_lugares_agresion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_momentos_agresion`
--
ALTER TABLE `t_momentos_agresion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_niveles_estudios`
--
ALTER TABLE `t_niveles_estudios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `t_orientacion_sexual`
--
ALTER TABLE `t_orientacion_sexual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_origen_ingreso`
--
ALTER TABLE `t_origen_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `t_paises`
--
ALTER TABLE `t_paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t_parentescos`
--
ALTER TABLE `t_parentescos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `t_poblaciones`
--
ALTER TABLE `t_poblaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t_provincias`
--
ALTER TABLE `t_provincias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t_servicios`
--
ALTER TABLE `t_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_sexo`
--
ALTER TABLE `t_sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_sexo_ev`
--
ALTER TABLE `t_sexo_ev`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `t_tiempos_desempleo`
--
ALTER TABLE `t_tiempos_desempleo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `t_tipos_agresion`
--
ALTER TABLE `t_tipos_agresion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_tipos_ausencia_documento`
--
ALTER TABLE `t_tipos_ausencia_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_tipos_contrato`
--
ALTER TABLE `t_tipos_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_tipos_documento`
--
ALTER TABLE `t_tipos_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_tipos_enfermedades`
--
ALTER TABLE `t_tipos_enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t_tipos_habitaciones`
--
ALTER TABLE `t_tipos_habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_tipos_procedimientos_judiciales`
--
ALTER TABLE `t_tipos_procedimientos_judiciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_tipos_resoluciones_procedimientos_judiciales`
--
ALTER TABLE `t_tipos_resoluciones_procedimientos_judiciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `t_tipos_violencia`
--
ALTER TABLE `t_tipos_violencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agresores_delitos_odio`
--
ALTER TABLE `agresores_delitos_odio`
  ADD CONSTRAINT `fk_agresores_delitos_odio1` FOREIGN KEY (`idDelitoOdio`) REFERENCES `inf_do_delitos_odio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_agresores_delitos_odio_te_sexo1` FOREIGN KEY (`idSexo`) REFERENCES `t_sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `agresores_violencia_genero`
--
ALTER TABLE `agresores_violencia_genero`
  ADD CONSTRAINT `fk_agresores_violencia_genero_t_paises1` FOREIGN KEY (`idNacionalidad`) REFERENCES `t_paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_agresores_violencia_genero_violencia_genero1` FOREIGN KEY (`idViolenciaGenero`) REFERENCES `inf_vg_violencia_genero` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `camas`
--
ALTER TABLE `camas`
  ADD CONSTRAINT `fk_camas_habitaciones1` FOREIGN KEY (`idHabitacion`) REFERENCES `habitaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_camas_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_camas_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `centro_social`
--
ALTER TABLE `centro_social`
  ADD CONSTRAINT `fk_centro_social_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  ADD CONSTRAINT `fk_enfermedades_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_enfermedades_fichas_personas1` FOREIGN KEY (`idFichaPersona`) REFERENCES `fichas_personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_enfermedades_t_tipos_enfermedades1` FOREIGN KEY (`idTipoEnfermedad`) REFERENCES `t_tipos_enfermedades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_enfermedades_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_enfermedades_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `expedientes_evaluacion`
--
ALTER TABLE `expedientes_evaluacion`
  ADD CONSTRAINT `fk_expedientes_evaluacion_registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_contratos_laboral1` FOREIGN KEY (`idContratoLaboral`) REFERENCES `t_contratos_laboral` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_cuantias_economicas1` FOREIGN KEY (`idCuantiaEconomica`) REFERENCES `t_cuantias_economicas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_estados_civiles1` FOREIGN KEY (`idEstadoCivil`) REFERENCES `t_estados_civiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_formas_ingreso1` FOREIGN KEY (`idFormaIngreso`) REFERENCES `t_formas_ingreso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_origen_ingreso1` FOREIGN KEY (`idOrigenIngreso`) REFERENCES `t_origen_ingreso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_paises1` FOREIGN KEY (`idPaisProcedenciaInmediata`) REFERENCES `t_paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_paises2` FOREIGN KEY (`idNacionalidad`) REFERENCES `t_paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_poblaciones1` FOREIGN KEY (`idPoblacionProcedenciaInmediata`) REFERENCES `t_poblaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_poblaciones2` FOREIGN KEY (`idPoblacionEmpadronamiento`) REFERENCES `t_poblaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_provincias1` FOREIGN KEY (`idProvinciaProcedenciaInmediata`) REFERENCES `t_provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_sexo_ev1` FOREIGN KEY (`idSexoEv`) REFERENCES `t_sexo_ev` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_tiempos_desempleo1` FOREIGN KEY (`idTiempoDesempleo`) REFERENCES `t_tiempos_desempleo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_tipos_contrato1` FOREIGN KEY (`idTipoContrato`) REFERENCES `t_tipos_contrato` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_te_niveles_estudios1` FOREIGN KEY (`idNivelEstudios`) REFERENCES `t_niveles_estudios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_te_orientacion_sexual1` FOREIGN KEY (`idOrientacionSexual`) REFERENCES `t_orientacion_sexual` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_te_sexo1` FOREIGN KEY (`idSexo`) REFERENCES `t_sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `e_enfermedades`
--
ALTER TABLE `e_enfermedades`
  ADD CONSTRAINT `fk_t_enfermedades_t_tipos_enfermedades1` FOREIGN KEY (`idTipoEnfermedad`) REFERENCES `t_tipos_enfermedades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fichas_personas`
--
ALTER TABLE `fichas_personas`
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_contratos_laboral10` FOREIGN KEY (`idContratoLaboral`) REFERENCES `t_contratos_laboral` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_cuantias_economicas10` FOREIGN KEY (`idCuantiaEconomica`) REFERENCES `t_cuantias_economicas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_estados_civiles10` FOREIGN KEY (`idEstadoCivil`) REFERENCES `t_estados_civiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_paises20` FOREIGN KEY (`idNacionalidad`) REFERENCES `t_paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_paises30` FOREIGN KEY (`idPaisNacimiento`) REFERENCES `t_paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_poblaciones20` FOREIGN KEY (`idPoblacionEmpadronamiento`) REFERENCES `t_poblaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_poblaciones30` FOREIGN KEY (`idPoblacionNacimiento`) REFERENCES `t_poblaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_provincias20` FOREIGN KEY (`idProvinciaNacimiento`) REFERENCES `t_provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_sexo_ev10` FOREIGN KEY (`idSexoEv`) REFERENCES `t_sexo_ev` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_tiempos_desempleo10` FOREIGN KEY (`idTiempoDesempleo`) REFERENCES `t_tiempos_desempleo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_t_tipos_contrato10` FOREIGN KEY (`idTipoContrato`) REFERENCES `t_tipos_contrato` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_te_niveles_estudios10` FOREIGN KEY (`idNivelEstudios`) REFERENCES `t_niveles_estudios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_expedientes_evaluacion_te_orientacion_sexual10` FOREIGN KEY (`idOrientacionSexual`) REFERENCES `t_orientacion_sexual` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fichas_personas_te_sexo1` FOREIGN KEY (`idSexo`) REFERENCES `t_sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fichas_personas_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fichas_personas_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `fk_habitaciones_t_tipos_habitaciones1` FOREIGN KEY (`idTipoHabitacion`) REFERENCES `t_tipos_habitaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_habitaciones_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_habitaciones_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_actuaciones_expedientes`
--
ALTER TABLE `inf_actuaciones_expedientes`
  ADD CONSTRAINT `fk_actuaciones_expedientes_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_actuaciones_expedientes_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_actuaciones_expedientes_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_do_delitos_odio`
--
ALTER TABLE `inf_do_delitos_odio`
  ADD CONSTRAINT `fk_delitos_odio_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_t_momentos_agresion1` FOREIGN KEY (`idMomentoAgresion`) REFERENCES `t_momentos_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_t_tipos_violencia1` FOREIGN KEY (`idTipoViolencia`) REFERENCES `t_tipos_violencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_confirmacion5` FOREIGN KEY (`denuncia_agresion_te`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_confirmacion6` FOREIGN KEY (`denuncia_favorable_te`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_confirmacion7` FOREIGN KEY (`solicitud_apoyo_te`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_lugares_agresion1` FOREIGN KEY (`idLugarAgresion`) REFERENCES `t_lugares_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_tipos_agresion2` FOREIGN KEY (`idTipoAgresion`) REFERENCES `t_tipos_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_do_delitos_odio_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_do_delitos_odio_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_fl_datos_economicos`
--
ALTER TABLE `inf_fl_datos_economicos`
  ADD CONSTRAINT `fk_datos_economicos_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_datos_economicos_t_conceptos_ingresos_economicos1` FOREIGN KEY (`idConceptoIngreso`) REFERENCES `t_conceptos_ingresos_economicos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_datos_economicos_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_datos_economicos_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_id_documentacion`
--
ALTER TABLE `inf_id_documentacion`
  ADD CONSTRAINT `fk_documentacion_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentacion_t_tipos_ausencia_documento1` FOREIGN KEY (`idTipoAusenciaDocumento`) REFERENCES `t_tipos_ausencia_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentacion_t_tipos_documento1` FOREIGN KEY (`idTipoDocumento`) REFERENCES `t_tipos_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentacion_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentacion_usuarios2` FOREIGN KEY (`idUsuario_uptaded_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_sf_apoyo_social`
--
ALTER TABLE `inf_sf_apoyo_social`
  ADD CONSTRAINT `fk_inf_sf_apoyo_social_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_sf_familia`
--
ALTER TABLE `inf_sf_familia`
  ADD CONSTRAINT `fk_Familia_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_sf_familia_t_parentescos1` FOREIGN KEY (`idParentesco`) REFERENCES `t_parentescos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_sf_motivos_estancia`
--
ALTER TABLE `inf_sf_motivos_estancia`
  ADD CONSTRAINT `fk_motivos_estancia_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_sf_relacion_familia`
--
ALTER TABLE `inf_sf_relacion_familia`
  ADD CONSTRAINT `fk_Familia_expedientes_evaluacion10` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_relacion_familia_t_parentescos1` FOREIGN KEY (`idParentesco`) REFERENCES `t_parentescos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_sf_r_expedientes_evaluacion_personas_contacto`
--
ALTER TABLE `inf_sf_r_expedientes_evaluacion_personas_contacto`
  ADD CONSTRAINT `fk_personas_contacto_has_expedientes_evaluacion_expedientes_e1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personas_contacto_has_expedientes_evaluacion_personas_cont1` FOREIGN KEY (`idPersonaContacto`) REFERENCES `personas_contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_r_expedientes_evaluacion_personas_contacto_t_parentescos1` FOREIGN KEY (`idParentesco`) REFERENCES `t_parentescos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inf_vg_violencia_genero`
--
ALTER TABLE `inf_vg_violencia_genero`
  ADD CONSTRAINT `fk_delitos_odio_expedientes_evaluacion10` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_confirmacion50` FOREIGN KEY (`denuncia_agresion_te`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_confirmacion60` FOREIGN KEY (`denuncia_favorable_te`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delitos_odio_te_confirmacion70` FOREIGN KEY (`solicitud_apoyo_te`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_t_ambitos_agresion1` FOREIGN KEY (`idAmbitoAgresion`) REFERENCES `t_ambitos_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_t_lugares_agresion1` FOREIGN KEY (`idLugarAgresion`) REFERENCES `t_lugares_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_t_momentos_agresion1` FOREIGN KEY (`idMomentoAgresion`) REFERENCES `t_momentos_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_t_tipos_agresion1` FOREIGN KEY (`idTipoAgresion`) REFERENCES `t_tipos_agresion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_t_tipos_violencia1` FOREIGN KEY (`idTipoViolencia`) REFERENCES `t_tipos_violencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inf_vg_violencia_genero_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `personas_contacto`
--
ALTER TABLE `personas_contacto`
  ADD CONSTRAINT `fk_personas_contacto_t_paises1` FOREIGN KEY (`idPaises`) REFERENCES `t_paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personas_contacto_t_poblaciones1` FOREIGN KEY (`idPoblacion`) REFERENCES `t_poblaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personas_contacto_t_provincias1` FOREIGN KEY (`idProvincias`) REFERENCES `t_provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `procedimientos_judiciales`
--
ALTER TABLE `procedimientos_judiciales`
  ADD CONSTRAINT `fk_procedimientos_judiciales_expedientes_evaluacion1` FOREIGN KEY (`idExpedienteEvaluacion`) REFERENCES `expedientes_evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procedimientos_judiciales_fichas_personas1` FOREIGN KEY (`idFichaPersonal`) REFERENCES `fichas_personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procedimientos_judiciales_t_estados_procedimientos_judicia1` FOREIGN KEY (`idEstadoProdcedimientoJudicial`) REFERENCES `t_estados_procedimientos_judiciales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procedimientos_judiciales_t_tipos_procedimientos_judiciales1` FOREIGN KEY (`idTipoProcedimientoJudicial`) REFERENCES `t_tipos_procedimientos_judiciales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procedimientos_judiciales_t_tipos_resoluciones_procedimien1` FOREIGN KEY (`idTipoResolucionesProcedimientosJudiciales`) REFERENCES `t_tipos_resoluciones_procedimientos_judiciales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procedimientos_judiciales_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procedimientos_judiciales_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `fk_registro_fichas_personas1` FOREIGN KEY (`idFichaPersona`) REFERENCES `fichas_personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `r_registro_camas`
--
ALTER TABLE `r_registro_camas`
  ADD CONSTRAINT `fk_camas_has_registro_camas1` FOREIGN KEY (`idCama`) REFERENCES `camas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_camas_has_registro_registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_camas_has_registro_usuarios1` FOREIGN KEY (`idUsuario_created_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_camas_has_registro_usuarios2` FOREIGN KEY (`idUsuario_updated_at`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `testigos_delitos_odio`
--
ALTER TABLE `testigos_delitos_odio`
  ADD CONSTRAINT `fk_agresores_delitos_odio10` FOREIGN KEY (`idDelitoOdio`) REFERENCES `inf_do_delitos_odio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_testigos_delitos_odio_te_sexo1` FOREIGN KEY (`idSexo`) REFERENCES `t_sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_testigos_te_confirmacion1` FOREIGN KEY (`presta_ayuda`) REFERENCES `te_confirmacion` (`confirmacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t_poblaciones`
--
ALTER TABLE `t_poblaciones`
  ADD CONSTRAINT `fk_poblaciones_t_provincias` FOREIGN KEY (`idProvincia`) REFERENCES `t_provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_tipo_usuario1` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
