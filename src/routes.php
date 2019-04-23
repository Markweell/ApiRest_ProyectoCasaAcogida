<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Token");
    header("Content-Type: application/json");
require_once "Conexion.php";

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Helper\Set;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Routes
// Grupo de rutas para el API
$app->group('/api', function () use ($app) {
    // Version group
    $app->group('/v1', function () use ($app) {
        $app->post('/forgotPassword', 'forgotPassword');
        $app->get('/usuarios/{id}', 'obtenerUsuario');
    });
  });

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

function forgotPassword($response, $request, $next) {
    // $conexion = \Conexion::getConnection();
    // $consulta = $conexion->prepare('SELECT * FROM usuarios');
    // $consulta->execute();
    // return json_encode($consulta->fetchAll(PDO::FETCH_ASSOC));
    $variable = json_decode($response->getBody());
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                        // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Username = "emaildepruebaparaphp@gmail.com";                 // SMTP username
        $mail->Password = "php1234!";                           // SMTP password
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('emaildepruebaparaphp@gmail.com', 'Sistema');
        $mail->addAddress($variable->email);

        $mail->isHTML(true);
        $mail->Subject = 'Hola Marcos, vamos a resetear su password';
        $mail->Body    = 'Ha contactado con exito con la web de guias turisticas.';
        $mail->AltBody = 'Ha contactado con exito con la web de guias turisticas.';

        $mail->send();
        $sucessful='Le hemos enviado un mail de confirmación';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    
    return json_encode($variable->email);
}

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
