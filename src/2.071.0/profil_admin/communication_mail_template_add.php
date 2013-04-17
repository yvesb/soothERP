<?php
// *************************************************************************************************************
// Ajout d'un template d'email
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$header_img_template = "";
if (!empty($_FILES['header_img_template']['tmp_name'])) {
	//copie du fichier
	if ((	substr_count($_FILES["header_img_template"]["name"], ".jpg") || substr_count($_FILES["header_img_template"]["name"], ".jpeg") || substr_count($_FILES["header_img_template"]["name"], ".gif")  )  ) {
		
		$extension = substr($_FILES["header_img_template"]["name"], strrpos($_FILES["header_img_template"]["name"], "."));
		$header_img_template = md5(uniqid(rand(), true)).$extension;
		if (is_file($MAIL_TEMPLATES_IMAGES_DIR.$header_img_template)) {$header_img_template = md5(uniqid(rand(), true)).$extension; }
		// on copie le fichier que l'on vient d'uploader dans le répertoire des images
		copy ($_FILES['header_img_template']['tmp_name'], $MAIL_TEMPLATES_IMAGES_DIR.$header_img_template); 
	} 
}

$footer_img_template = "";
if (!empty($_FILES['footer_img_template']['tmp_name'])) {
	//copie du fichier
	if ((	substr_count($_FILES["footer_img_template"]["name"], ".jpg") || substr_count($_FILES["footer_img_template"]["name"], ".jpeg") || substr_count($_FILES["footer_img_template"]["name"], ".gif")  )  ) {
		
		$extension = substr($_FILES["footer_img_template"]["name"], strrpos($_FILES["footer_img_template"]["name"], "."));
		$footer_img_template = md5(uniqid(rand(), true)).$extension;
		if (is_file($MAIL_TEMPLATES_IMAGES_DIR.$footer_img_template)) {$footer_img_template = md5(uniqid(rand(), true)).$extension; }
		// on copie le fichier que l'on vient d'uploader dans le répertoire des images
		copy ($_FILES['footer_img_template']['tmp_name'], $MAIL_TEMPLATES_IMAGES_DIR.$footer_img_template); 
	} 
}

$mail_css_template = "";
if (!empty($_FILES['mail_css_template']['tmp_name'])) {
	//copie du fichier
	if (substr_count($_FILES["mail_css_template"]["name"], ".css")) {
		
		$extension = substr($_FILES["mail_css_template"]["name"], strrpos($_FILES["mail_css_template"]["name"], "."));
		$footer_img_template = md5(uniqid(rand(), true)).$extension;
		if (is_file($MAIL_TEMPLATES_CSS_DIR.$mail_css_template)) {$mail_css_template = md5(uniqid(rand(), true)).$extension; }
		// on copie le fichier que l'on vient d'uploader dans le répertoire des images
		copy ($_FILES['mail_css_template']['tmp_name'], $MAIL_TEMPLATES_CSS_DIR.$mail_css_template); 
	} 
}




$mail_template = new mail_template ();
$infos = array();
$infos['lib_mail_template'] 		= $_REQUEST["lib_mail_template"];
$infos['header_img_template'] 	= $header_img_template;
$infos['header_mail_template'] 	= $_REQUEST["header_mail_template"];
$infos['footer_img_template'] 	= $footer_img_template;
$infos['footer_mail_template'] 	= $_REQUEST["footer_mail_template"];
$infos['mail_html_charset']			= $_REQUEST["mail_html_charset"];
$infos['mail_css_template']			= $mail_css_template;

//création de la newsletter
$mail_template->create_mail_template($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mail_template_add.inc.php");

?>