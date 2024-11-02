<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('../PHPMailer/Exception.php');
require('../PHPMailer/PHPMailer.php');
require('../PHPMailer/SMTP.php');
//require('../PHPMailer/PHPMailerAutoload.php');

$mail = new PHPMailer(true);

// 1 = Erros e mensagens
// 2 = Apenas mensagens
//$mail->SMTPDebug  = 1; 

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rclothesmail@gmail.com';
    $mail->Password   = 'latwriebgpffqkjl'; //vagsendmail10:141407b+$%*78
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
	$mail->CharSet = 'UTF-8';

    $mail->setFrom('rclothesmail@gmail.com');
    $mail->addAddress('rclothesmail@gmail.com');
    
} catch (Exception $e) {
    echo "Erro no PHPMailer: {$mail->ErrorInfo}";
}