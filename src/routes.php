<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, token");
header("Content-Type: application/json");

require_once "Conexion.php";
require_once "functions.php";
require_once "constants.php";

//GET
require 'routesFunction/obtenerFichasPersonales.php';
require 'routesFunction/obtenerConsecuenciasAgresion.php';
require 'routesFunction/obtenerMomentosAgresion.php';
require 'routesFunction/obtenerTiposViolencia.php';
require 'routesFunction/obtenerLugaresAgresion.php';
require 'routesFunction/obtenerEstadosCiviles.php';
require 'routesFunction/obtenerPermisosResidencia.php';
require 'routesFunction/obtenerSexosEv.php';
require 'routesFunction/obtenerOrientacionSexual.php';
require 'routesFunction/obtenerTiposDocumentos.php';
require 'routesFunction/obtenerPaises.php';
require 'routesFunction/obtenerSexos.php';
require 'routesFunction/obtenerCamasLibres.php';
require 'routesFunction/obtenerPersonasFueraDeCasa.php';
require 'routesFunction/obtenerPersonasEnCasa.php';
require 'routesFunction/obtenerOcupacion.php';
require 'routesFunction/obtenerExpedientesEvaluacionDePersonasEnCasa.php';
require 'routesFunction/obtenerDatosParentesco.php';
require 'routesFunction/obtenerFormasIngreso.php';
require 'routesFunction/obtenerOrigenIngreso.php';
require 'routesFunction/obtenerTiposAusenciaDocumento.php';
require 'routesFunction/obtenerTipoApoyoSocial.php';
require 'routesFunction/obtenerApoyosSociales.php';
require 'routesFunction/obtenerMotivosDeEstanciaCentro.php';
require 'routesFunction/obtenerCentrosSociales.php';
require 'routesFunction/obtenerCentrosSocialesRedCohabita.php';
require 'routesFunction/obtenerTiposNivelEducacion.php';
require 'routesFunction/obtenerTiposSituacionLaboral.php';
require 'routesFunction/obtenerTiempoDesempleado.php';
require 'routesFunction/obtenerContratoLaboral.php';
require 'routesFunction/obtenerTipoContratoLaboral.php';
require 'routesFunction/obtenerPrincipalOcupacion.php';
require 'routesFunction/obtenerTiposIngresosEconomicos.php';
require 'routesFunction/obtenerTiposDeBeneficios.php';
require 'routesFunction/obtenerCuantiasEconomicas.php';
require 'routesFunction/obtenerAnniosParaInformes.php';
require 'routesFunction/obtenerInformeIngresosPorSexo.php';

//POST
require 'routesFunction/pruebasPhp.php'; // esta hay que borrarla
require 'routesFunction/forgotPassword.php';
require 'routesFunction/obtenerInformacionExpediente.php';
require 'routesFunction/validateToken.php';
require 'routesFunction/changePassword.php';
require 'routesFunction/validateLogin.php';
require 'routesFunction/obtenerFichaPersonal.php';
require 'routesFunction/getRandomToken.php'; //esta también
require 'routesFunction/agregarFichaPersonal.php';
require 'routesFunction/obtenerFichasPersonalesPorFechaDeCreacion.php';
require 'routesFunction/obtenerFichasPersonalesPorFechaDeEntrada.php';
require 'routesFunction/obtenerFichasPersonalesPorFechaDeSalida.php';
require 'routesFunction/agregarNuevaEntrada.php';
require 'routesFunction/agregarNuevaSalida.php';
require 'routesFunction/cambiarCama.php';
require 'routesFunction/obtenerProvincias.php';
require 'routesFunction/obtenerMunicipios.php';

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Helper\Set;

