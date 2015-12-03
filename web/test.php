<?php
require 'bootstrap.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp-mail.outlook.com";
$mail->SMTPAuth= true;
$mail->Port = 587; // Or 587
$mail->Username= 'ljddfoodsupply@outlook.com';
$mail->Password= '24JubileeStreet';
$mail->SMTPSecure = 'TLS';
$mail->From = $mail->Username;
//$mail->FromName= 'SushiAndCo';
$mail->isHTML(true);
$mail->Subject = 'a message from ' . $mail->Username;
$mail->Body = $mail->Subject;
$mail->addAddress('helin16@gmail.com');
$mail->SMTPDebug = 1;

if(!$mail->send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}else{
	echo "E-Mail has been sent";
}