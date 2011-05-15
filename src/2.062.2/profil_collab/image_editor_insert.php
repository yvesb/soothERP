<?php
// *************************************************************************************************************
// ajout d'image dans descriptif html
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$footer_img_template = "";
$complete_url = "";
if (!empty($_FILES['fichier_img']['tmp_name'])) {
	//copie du fichier
	if ((	substr_count($_FILES["fichier_img"]["name"], ".jpg") || substr_count($_FILES["fichier_img"]["name"], ".jpeg") || substr_count($_FILES["fichier_img"]["name"], ".gif")  )  ) {
		
		$extension = substr($_FILES["fichier_img"]["name"], strrpos($_FILES["fichier_img"]["name"], "."));
		$footer_img_template = md5(uniqid(rand(), true)).$extension;
		if (is_file($_REQUEST["folder_stock"].$footer_img_template)) {$footer_img_template = md5(uniqid(rand(), true)).$extension; }
		// on copie le fichier que l'on vient d'uploader dans le répertoire des images
		copy ($_FILES['fichier_img']['tmp_name'], $_REQUEST["folder_stock"].$footer_img_template); 
		$complete_url = 'http://'. $_SERVER['HTTP_HOST'].str_replace("/profil_collab/image_editor_insert.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $_REQUEST["folder_stock"].$footer_img_template);
	} 
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_image_editor_insert.inc.php");

?>
