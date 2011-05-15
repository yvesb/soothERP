<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$newsletter = new newsletter ($_REQUEST["id_newsletter"]);

$liste_abonnes = charger_total_abonnes ($newsletter->getId_newsletter());

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************


$content_type = "application/csv";

	header('Pragma: public'); 
	header('Expires: 0'); 
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0'); 
	header('Content-Type: application/force-download'); 
	header('Content-Type: application/octet-stream'); 
	header('Content-Type: application/download'); 
	header('Content-Type: '.$content_type.'; name="inscrits_newsletter_'.$newsletter->getId_newsletter().'.csv"');
	header('Content-Disposition: attachment; filename=inscrits_newsletter_'.$newsletter->getId_newsletter().'.csv;'); 


	echo "email;nom\n";
foreach ($liste_abonnes as $inscrits) {
	echo $inscrits->email.";". $inscrits->nom." \n";
}
die(); 


?>