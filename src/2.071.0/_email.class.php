<?php
// *************************************************************************************************************
// CLASSE DE GESTION DES EMAILS 
// *************************************************************************************************************

require_once ($RESSOURCE_DIR."PHPMailer/class.phpmailer.php");

class email extends PHPMailer {
	var $mail_from_mail;
	var $mail_from_name;
	var $mail_reply_mail;
	var $mail_reply_name;

function prepare_envoi ($keep_alive = 0, $recevoir_copie = 1) {
	global $CONFIG_DIR;
	require ($CONFIG_DIR."config_mail.inc.php");

	// Paramètres de configuration. Par défaut Mail classique.
	switch ($MAIL_METHODE) {
		case "SMTP":
			$this->IsSMTP(); 
			$this->Host       = $SERVEUR_MAIL_SMTP;
			$this->SMTPAuth   = $SERVEUR_MAIL_SMTP_AUTH;
			$this->Port       = $SERVEUR_MAIL_PORT;
			$this->SMTPDebug  = $SERVEUR_MAIL_DEBUG;
			$this->Username   = $SERVEUR_MAIL_USER;
			$this->Password   = $SERVEUR_MAIL_PASS;
			break;
		case "SENDMAIL":
			$mail->IsSendmail();
			break; 
		case "MAIL": default:
			break;
	}
	
	if ($MAIL_FROM_MAIL) {
		$this->SetFrom($MAIL_FROM_MAIL, $MAIL_FROM_NAME);
	}
	if ($MAIL_REPLY_MAIL) {
		$this->AddReplyTo($MAIL_REPLY_MAIL, $MAIL_REPLY_NAME);
	}
	if ($MAIL_COPY_MAIL && $recevoir_copie) {
		$this->AddBCC ($MAIL_COPY_MAIL, $MAIL_COPY_NAME);
	}
	
	if ($keep_alive) { $this->SMTPKeepAlive = true; }

	return true;
}

function envoi ($destinataires, $sujet, $message, $infos = array(), $pieces = array()) {
	// Paramètres pour INFOS[]
	// $infos['mail_from_mail']  			
	// $infos['mail_from_name']
	// $infos['mail_reply_mail']
	// $infos['mail_reply_name']
	// $infos['no_copy']						> Interdit l'envoi d'une copie par email
	// $infos['from_user']					> Si défini, le mail est envoyé depuis l'email de l'utilisateur actuellement loggué

	// Contenu du mail
	$this->Subject  = $sujet;

	// Modification éffectuée par Yves Bourvon le 03/06/2011
	// Remplacement de 'eregi_replace'(obsolète sous php 5.3) par 'preg_replace'

	$body           = preg_replace('/\\\\/','', $message);
	$this->MsgHTML($body);

	// Définition de l'expéditeur
	$tmp_from_mail = $tmp_from_name = $tmp_reply_mail = $tmp_reply_name = "";
	if (isset($infos['from_user'])) {
		$tmp_from_mail = $tmp_reply_mail = $_SESSION['user']->getEmail();
		$tmp_from_name = $tmp_reply_name = $_SESSION['user']->getContactName();
	} else {
		if (isset($infos['mail_from_mail'])) {
			$tmp_from_mail = $infos['mail_from_mail'];
			if (!isset($infos['mail_from_name'])) {
				$tmp_from_name = $infos['mail_from_mail'];
			}else{
				$tmp_from_name = $infos['mail_from_name'];
			}
			if (!isset($infos['mail_reply_mail'])) {
				$tmp_reply_mail = $infos['mail_from_mail'];
			}else{
				$tmp_reply_mail = $infos['mail_reply_mail'];
			}
			if (!isset($infos['mail_reply_name'])) {
				$tmp_reply_name = $infos['mail_from_mail'];
			}else{
				$tmp_reply_name = $infos['mail_reply_name'];
			}
		}
	}
	if ($tmp_from_mail) 	{ $this->SetFrom($tmp_from_mail, $tmp_from_name); 		 }
	if ($tmp_reply_mail) 	{ $this->AddReplyTo($tmp_reply_mail, $tmp_reply_name); }

	// Définition de l'expéditeur
	if (is_array($destinataires)) {
		for ($i=0; $i<count($destinataires); $i++) {
			$this->AddAddress($destinataires[$i], $destinataires[$i]);
		}
	} else {
		$this->AddAddress($destinataires, $destinataires);
	}

	// Pièces jointes
	foreach ($pieces as $piece) {
		$piece->type = NULL;
		if (substr($piece->nom_fichier, -4) == ".pdf" && !isset($piece->type)) { $piece->type = "application/pdf"; }
		if (!isset($piece->encoding)) 	{ $piece->encoding = "base64"; }
		if (!isset($piece->nom_public)) { $piece->nom_public = $piece->nom_fichier; }

		$this->AddAttachment($piece->nom_fichier, $piece->nom_public, $piece->encoding, $piece->type);
	}

	// Envoi du mail
	$resultat = $this->Send();
	
	// Suppression des Adresses et pièces jointes pour le prochain envoi, le cas échéant
	$this->ClearAddresses();
	$this->ClearAttachments();

  return $resultat;
}




function mail_attachement ($to , $sujet , $message , $filename , $typemime , $nom , $reply , $from, $nom_aff) {
	// $filename et $nom_aff sont des tableaux qui contiennent chemin + nom de X pièces jointes :
	$destinataires = $to;
	// sujet OK
	// message OK
	// Type mime OK normalement..
	$infos['mail_from_mail'] = $from;
	$infos['mail_from_nom'] = $nom;
	$infos['mail_reply_mail'] = $reply;
	for ($i=0; $i<count($filename); $i++) {
		$pieces[$i] = new stdClass();
		$pieces[$i]->nom_fichier = $filename[$i];
		$pieces[$i]->nom_public = $nom_aff[$i];
	}

	return $this->envoi($destinataires , $sujet , $message , $infos, $pieces);
}


// Fonction d'envoi des mails avec template
function envoi_email_templated ($to, $sujet, $message) {
	global $ID_MAIL_TEMPLATE;
	global $MAIL_TEMPLATES_CSS_DIR;
	global $MAIL_TEMPLATES_IMAGES_DIR;
	
	$url_site = url_site();
			
	$mail_template = new mail_template ($ID_MAIL_TEMPLATE);

	$entete = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='.$mail_template->getMail_html_charset().'" />
	<title>'.$sujet.'</title>
	';
	$entete .= '<link href="' . $url_site . str_replace("../", "",$MAIL_TEMPLATES_CSS_DIR).'defaut_css.css" rel="stylesheet" type="text/css" />';
	
	if ($mail_template->getMail_css_template()) { 
		$entete .= '<link href="' . $url_site . str_replace("../", "", $MAIL_TEMPLATES_CSS_DIR.$mail_template->getMail_css_template()).'" rel="stylesheet" type="text/css" />';
	}
	$entete .= '
	</head>
	<body>
	<div class="content"';
	
	if ($mail_template->getHeader_img_template()) {
		list($width, $height, $type, $attr) = getimagesize($MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getHeader_img_template());
		if ($width > 800) {
			$entete .= 'style="width:'.$width.'px"';
		}
	}
	$entete .= '>';
	if ($mail_template->getHeader_img_template()) { 
		$entete .= '<img src="' . $url_site . str_replace("../", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getHeader_img_template()).'" style="border:0px"/><br />';
	} 
	$entete .= '<div >' . $mail_template->getHeader_mail_template() . '<br />';
	$pied = '<br />'.$mail_template->getFooter_mail_template().'<br /></div>';
	if ($mail_template->getFooter_img_template()) { 
		$pied .= '<br /><img src="' . $url_site . str_replace("../", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getFooter_img_template()).'" style="border:0px"/>';
	}
	$pied .= '</div>';
	$pied .= '
	</div>
	</body>
	</html>';
	
	// Envoi de l'email
	$mail = $entete.$message.$pied;
	return $this->envoi($to, $sujet, $mail);
}

//***********************************************************************
// FONCTIONS DIVERSES
//***********************************************************************

/**
* Verifie que l'adresse email à bien une syntaxe valide
* @param string $email exemple contact@domain.ltd
* @return boolean retourne true si la syntaxe est correct, false sinon.
*/
public static function verifier_syntaxe_email($email){
return (preg_match("#^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$#i", $email))? true : false;
}

/**
* Verifie si une liste d'email est syntaxiquement correct
* @param string[] $emails un tableau d'emails
* @return boolean retourne true si tous les emails sont synthaxiquement correct, false sinon.
*/
public static function verifier_syntaxe_emails($emails){
foreach($emails as $email){
if(!email::verifier_syntaxe_email($email)){ return false; }
}
return true;
}


}