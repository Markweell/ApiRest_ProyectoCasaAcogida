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
use ReallySimpleJWT\Token;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Validate;
use ReallySimpleJWT\Encode;

const SECRET = 'Genera1290Token[*';
// Routes
// Grupo de rutas para el API
$app->group('/api', function () use ($app) {
    // Version group
    $app->group('/v1', function () use ($app) {
        $app->post('/forgotPassword', 'forgotPassword');
        $app->get('/usuarios/{id}', 'obtenerUsuario');
        $app->post('/validateToken', 'validateToken');
        $app->post('/changePassword', 'changePassword');
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
    $email = $variable->email;

    $conexion = \Conexion::getConnection();
    $valores = [":email"=>$email];
    $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email');
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetch();
    $idUsuario = $resultadoBusqueda['id'];
    //return json_encode($resultadoBusqueda['id']);

    if(!$resultadoBusqueda){
       return json_encode(false);
    }
    
    $userId = $idUsuario;
    //$secret = 'Genera1290Token[*';
    $expiration = time()+15;
    $issuer = 'localhost';

    $token = Token::create($userId, SECRET, $expiration, $issuer);

    $asunto= 'Hola Marcos, vamos a resetear su contraseña';

    $body = '<p>Hola,</p>
    <p>Hemos recibido una solicitud de un restablecimiento de contraseña de la cuenta asociada a esta dirección de 
    correo electrónico.</p>
    <p> Para confirmar y restablecer su contraseña, por favor haga click
    <a href="http://localhost:4200/change_password/'.$token.'">aquí</a> 
    o accede a esta dirección 
    <a href="http://localhost:4200/change_password/'.$token.'">http://localhost:4200/change_password/'.$token.'</a>. 
    Si no has iniciado esta solicitud, ignore este mensaje.</p>
    <p>Saludos</p>';
    
    return json_encode(sendEmail($email, $asunto, $body));
}

function sendEmail($email, $asunto, $body){
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Username = "emaildepruebaparaphp@gmail.com";   // SMTP username
        $mail->Password = "php1234!";                         // SMTP password
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('emaildepruebaparaphp@gmail.com', 'Sistema');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $body;
        $mail->CharSet = 'UTF-8';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function validateToken($response, $request, $next){
    $resp = json_decode($response->getBody());
    $token = $resp->token;

    $comprobacionToken = validarToken($token);
    return json_encode($comprobacionToken);
}

function changePassword($response, $request, $next){
    $resp = json_decode($response->getBody());
    $token = $resp->token;


    $userId = 10;
    //$secret = 'Genera1290Token[*';
    $expiration = time()+3600;
    $issuer = 'localhost';

    $token = Token::create($userId, SECRET, $expiration, $issuer);

    $comprobacionToken = validarToken($token);
    if(!$comprobacionToken)
        return json_encode(false);
    
    $jwt= new Jwt($token, SECRET);
    $parse = new Parse ($jwt,new Validate(), new Encode());
    $parsed = $parse->validate()
    ->validateExpiration()
    ->parse();

    // // Return the token header claims as an associative array.
    // $parsed->getHeader();

    // // Return the token payload claims as an associative array.
    // $parsed->getPayload();
    return json_encode($parsed->getPayload()['user_id']);

}

function validarToken($token){
    return  Token::validate($token, SECRET);
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
