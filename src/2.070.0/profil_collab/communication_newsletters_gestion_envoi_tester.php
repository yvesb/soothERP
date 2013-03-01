<?php
// *************************************************************************************************************
// test de la newsletter
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("14")) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}

if (!isset($_REQUEST["id_newsletter_tester"])) {exit;}

$newsletter = new newsletter ($_REQUEST["id_newsletter_tester"]);
$mail_template = new mail_template ($newsletter->getId_mail_template());
$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));

$entete = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='.$mail_template->getMail_html_charset().'" />
<title>'.$_REQUEST["titre_tester"].'</title>

<link href="http://'. $_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_tester.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_CSS_DIR).'defaut_css.css" rel="stylesheet" type="text/css" />
';

if ($mail_template->getMail_css_template()) { 
	$entete .= '<link href="http://'. $_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_tester.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_CSS_DIR.$mail_template->getMail_css_template()).'" rel="stylesheet" type="text/css" />';
}
$entete .= '
</head>
<body>
<div class="content"';

if ($mail_template->getHeader_img_template()) {
	list($width, $height, $type, $attr) = getimagesize($MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getHeader_img_template()); if ($width > 800) {
		$entete .= 'style="width:'.$width.'px"';
	}
}
$entete .= '>';

if ($mail_template->getHeader_img_template()) { 
	$entete .= '<img src="http://'. $_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_tester.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getHeader_img_template()).'" style="border:0px"/><br />';
} 

$entete .= '<div >'. $mail_template->getHeader_mail_template().'<br />';


$contenu = ($_REQUEST["description_tester"]);

$pied = '<br />'.$mail_template->getFooter_mail_template().'<br /></div>';

if ($mail_template->getFooter_img_template()) { 
	$pied .= '<br /><img src="http://'.$_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_tester.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getFooter_img_template()).'" style="border:0px"/>';
}
$pied .= '</div>';

$pied .= '<div  class="down_page">
Vous recevez ce courriel parce que vous êtes inscrit à la newsletter de <a href="http://'.$_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_tester.php", "", $_SERVER['PHP_SELF']).'" style="color:#999999;"><?php echo $nom_entreprise;?></a>. <br />
Conformément à notre engagement, vous pouvez vous désinscrire en suivant le lien suivant: <a href="**liendesinscription**"  style="color:#999999;">désinscription</a><br />
<img src="**liendelecture**" width="0px" height="0px" style="display:none"/>
';

$pied .= '
</div>
</body>
</html>';
//entete du mail
	
	$limite = "_parties_".md5(uniqid(rand()));
	$mail_mime = "Date: ".date("r")."\n";
	$mail_mime .= "MIME-Version: 1.0\n";
	$mail_mime .= "Content-Type: multipart/mixed;\n";
	$mail_mime .= " boundary=\"----=$limite\"\n\n";
	
	$texte = "------=".$limite."\n";
	$texte .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$texte .= "Content-Transfer-Encoding: 8bit\n\n";
	
	restore_error_handler();
	error_reporting(0);
	//envoi de l'email
	$destinataires = $_SESSION['user']->getEmail ();
	$sujet = $_REQUEST["titre_tester"];
	$message = $entete.$contenu.$pied."\n\n";
	$infos['mail_from_mail'] = $newsletter->getMail_expediteur();
	$infos['mail_from_name'] = $newsletter->getNom_expediteur();
	$infos['mail_reply_mail'] = $newsletter->getMail_retour();
	$infos['mail_reply_name'] = $newsletter->getNom_expediteur();
	
	$mail = new email();
	$mail->prepare_envoi(0, 0);
	if (!$mail->envoi($destinataires , $sujet , $message , $infos)) {
		$erreur = "Une erreur est survenue lors de l'envoi à ".$_SESSION['user']->getEmail ()."<br />";
	}
	
	set_error_handler("error_handler");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_envoi_tester.inc.php");

?>