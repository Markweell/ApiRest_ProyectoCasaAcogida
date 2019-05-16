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
        'exp' => time() + 7200,
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


function auditChange($conexion, $id_usuario,$id_ficha_personal, $description){
    $valores = [":idUsuario"=>$id_usuario, ":idFichaPersonal"=>$id_ficha_personal, ":description"=>$description];
    $consulta = $conexion->prepare('INSERT INTO auditoria(description,id_usuario,id_ficha_personal) 
    VALUES (:description, :idUsuario, :idFichaPersonal)');
    $consulta->execute($valores);

}

function getHabitaciones($conexion)
{
    $consulta = $conexion->prepare('SELECT habitaciones.id , habitacion, t_tipos_habitaciones.tipo_habitacion FROM `habitaciones`, t_tipos_habitaciones where habitaciones.idTipoHabitacion = t_tipos_habitaciones.id');
    $consulta->execute();
    return $consulta->fetchAll();
}

function getCamasHabitacion($conexion,$idHabitacion)
{
    $valores = [":idHabitacion" => $idHabitacion];
    $consulta = $conexion->prepare('SELECT camas.id, camas.cama from camas where camas.idHabitacion = :idHabitacion');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}

function getDatosCamaLibre($conexion,$idCama)
{
    $valores = [":idCama" => $idCama];
    $consulta = $conexion->prepare('SELECT * from camas where id = :idCama AND id NOT IN (SELECT r_registro_camas.idCama FROM r_registro_camas) OR id IN (SELECT r_registro_camas.idCama FROM r_registro_camas where r_registro_camas.fecha_final IS NOT NULL AND r_registro_camas.id = (SELECT MAX(ID) FROM r_registro_camas where r_registro_camas.idCama = :idCama))');
    $consulta->execute($valores);
    return $consulta->fetchAll();
}
function getDatosCreatedAndUpdated(){
    $thisDate = $date = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s").".000000";    
    $idUsuario = getIdOfToken(getTokenOfHeader());
    return ["user"=>$idUsuario, "date"=>$thisDate];
}
function getPersonas($conexion)
{
    $consulta = $conexion->prepare('SELECT id, nombre, apellido1, apellido2, image FROM `fichas_personas`');
    $consulta->execute();
    return $consulta->fetchAll();
}
function getPersonasEnCasa($conexion)
{
    $consulta = $conexion->prepare('SELECT fichas_personas.id, registro.id as "idRegistro", r_registro_camas.id as "idRegistroCama", fichas_personas.image, fichas_personas.nombre as "name", fichas_personas.apellido1 as "surname1", fichas_personas.apellido2 as "surname2", registro.fecha_ingreso as "entry_date", registro.fecha_salida as "departure_date", habitaciones.habitacion as "room", camas.cama as "bed" FROM fichas_personas, registro, r_registro_camas, camas, habitaciones WHERE fichas_personas.id = registro.idFichaPersona AND registro.id = r_registro_camas.idRegistro AND r_registro_camas.idCama = camas.id AND camas.idHabitacion = habitaciones.id AND (registro.fecha_salida IS NULL OR registro.fecha_salida > CURDATE())');
    $consulta->execute();
    return $consulta->fetchAll();
}
function capitalize($string){
    $subString = explode(' ',$string);
    $stringResultant='';
    foreach ($subString as $key => $value) {
        if ($value != ''){
            $value=substr(strtoupper($value),0,1).substr(strtolower($value),1);
            $stringResultant = $stringResultant.$value.' '; 
        }
    } 
    return trim($stringResultant);
}