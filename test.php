<?php

$email_from = 'contacto@sytcom.com.pe';
    $email_to = 'ventas@sytco.com.pe';

    $mail = new PHPMailer();
    $mail->Host = "localhost";
    $mail->From = $email_from;
    $mail->FromName = $nombres;
    $mail->Subject = $asunto;
    $mail->AddAddress($email_to);
    $mail->AddBCC("creativosdelnorte@gmail.com");
    $mail->AddBCC("luchopintado@gmail.com");
    $mail->AddReplyTo($email, $nombres);
    $mail->Body = $html;
    $mail->IsHTML(true);
    $mail->SMTPDebug = true;
    $mail->SetLanguage("es", 'clases/phpmailer/');
    $envio = $mail->Send();
