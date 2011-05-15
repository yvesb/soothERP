<?php
// *************************************************************************************************************
// Lecture d'un email d'une newsletter
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 0;

require ("__dir.inc.php");
require ($DIR."_session.inc.php");
require ($DIR."config/newsletter.config.php");

?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Désinscription à la newsletter</title>
	<style>
	body {font: 12px Arial, Helvetica, sans-serif;
	color:#000000;
	padding:25px;
	}
	</style>
	</head>
	
	<body>
<?php 
if (isset($_REQUEST["id_newsletter"]) && isset($_REQUEST["email"]) && isset($_REQUEST["code"]) && isset($_REQUEST["valide"]) && $_REQUEST["valide"] == "1" ) {
	if (verifier_code_unique ($_REQUEST["code"], $_REQUEST["email"], $_REQUEST["id_newsletter"])) {
		$newsletter = new newsletter($_REQUEST["id_newsletter"]);
		$newsletter->maj_newsletter_inscrit ($_REQUEST["email"], 0);
		?>
		Votre désinscription à la newsletter <?php echo $newsletter->getNom_newsletter();?> a bien été prise en compte.
		<?php 
	} else {
		if (isset($_REQUEST["id_newsletter"])) {
			$newsletter = new newsletter($_REQUEST["id_newsletter"]);
			?>
			Votre désinscription à la newsletter <?php echo $newsletter->getNom_newsletter();?> a déjà été prise en compte.
			<?php 
		}
	}
} elseif (isset($_REQUEST["id_newsletter"]) && isset($_REQUEST["email"]) && isset($_REQUEST["code"]) && (!isset($_REQUEST["valide"]) )){
		$newsletter = new newsletter($_REQUEST["id_newsletter"]);
		
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	?>
	<p style="font-weight:bolder">Vous souhaitez encore recevoir des informations concernant <?php echo $nom_entreprise;?> ?</p>
	<div style="border:1px solid #666666; width:450px; padding:5px">
	<form action="desinscription.php" method="post" enctype="application/x-www-form-urlencoded">
	<input type="radio" value="0" name="valide" checked="checked"/> Oui, je souhaite recevoir ces informations<br />

	<input type="radio" value="1" name="valide"/> Non, je me désabonne de la newsletter<br />
	<input type="hidden" name="id_newsletter" value="<?php echo $_REQUEST["id_newsletter"]?>" />
	<input type="hidden" name="email" value="<?php echo $_REQUEST["email"]?>" />
	<input type="hidden" name="code" value="<?php echo $_REQUEST["code"]?>" />
	<div style="text-align:right">
	<input type="submit" name="confirm" value="Confirmer" />
	</div>
	</form>
	</div>
	<br />
	Votre désinscription concerne uniquement les emails liés à la newsletter 
	"<?php echo $newsletter->getNom_newsletter();?>".<br />

	Il est possible que vous continuiez à recevoir les informations de <?php echo $nom_entreprise;?>.<br />

	Pour vous désinscrire des newsletters, il vous suffit de cliquer au bas des emails que vous recevez.
	<?php
} elseif ( isset($_REQUEST["valide"]) && $_REQUEST["valide"] == "0" ){
	?>
	Merci.
	<?php	
} else {
	?>
	Merci.
	<?php	
}
?>
	</body>
	</html>
