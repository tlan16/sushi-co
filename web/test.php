<?php
require 'bootstrap.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp.live.com";
$mail->SMTPAuth= true;
$mail->Port = 587; // Or 587
$mail->Username= 'ljddfoodsupply@outlook.com';
$mail->Password= '24JubileeStreet';
$mail->SMTPSecure = 'tls';
$mail->From = 'ljddfoodsupply@outlook.com';
$mail->FromName= 'SushiAndCo';
$mail->isHTML(true);
$mail->Subject = 'test';
$mail->Body = 'test';
$mail->addAddress('helin16@gmail.com');
$mail->SMTPDebug = 2;

if(!$mail->send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}else{
	echo "E-Mail has been sent";
}