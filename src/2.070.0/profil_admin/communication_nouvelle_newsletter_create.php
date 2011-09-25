<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//ouverture de la class newsletter
$newsletter = new newsletter ();
$infos = array();
$infos['nom_newsletter'] 												= $_REQUEST["nom_newsletter"];
$infos['periodicite_newsletter'] 								= $_REQUEST["periodicite_newsletter"];
$infos['description_interne_newsletter'] 				= $_REQUEST["description_interne_newsletter"];
$infos['description_publique_newsletter'] 			= $_REQUEST["description_publique_newsletter"];
$infos['id_mail_template_newsletter'] 					= $_REQUEST["id_mail_template_newsletter"];
$infos['archives_publiques_newsletter'] 				= $_REQUEST["archives_publiques_newsletter"];
$infos['inscription_libre_newsletter'] 					= $_REQUEST["inscription_libre_newsletter"];
$infos['nom_expediteur_newsletter'] 						= $_REQUEST["nom_expediteur_newsletter"];
$infos['mail_expediteur_newsletter'] 						= $_REQUEST["mail_expediteur_newsletter"];
$infos['mail_retour_newsletter'] 								= $_REQUEST["mail_retour_newsletter"];
$infos['mail_inscription_titre_newsletter'] 		= $_REQUEST["mail_inscription_titre_newsletter"];
$infos['mail_inscription_corps_newsletter'] 		= $_REQUEST["mail_inscription_corps_newsletter"];

//création de la newsletter
$newsletter->create_newsletter ($infos);

$id_newsletter = $newsletter->getId_newsletter();

foreach ($_REQUEST as $key => $value) {
	if (substr ($key, 0, 7) != "profils") { continue; }
	create_newsletter_profil($id_newsletter,$value);
	
	switch ($value) {
	case $COLLAB_ID_PROFIL:
		$collab_fct = array();
		foreach ($_REQUEST as $key2 => $value2) {
			if (substr ($key2, 0, 16) != "collab_fonction_") { continue;}
			$collab_fct[] = $value2;
		}
		maj_newsletter_profil_critere($id_newsletter, $COLLAB_ID_PROFIL, implode(";", $collab_fct));
	break;
	case $CLIENT_ID_PROFIL:
		$client_categorie = array();
		$client_type = array();
		$client_categ = array();
		$client_cp = "";
		foreach ($_REQUEST as $key2 => $value2) {
			if (substr ($key2, 0, 17) == "client_categorie_") {$client_categorie[] = $value2;}
			if (substr ($key2, 0, 12) == "client_type_") {$client_type[] = $value2;}
			if (substr ($key2, 0, 13) == "client_categ_") {$client_categ[] = $value2;}
			if (substr ($key2, 0, 9) == "client_cp") {$client_cp = $value2;}
		}
		maj_newsletter_profil_critere($id_newsletter, $CLIENT_ID_PROFIL, implode(";", $client_categorie)."//".implode(";", $client_type)."//".implode(";", $client_categ)."//". $client_cp);
	break;
	case $FOURNISSEUR_ID_PROFIL:
		$fourn_cat = array();
		foreach ($_REQUEST as $key2 => $value2) {
			if (substr ($key2, 0, 10) != "fourn_cat_") { continue;}
			$fourn_cat[] = $value2;
		}
		maj_newsletter_profil_critere($id_newsletter, $FOURNISSEUR_ID_PROFIL, implode(";", $fourn_cat));
	break;
	
	
	}	
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_nouvelle_newsletter_create.inc.php");

?>