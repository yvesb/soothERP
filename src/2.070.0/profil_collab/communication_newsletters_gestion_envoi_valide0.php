<?php
// *************************************************************************************************************
// PREVIEW DE MODELE DE MAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("14")) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}

if (!isset($_REQUEST["id_newsletter"])) {exit;}

$newsletter = new newsletter ($_REQUEST["id_newsletter"]);
$mail_template = new mail_template ($newsletter->getId_mail_template());
$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));

$entete = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='.$mail_template->getMail_html_charset().'" />
<title>'.$_REQUEST["titre_newsletter"].'</title>

<link href="http://'. $_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_valide0.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_CSS_DIR).'defaut_css.css" rel="stylesheet" type="text/css" />
';

if ($mail_template->getMail_css_template()) { 
	$entete .= '<link href="http://'. $_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_valide0.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_CSS_DIR.$mail_template->getMail_css_template()).'" rel="stylesheet" type="text/css" />';
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
	$entete .= '<img src="http://'. $_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_valide0.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getHeader_img_template()).'" style="border:0px"/><br />';
} 

$entete .= '<div >'. $mail_template->getHeader_mail_template().'<br />';


$contenu = ($_REQUEST["description"]);

$pied = '<br />'.$mail_template->getFooter_mail_template().'<br /></div>';

if ($mail_template->getFooter_img_template()) { 
	$pied .= '<br /><img src="http://'.$_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_valide0.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getFooter_img_template()).'" style="border:0px"/>';
}
$pied .= '</div>';

$pied .= '<div  class="down_page">
Vous recevez ce courriel parce que vous êtes inscrit à la newsletter de <a href="http://'.$_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_valide0.php", "", $_SERVER['PHP_SELF']).'" style="color:#999999;"><?php echo $nom_entreprise;?></a>. <br />
Conformément à notre engagement, vous pouvez vous désinscrire en suivant le lien suivant: <a href="**liendesinscription**"  style="color:#999999;">désinscription</a><br />
<img src="**liendelecture**" width="0px" height="0px" style="display:none"/>
';

$pied .= '
</div>
</body>
</html>';


$id_envoi = $newsletter->add_newsletter_envoi ($contenu, $entete, $pied, $_REQUEST["titre_newsletter"]);

$liste_abonnes = charger_total_abonnes ($newsletter->getId_newsletter());

foreach ($liste_abonnes as $abonne) {
	$newsletter->add_newsletter_envoi_destinataire ($id_envoi, $abonne->nom, $abonne->email);
}

if (!file_exists($DIR."config/newsletter.config.php")) {
	//vérification de l'existence du code sécurité de l'envoi de newsletter
	if (!$file_config_newsletter = @fopen ($DIR."config/newsletter.config.php", "w")) {
		$erreur = "Impossible de créer le fichier de configuration config/newsletter.config.php "; 
	} else {
		$file_content = "<?php
		// *************************************************************************************************************
		// CODE DE SECURITE DE L'ENVOI DE NEWSLETTERS
		// *************************************************************************************************************
		
		\$CODE_SECU_NEWSLETTER = \"".rand(1000, 9999)."\"; 
		
		?>";
		
		if (!fwrite ($file_config_newsletter, $file_content)) {
			$erreur = "Impossible d'écrire dans le fichier de configuration config/newsletter.config.php"; 
		}
	}
	fclose ($file_config_newsletter);
	
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_envoi_valide0.inc.php");

?>