<?php
// *************************************************************************************************************
// Inscription d'un email à une newsletter
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 0;

require ("__dir.inc.php");

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
require ($DIR."_session.inc.php");
require ($DIR."config/newsletter.config.php");

$liste_newletters = charger_newsletters ();

if (!isset($_REQUEST["id_newsletter"])) {
	$current_newsletter = 0;
	foreach ($liste_newletters as $newsletter) {
	 if ($newsletter->inscription_libre) {$current_newsletter = $newsletter->id_newsletter; break;}
	}
} else {
	$current_newsletter = $_REQUEST["id_newsletter"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inscription à la newsletter</title>
<style>
body {font: 12px Arial, Helvetica, sans-serif;
color:#000000;
padding:25px;
}
</style>
</head>
<body>
<?php 
if (isset($_REQUEST["email"]) && $_REQUEST["email"] && email::verifier_syntaxe_email($_REQUEST["email"]) && 
		isset($_REQUEST["code"])) {
	$newsletter = new newsletter($current_newsletter);
	// Si l'inscription a bien été validée
	if ($newsletter->maj_newsletter_newsletters_inscriptions ($_REQUEST["email"], $_REQUEST["code"])) {
		?>
		Votre inscription à la newsletter <?php echo $newsletter->getNom_newsletter();?> a bien été prise en compte.
		<?php 
	} else {
		if(isset($GLOBALS['_INFOS']['validation_inscription_newsletter']) && $GLOBALS['_INFOS']['validation_inscription_newsletter'] == -1){
			?>
			Le code de confirmation est incorrect. Votre inscription ne peut pas être validée pour la newsletter : <?php echo $newsletter->getNom_newsletter();?>. 
			<?php
		}elseif(isset($GLOBALS['_INFOS']['validation_inscription_newsletter']) && $GLOBALS['_INFOS']['validation_inscription_newsletter'] == -2){
			?>
			Vous avez déjà validé votre inscription pour la newsletter <?php echo $newsletter->getNom_newsletter();?>. 
			<?php	
		}else{
			?>
			Votre adresse n'a pas été enregistrée pour l'abonnement à la newsletter <?php echo $newsletter->getNom_newsletter();?>. 
			<?php
		}
	}
} elseif ($current_newsletter && isset($_REQUEST["email"]) && 
				$_REQUEST["email"] && email::verifier_syntaxe_email($_REQUEST["email"]) && 
				(!isset($_REQUEST["code"]) )) {
	$newsletter = new newsletter($current_newsletter);
	// Préinscription
	if ($url_inscription = $newsletter->add_newsletter_newsletters_inscriptions ($_REQUEST["email"])) {
		$texte = "<br />Merci de cliquez sur le lien suivant pour confirmer votre inscription : <br />";
		$lien	= "<a href='http://".$_SERVER['HTTP_HOST'].str_replace("site/newsletters/inscription.php", "", $_SERVER['PHP_SELF']).
							$url_inscription."' target='_blank'> http://".
							$_SERVER['HTTP_HOST'].str_replace("site/newsletters/inscription.php", "", $_SERVER['PHP_SELF']).$url_inscription."</a>";
		
		// Entête du mail
		$limite = "_parties_".md5(uniqid(rand()));
		$mail_mime = "Date: ".date("r")."\n";
		$mail_mime .= "MIME-Version: 1.0\n";
		$mail_mime .= "Content-Type: multipart/mixed;\n";
		$mail_mime .= " boundary=\"----=$limite\"\n\n";
		
		restore_error_handler();
		error_reporting(0);
		// Envoi de l'email
		$mail = new email();
		$mail->prepare_envoi(0, 0);
		if (!$mail->envoi($_REQUEST["email"] , $newsletter->getMail_inscription_titre() , $newsletter->getMail_inscription_corps()."<br />".$texte.$lien."<br />" , 
				"Reply-to: ".$newsletter->getMail_retour()."\nFrom:".$newsletter->getNom_expediteur()." <".$newsletter->getMail_expediteur().">"."\n".$mail_mime)) {
			echo "Une erreur est survenue lors de l'envoi à ".$_REQUEST["email"]."<br />"; exit;
		}
		set_error_handler("error_handler");
		
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
		?>
		<p style="font-weight:bolder">Un email de confirmation d'inscription vient de vous être envoyé.</p>
		<br /><br />
		<p style="font-weight:bolder">Afin de valider définitivement votre inscription, cliquez sur le lien présent en bas de l'email de confirmation afin recevoir des informations concernant <?php echo $nom_entreprise;?>.</p>
		<br />
		Votre inscription concerne uniquement les emails liés à la newsletter "<?php echo $newsletter->getNom_newsletter();?>".<br />
	
		Pour vous désinscrire des newsletters, il vous suffit de cliquer au bas des emails que vous recevrez.
		<?php 
	} else {
		?>
		<p style="font-weight:bolder">Cet email (<?php echo $_REQUEST["email"];?>) est déjà inscrit pour cette newsletter (<?php echo $newsletter->getNom_newsletter();?>).</p>
		<?php 
	}
} elseif (isset($_REQUEST["email"]) && $_REQUEST["email"] && !email::verifier_syntaxe_email($_REQUEST["email"])){
	?>
	Votre adresse email semble invalide.
	<?php
}else {
	?>
	La gestion des newsletters est désactivée sur ce site, veuillez contacter l'administrateur du site.
	<?php
}


?>
</body>
</html>
