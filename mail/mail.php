<?php
/*
 * @author Balaji
 */
error_reporting(1);

function default_mail ($admin_mail,$admin_name,$sent_mail,$subject,$body)
{
// Functions
require_once('class.phpmailer.php');   

$mail  = new PHPMailer(); 

$body  = eregi_replace("[\]",'',$body);

$mail->AddReplyTo($admin_mail,$admin_name);

$mail->SetFrom($admin_mail, $admin_name);

$mail->AddReplyTo($admin_mail,$admin_name);

$address = $sent_mail;

$mail->AddAddress($address);

$mail->Subject    = $subject;

$mail->MsgHTML($body);

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

if(!$mail->Send()) {
  $msg =  "Mailer Error: " . $mail->ErrorInfo;
} else {
  $msg = "Message sent!";
}
return $msg;

}

function smtp_mail ($smtp_host,$smtp_port=587,$smtp_auth,$smtp_user,$smtp_pass,$smtp_sec='tls',$admin_mail,$admin_name,$sent_mail,$subject,$body)
{
require_once('class.phpmailer.php'); 
require_once('class.smtp.php');  
$mail = new PHPMailer;
$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = $smtp_host;                 // Specify main and backup server
$mail->Port = $smtp_port;                                    // Set the SMTP port
$mail->SMTPAuth = $smtp_auth;                               // Enable SMTP authentication
$mail->Username = $smtp_user;                // SMTP username
$mail->Password = $smtp_pass;                  // SMTP password
$mail->SMTPSecure = $smtp_sec;                            // Enable encryption, 'ssl' also accepted

$mail->From = $admin_mail;
$mail->FromName = $admin_name;
$mail->AddAddress($sent_mail);  // Add a recipient

$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $body;
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";

if(!$mail->Send()) {
   $msg = 'Mailer Error: ' . $mail->ErrorInfo;
}
else
{
  $msg =  'Message has been sent';  
}
return $msg;
}
?>