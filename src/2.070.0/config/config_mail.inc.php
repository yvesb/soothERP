<?php
// *************************************************************************************************************
// CONFIGURATION DE L'ENVOI DES EMAILS PAR DEFAUT
// *************************************************************************************************************

$MAIL_METHODE	 		 			= "MAIL";  // SMTP, MAIL OU SENDMAIL
$SERVEUR_MAIL_SMTP_AUTH = false;	 // Authoriser 
$MAIL_ALERTE_STOCK	= array();
$SERVEUR_MAIL_DEBUG 		= 0;			 // 2 = Debug	

$SERVEUR_MAIL_SMTP = ""; // smtp.mondomaine.com
$SERVEUR_MAIL_PORT = 25; // 25 par défaut
$SERVEUR_MAIL_USER = "";
$SERVEUR_MAIL_PASS = "";

$MAIL_FROM_MAIL 	 = "";
$MAIL_FROM_NAME 	 = "";

$MAIL_REPLY_MAIL	 = "";
$MAIL_REPLY_NAME 	 = "";

$MAIL_COPY_MAIL		 = "";		// Email recevant une copie de tout email envoyé;
$MAIL_COPY_NAME 	 = "";	

?>