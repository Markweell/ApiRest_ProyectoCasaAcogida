<?php
    /**
     * Recoge un email de una peticion post, se comprueba que este está en la base de datos y si lo está se le genera
     * un token y se le envia un correo con ese token.
     */
    function forgotPassword($response, $request, $next) {
        $conexion = \Conexion::getConnection();
        $valores = obtieneValores($response);
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
    function obtieneValores($response){
        $variable = json_decode($response->getBody());
        $email = $variable->email;
        return [':email'=>$email];
    }

    /**
     * Envia un email con asunto y una descripción
     * @param string email: email al que se va a enviar el correo,
     * @param string remitente: nombre de la persona que va a recibir el correo,0
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
?>