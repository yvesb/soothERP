<html>
<head>
<title>POP before SMTP Test</title>
</head>
<body>

<?php
require_once('../class.phpmailer.php');
require_once('../class.pop3.php'); // required for POP before SMTP

$pop = new POP3();
$pop->Authorise('pop3.infolys.com', 110, 30, 'chalande.benjamin', 'ed90lmei', 1);

$mail = new PHPMailer();

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPDebug = 2;
$mail->Host     = 'smtp.infolys.com';
$mail->Port       = 587;                    // set the SMTP port for the GMAIL server

$mail->SetFrom('chalande.benjamin@infolys.com', 'CHALANDE Benjamin');

$mail->AddReplyTo("chalande.benjamin@infolys.com","CHALANDE Benjamin");

$mail->Subject    = "SUJET";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML("coucou");

$address = "cb@lundimatin.fr";
$mail->AddAddress($address, "Benjamin CHALANDE");

$mail->AddAttachment("images/phpmailer.gif");      // attachment
$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>
