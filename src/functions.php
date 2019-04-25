<?php
use ReallySimpleJWT\Token;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Validate;
use ReallySimpleJWT\Encode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "constants.php";

/**
 * Genera un token en el que encriptamos un idUsuario
 * @param int $idUsuario: id del Usuario al que le vamos a generar el token.
 */
function generateToken($idUsuario){
    $userId = $idUsuario;
    $expiration = time()+ EXPIRE_TIME;
    $issuer = 'localhost';
    return Token::create($userId, SECRET, $expiration, $issuer);
}

/**
 * Encripta una contraseña pasada por parámtro
 * @param $password: contraseña a encriptar
 */
function encrypt_password($password){
    return password_hash($password, PASSWORD_ARGON2I);
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