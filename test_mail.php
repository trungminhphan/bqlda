<?php
require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;

try{
  $mail->SMTPDebug = 2;                                 // Enable verbose debug output
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = 'trungminhphan@gmail.com';                 // SMTP username
  $mail->Password = 'esqrfmrotkxvgzyn';                           // SMTP password
  $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 465;
  $mail->CharSet = 'UTF-8';
  $mail->setFrom('trungminhphan@gmail.com', 'Phan Minh Trung');
  $mail->addAddress('pmtrung@agu.edu.vn', 'Phan Minh Trung');     // Add a recipient

  $mail->isHTML(true);                                  // Set email format to HTML
  $mail->Subject = 'Hello world, Test email';
  $mail->Body    = 'Hello world, Test email';
  $mail->AltBody = 'Hello world, Test email';

  $mail->send();
  echo 'Message has been sent';
} catch(Exception $e){
  echo 'Message could not be sent.';
  echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>
