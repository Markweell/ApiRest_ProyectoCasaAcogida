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

// Constante que vamos a usar para codificar nuestros tokens
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
        $app->post('/validateLogin', 'validateLogin');
    });
  });

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
/**
 * Recoge un email de una peticion post, se comprueba que este está en la base de datos y si lo está se le genera
 * un token y se le envia un correo con ese token.
 */
function forgotPassword($response, $request, $next) {
    $variable = json_decode($response->getBody());
    $email = $variable->email;

    $conexion = \Conexion::getConnection();
    $valores = [":email"=>$email];
    $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email');
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetch();
    $idUsuario = $resultadoBusqueda['id'];
    $nombreUsuario = $resultadoBusqueda['nombre'];

    if(!$resultadoBusqueda){return json_encode(false);}

    $token = generateToken($idUsuario);

    $asunto= 'Hola '.$nombreUsuario.', vamos a resetear su contraseña';
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

/**
 * Genera un token en el que encriptamos un idUsuario
 * @param int $idUsuario: id del Usuario al que le vamos a generar el token.
 */
function generateToken($idUsuario){
    $userId = $idUsuario;
    $expiration = time()+3600;
    $issuer = 'localhost';
    return Token::create($userId, SECRET, $expiration, $issuer);
}

/**
 * Envia un email con asunto y una descripción
 * @param string email: email al que se va a enviar el correo,
 * @param string remitente: nombre de la persona que va a recibir el correo,
 * @param string asunto: asunto del email que se va a enviar,
 * @param string body: cuerpo del email que se va a enviar
 */
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

/**
 * Recibe un token de una petición post y lo valida.
 */
function validateToken($response, $request, $next){
    $resp = json_decode($response->getBody());
    $token = $resp->token;

    $comprobacionToken = validarToken($token);
    return json_encode($comprobacionToken);
}

/**
 * Recibe un token y una contraseña de una petición post y si el token es válido y no ha expirado,
 * modifica la contraseña del usuario cuyo id se encuentra en el token.
 */
function changePassword($response, $request, $next){
    $resp = json_decode($response->getBody());
    $token = $resp->token;              
    $password = $resp->password;

    $comprobacionToken = validarToken($token);

    if(!$comprobacionToken)
        return json_encode(false);
    
    $idUsuario = getIdOfToken($token);
   
    $conexion = \Conexion::getConnection();
    $valores = [":id"=>$idUsuario, ":password"=>$password];
    $consulta = $conexion->prepare('UPDATE usuarios SET password=:password where id = :id');
    $resultadoUpdate= $consulta->execute($valores);

    return json_encode($resultadoUpdate);
}

/**
 * Se encarga de validar un token proporcionado
 * @param string $token: se trata del token a validar.
 */
function validarToken($token){
    return  Token::validate($token, SECRET);
}

/**
 * Extrae el id del usuario de un token proporcionado
 * @param string $token: token a porporcionar.
 */
function getIdOfToken($token){
    $jwt= new Jwt($token, SECRET);
    $parse = new Parse ($jwt,new Validate(), new Encode());
    $parsed = $parse->validate()
    ->validateExpiration()
    ->parse();

    return $parsed->getPayload()['user_id'];
}

/**
 * Recibe una petición post con un email y una password, comprueba que existen en la base de datos y
 * en el caso de que existan, devuelve una json con id, nombre y token generado en base al id del usuario 
 */
function validateLogin($response, $request, $next){
    $resp = json_decode($response->getBody());
    $email = $resp->email;              
    $password = $resp->password;

    $conexion = \Conexion::getConnection();
    $valores = [":email"=>$email, ":password"=>$password];
    $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email and password = :password');
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetch();
    if(!$resultadoBusqueda){return json_encode(false);}
    $idUsuario = $resultadoBusqueda['id'];
    $nombreUsuario = $resultadoBusqueda['nombre'];

    $token = generateToken($idUsuario);
    return json_encode(["id"=>$idUsuario,"nombre"=>$nombreUsuario, "token"=>$token]);
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