// Routes
// Grupo de rutas para el API
$app->group('/api', function () use ($app) {
    // Version group
    $app->group('/v1', function () use ($app) {

        $app->get('/obtenerFichasPersonales', 'obtenerFichasPersonales');
        $app->get('/obtenerConsecuenciasAgresionFisicas', 'obtenerConsecuenciasAgresionFisicas');
        $app->get('/obtenerConsecuenciasAgresionPsicologicas', 'obtenerConsecuenciasAgresionPsicologicas');
        $app->get('/obtenerConsecuenciasAgresionSocioEconomicas', 'obtenerConsecuenciasAgresionSocioEconomicas');
        $app->get('/obtenerMomentosAgresion', 'obtenerMomentosAgresion');
        $app->get('/obtenerLugaresAgresion', 'obtenerLugaresAgresion');
        $app->get('/obtenerTiposViolencia', 'obtenerTiposViolencia');
        $app->get('/obtenerTiposAusenciaDocumento','obtenerTiposAusenciaDocumento');
        $app->get('/obtenerPermisosResidencia','obtenerPermisosResidencia');
        $app->get('/obtenerEstadosCiviles','obtenerEstadosCiviles');
        $app->get('/obtenerFormasIngreso','obtenerFormasIngreso');
        $app->get('/obtenerSexosEv','obtenerSexosEv');
        $app->get('/obtenerOrientacionSexual','obtenerOrientacionSexual');
        $app->get('/obtenerOrigenIngreso','obtenerOrigenIngreso');
        $app->get('/getRandomToken','getRandomToken'); //Usado para pruebas
        $app->get('/obtenerTiposDocumentos', 'obtenerTiposDocumentos');
        $app->get('/obtenerPaises', 'obtenerPaises');
        $app->get('/obtenerSexos', 'obtenerSexos');
        $app->get('/obtenerCamasLibres', 'obtenerCamasLibres');
        $app->get('/obtenerPersonasFueraDeCasa', 'obtenerPersonasFueraDeCasa');
        $app->get('/obtenerPersonasEnCasa', 'obtenerPersonasEnCasa');
        $app->get('/obtenerOcupacion', 'obtenerOcupacion');
        $app->get('/obtenerExpedientesEvaluacionDePersonasEnCasa', 'obtenerExpedientesEvaluacionDePersonasEnCasa');
        $app->get('/obtenerDatosParentesco', 'obtenerDatosParentesco');
        $app->get('/obtenerTipoApoyoSocial', 'obtenerTipoApoyoSocial');
        $app->get('/obtenerApoyosSociales', 'obtenerApoyosSociales');
        $app->get('/obtenerMotivosDeEstanciaCentro', 'obtenerMotivosDeEstanciaCentro');
        $app->get('/obtenerCentrosSociales', 'obtenerCentrosSociales');
        $app->get('/obtenerCentrosSocialesRedCohabita', 'obtenerCentrosSocialesRedCohabita');
        $app->get('/obtenerTiposNivelEducacion', 'obtenerTiposNivelEducacion');
        $app->get('/obtenerTiposSituacionLaboral', 'obtenerTiposSituacionLaboral');
        $app->get('/obtenerTiempoDesempleado', 'obtenerTiempoDesempleado');
        $app->get('/obtenerContratoLaboral', 'obtenerContratoLaboral');
        $app->get('/obtenerTipoContratoLaboral', 'obtenerTipoContratoLaboral');
        $app->get('/obtenerPrincipalOcupacion', 'obtenerPrincipalOcupacion');
        $app->get('/obtenerTiposIngresosEconomicos', 'obtenerTiposIngresosEconomicos');
        $app->get('/obtenerTiposDeBeneficios', 'obtenerTiposDeBeneficios');
        $app->get('/obtenerCuantiasEconomicas', 'obtenerCuantiasEconomicas');
        $app->get('/obtenerAnniosParaInformes', 'obtenerAnniosParaInformes');
        $app->get('/obtenerInformeIngresosPorSexo', 'obtenerInformeIngresosPorSexo');
        $app->post('/prueba','pruebasPhp'); //Usado para pruebas
        $app->post('/forgotPassword', 'forgotPassword');
        $app->post('/validateToken', 'validateToken');
        $app->post('/changePassword', 'changePassword');
        $app->post('/validateLogin', 'validateLogin');
        $app->post('/obtenerInformacionExpediente', 'obtenerInformacionExpediente');
        $app->post('/agregarFichaPersonal','agregarFichaPersonal');
        $app->post('/obtenerFichaPersonal','obtenerFichaPersonal');
        $app->post('/obtenerFichasPersonalesPorFechaDeCreacion','obtenerFichasPersonalesPorFechaDeCreacion');
        $app->post('/obtenerFichasPersonalesPorFechaDeEntrada','obtenerFichasPersonalesPorFechaDeEntrada');
        $app->post('/obtenerFichasPersonalesPorFechaDeSalida','obtenerFichasPersonalesPorFechaDeSalida');
        $app->post('/agregarNuevaEntrada','agregarNuevaEntrada');
        $app->post('/agregarNuevaSalida','agregarNuevaSalida');
        $app->post('/cambiarCama','cambiarCama');
        $app->post('/obtenerProvincias','obtenerProvincias');
        $app->post('/obtenerMunicipios','obtenerMunicipios');
    });
  });

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});