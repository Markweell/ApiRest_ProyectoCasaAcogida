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
require 'routesFunction/obtenerTiposDocumentos.php';
require 'routesFunction/obtenerPaises.php';
require 'routesFunction/obtenerSexos.php';
require 'routesFunction/obtenerCamasLibres.php';
require 'routesFunction/obtenerPersonasFueraDeCasa.php';
require 'routesFunction/obtenerPersonasEnCasa.php';
require 'routesFunction/obtenerOcupacion.php';
require 'routesFunction/obtenerExpedientesEvaluacionDePersonasEnCasa.php';
//POST
require 'routesFunction/pruebasPhp.php'; // esta hay que borrarla
require 'routesFunction/forgotPassword.php';
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

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Helper\Set;

// Routes
// Grupo de rutas para el API
$app->group('/api', function () use ($app) {
    // Version group
    $app->group('/v1', function () use ($app) {

        $app->get('/obtenerFichasPersonales', 'obtenerFichasPersonales');
        $app->get('/getRandomToken','getRandomToken'); //Usado para pruebas
        $app->get('/obtenerTiposDocumentos', 'obtenerTiposDocumentos');
        $app->get('/obtenerPaises', 'obtenerPaises');
        $app->get('/obtenerSexos', 'obtenerSexos');
        $app->get('/obtenerCamasLibres', 'obtenerCamasLibres');
        $app->get('/obtenerPersonasFueraDeCasa', 'obtenerPersonasFueraDeCasa');
        $app->get('/obtenerPersonasEnCasa', 'obtenerPersonasEnCasa');
        $app->get('/obtenerOcupacion', 'obtenerOcupacion');
        $app->get('/obtenerExpedientesEvaluacionDePersonasEnCasa', 'obtenerExpedientesEvaluacionDePersonasEnCasa');
        $app->post('/prueba','pruebasPhp'); //Usado para pruebas
        $app->post('/forgotPassword', 'forgotPassword');
        $app->post('/validateToken', 'validateToken');
        $app->post('/changePassword', 'changePassword');
        $app->post('/validateLogin', 'validateLogin');
        $app->post('/agregarFichaPersonal','agregarFichaPersonal');
        $app->post('/obtenerFichaPersonal','obtenerFichaPersonal');
        $app->post('/obtenerFichasPersonalesPorFechaDeCreacion','obtenerFichasPersonalesPorFechaDeCreacion');
        $app->post('/obtenerFichasPersonalesPorFechaDeEntrada','obtenerFichasPersonalesPorFechaDeEntrada');
        $app->post('/obtenerFichasPersonalesPorFechaDeSalida','obtenerFichasPersonalesPorFechaDeSalida');
        $app->post('/agregarNuevaEntrada','agregarNuevaEntrada');
        $app->post('/agregarNuevaSalida','agregarNuevaSalida');
    });
  });

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// function obtenerUsuarios($response, $request, $next) {
//     $sql = "SELECT * FROM usuarios";
//     // if(getallheaders()['Token']!="sucess"){
//     //     return json_encode("no autorizado");
//     // }
//     try {
//         $stmt = getConnection()->query($sql);
//         $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
//         $db = null;
//         return json_encode($usuarios);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     }
// }

// function obtenerUsuario($request){
//     $id= $request->getAttribute('id');
//     $sql = "SELECT * FROM usuarios where id=:id";
//     try {
//         $db = getConnection();
//         $stmt = $db->prepare($sql);
//         $stmt->bindParam("id", $id);
//         $stmt->execute();
//         $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);
//         $db = null;
//         return json_encode($usuarios);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     }
// }


// function obtenerPeliculas($response) {
//     $sql = "SELECT * FROM peliculas";
//     try {
//         $stmt = getConnection()->query($sql);
//         $peliculas = $stmt->fetchAll(PDO::FETCH_OBJ);
//         $db = null;
//         return json_encode($peliculas);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     } 
// }
// function obtenerPelicula($request){
//     $id= $request->getAttribute('id');
//     $sql = "SELECT * FROM peliculas where id=:id";
//     try {
//         $db = getConnection();
//         $stmt = $db->prepare($sql);
//         $stmt->bindParam("id", $id);
//         $stmt->execute();
//         $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);
//         $db = null;
//         return json_encode($usuarios);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     }
// }
// function obtenerSeries($response) {
//     $sql = "SELECT * FROM series";
//     try {
//         $stmt = getConnection()->query($sql);
//         $peliculas = $stmt->fetchAll(PDO::FETCH_OBJ);
//         $db = null;
//         return json_encode($peliculas);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     } 
// }
// function obtenerSerie($request){
//     $id= $request->getAttribute('id');
//     $sql = "SELECT * FROM series where id=:id";
//     try {
//         $db = getConnection();
//         $stmt = $db->prepare($sql);
//         $stmt->bindParam("id", $id);
//         $stmt->execute();
//         $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);
//         $db = null;
//         return json_encode($usuarios);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     }
// }
// function crearUsuario($request) {
//     $emp = json_decode($request->getBody());
    
//     $sql = "INSERT INTO usuarios (nombre, email, password, tipo) VALUES (:nombre, :email, :password, :tipo)";
//     try {
//         $db = getConnection();
//         $stmt = $db->prepare($sql);
//         $stmt->bindParam("nombre", $emp->nombre);
//         $stmt->bindParam("email", $emp->email);
//         $stmt->bindParam("password", $emp->password);
//         $stmt->bindParam("tipo", $emp->tipo);
//         $stmt->execute();
//         $emp->id = $db->lastInsertId();
//         $db = null;
//         echo json_encode($emp);
//     } catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     }
// }
