<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, token");
header("Content-Type: application/json");

require_once "Conexion.php";
require_once "functions.php";
require_once "constants.php";

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Helper\Set;

// Routes
// Grupo de rutas para el API
$app->group('/api', function () use ($app) {
    // Version group
    $app->group('/v1', function () use ($app) {
        $app->get('/obtenerFichasPersonales', 'obtenerFichasPersonales');
        $app->post('/forgotPassword', 'forgotPassword');
        $app->post('/validateToken', 'validateToken');
        $app->post('/changePassword', 'changePassword');
        $app->post('/validateLogin', 'validateLogin');
        $app->post('/agregarFichaPersonal','agregarFichaPersonal');
        $app->post('/obtenerFichasPersonalesPorFecha','obtenerFichasPersonalesPorFecha');
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

    if(!$resultadoBusqueda)
        return json_encode(false);
  
    $token = generateToken($idUsuario);

    $asunto= 'Hola '.$nombreUsuario.', vamos a resetear su contraseña';
    $body = '<p>Hola, ' .$nombreUsuario.'</p>
    <p>Hemos recibido una solicitud de un restablecimiento de contraseña de la cuenta asociada a esta dirección de 
    correo electrónico.</p>
    <p> Para confirmar y restablecer su contraseña, por favor haga click
    <a href="http://localhost:4200/change_password/'.$token.'">aquí</a> 
    o accede a la siguiente dirección: 
    <a href="http://localhost:4200/change_password/'.$token.'">http://localhost:4200/change_password/'.$token.'</a>. 
    Si no has iniciado esta solicitud, ignore este mensaje.</p>
    <p>Saludos</p>';
    
    return json_encode(sendEmail($email, $asunto, $body));
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

    //Comentar si vamos a encriptar la contraseña
    $password = $resp->password;

    //Descomentar si vamos a encriptar la contraseña
    //$password = encrypt_password($resp->password);
    
    if(!validarToken($token))
        return json_encode(["status"=>"TOKEN_EXPIRED"]);

    
    $idUsuario = getIdOfToken($token);
   
    $conexion = \Conexion::getConnection();
    $valores = [":id"=>$idUsuario, ":password"=>$password];
    $consulta = $conexion->prepare('UPDATE usuarios SET password=:password where id = :id');

    
    if($consulta->execute($valores))
        return json_encode(["status"=>"PASSWORD_CHANGED"]);
    return json_encode(["status"=>"PASSWORD_ERROR"]);

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

    //Comentar si usamos contraseña encriptada
    $valores = [":email"=>$email, ":password"=>$password];

    //Descomentar si usamos contraseña encriptada
    // $valores = [":email"=>$email];

    //Comentar si usamos contraseña encriptada
    $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email and password = :password');

    //Descomentar si usamos contraseña encriptada
    // $consulta = $conexion->prepare('SELECT * FROM usuarios where email = :email');

    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetch();

    if(!$resultadoBusqueda)
        return json_encode(false);
    
    // Descomentar si usamos contraseña encriptada
    // if(!password_verify($password,$resultadoBusqueda["password"]))
    //     return json_encode(false);

    $idUsuario = $resultadoBusqueda['id'];
    $nombreUsuario = $resultadoBusqueda['nombre'];
    $perfil = $resultadoBusqueda['perfil'];

    $token = generateTokenLogin($idUsuario, $nombreUsuario, $perfil);
    return json_encode($token);
    // return json_encode(["id"=>$idUsuario,"nombre"=>$nombreUsuario, "token"=>$token]);
}

function agregarFichaPersonal($response, $request, $next){
    
    if(!validarToken(getTokenOfHeader()))
        return json_encode(["status"=>"SESSION_EXPIRED"]);

    $resp = json_decode($response->getBody());
    $nombre = $resp->nombre;              
    $apellidos = $resp->apellidos;
    $dni = $resp->dni;
    $image = $resp->image;
    $fechaEntrada = $resp->fechaEntrada;
    $conexion = \Conexion::getConnection();

    $id_Ficha_Personal = getLastIdFichaPersonal($conexion);

    if($image==''){
        $urlImagen =  URL_IMAGE.'image/StandarProfile.png';
    }else{
        decodeBase64Image($image, $id_Ficha_Personal);
        $urlImagen = URL_IMAGE.'image/imagenPerfil'.$id_Ficha_Personal.'.'.getExtension(substr($image, 11,1));
    }
    
    $valores = [":nombre"=>$nombre, ":apellidos"=>$apellidos,":dni"=>$dni,":image"=>$urlImagen];
    $consulta = $conexion->prepare('INSERT INTO ficha_personal(id, nombre, apellidos, dni, image) 
    VALUES (NULL, :nombre, :apellidos, :dni, :image)');
    $consulta->execute($valores);

    $valoresFecha = [":fechaEntrada"=>$fechaEntrada, ":idFichaPersonal"=>$id_Ficha_Personal];
    $consulta = $conexion->prepare('INSERT INTO fecha_registro (fecha_entrada, id_ficha_personal) 
    VALUES (:fechaEntrada, :idFichaPersonal)');
    $resultado = $consulta->execute($valoresFecha);

    auditChange(
        $conexion,
        getIdOfToken(getTokenOfHeader()),
        $id_Ficha_Personal,
        "INSERT");
    
    if($resultado)
        return json_encode(["status"=>"OPERATION_SUCESS"]);
    else
        return json_encode(["status"=>"OPERATION_ERROR"]);

}

function obtenerFichasPersonales($response, $request, $next){
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM ficha_personal');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode($resultadoBusqueda);
}

function obtenerFichasPersonalesPorFecha($response, $request, $next){
    $conexion = \Conexion::getConnection();
    $resp = json_decode($response->getBody());
    $fechaEntrada = $resp->fechaEntrada;
    $valores = [":fechaEntrada"=>$fechaEntrada];
    $consulta = $conexion->prepare('SELECT * FROM ficha_personal where id IN (SELECT id_ficha_personal from fecha_registro where fecha_entrada = :fechaEntrada )');
    $consulta->execute($valores);
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode($resultadoBusqueda);
}
function obtenerFichaPersonal($response, $request, $next){
    $conexion = \Conexion::getConnection();
    $consulta = $conexion->prepare('SELECT * FROM ficha_personal');
    $consulta->execute();
    $resultadoBusqueda=$consulta->fetchAll();
    return json_encode($resultadoBusqueda);
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
