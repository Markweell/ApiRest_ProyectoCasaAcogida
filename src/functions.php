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
    $expiration = time()+ EXPIRE_TIME_EMAIL;
    $issuer = 'localhost';
    return Token::create($userId, SECRET, $expiration, $issuer);
}

/**
 * Genera un token para la sesión del usuario
 * @param int $idUsuario: id del Usuario al que le vamos a generar el token.
 */
function generateTokenLogin($userId, $username, $userProfile){
    $payload = [
        'user_id' => $userId,
        'user_name' => $username,
        'profile' => $userProfile,
        'iat' => time(),
        'exp' => time() + EXPIRE_TIME_SESSION,
        'iss' => 'server'
    ];
    
    return Token::customPayload($payload, SECRET);
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
function decodeBase64Image($Base64Img, $id){

//eliminamos data:image/png; y base64, de la cadena que tenemos
//hay otras formas de hacerlo                
$extension = getExtension(substr($Base64Img, 11,1));   
list(, $Base64Img) = explode(';', $Base64Img);
list(, $Base64Img) = explode(',', $Base64Img);
//Decodificamos $Base64Img codificada en base64.
$Base64Img = base64_decode($Base64Img);
//escribimos la información obtenida en un archivo llamado 
//unodepiera.png para que se cree la imagen correctamente


file_put_contents('image/imagenPerfil'.$id.'.'.$extension, $Base64Img);
}
function getExtension($letra){
    switch($letra){
        case 'j':
            return 'jpg';
        case 'p':
            return 'png';
        case 'g':
            return 'gif';
        case 'w': 
            return 'webp';
    }
}
function getTokenOfHeader(){
    return getallheaders()['token'];
}
function getLastIdFichaPersonal($conexion){
    $res=$conexion->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'api_proyecto_php' AND TABLE_NAME = 'ficha_personal'");
    $res->execute();
    $rows = $res->fetch();
    return $rows['AUTO_INCREMENT'];
}

function auditChange($conexion, $id_usuario, $description){
    $valores = [":idUsuario"=>$id_usuario, ":description"=>$description];
    $consulta = $conexion->prepare('INSERT INTO auditoria(description,id_usuario) 
    VALUES (:description, :idUsuario)');
    $consulta->execute($valores);

}