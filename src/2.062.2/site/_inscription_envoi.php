<?php
// *************************************************************************************************************
// INSCRIPTION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_interface.config.php");
$_INTERFACE['MUST_BE_LOGIN'] = 0;
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");

//$interface = new interfaces ($ID_INTERFACE);

gestion_panier();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

//inscription à la newsletter
if(isset($_REQUEST['user_newsletter'])){
	if($_REQUEST["lib_coordonnees"]!=""){$nom_news = $_REQUEST["lib_coordonnees"];}
	else{$nom_news = $_REQUEST["nom"];}
	
	$newsletters = charger_newsletters();
	
	// Enregistrement de l'inscription
	foreach($newsletters as $newsletter){
		$ajout_inscrit = new newsletter($newsletter->id_newsletter);
		$ajout_inscrit->add_newsletter_inscrit($_REQUEST["admin_emaila"], $nom_news, '1');
	}
}

$liste_reponse = array();
$email = "";
foreach ($_REQUEST as $key=>$value) {
	if($key != "user_societe" || $key != "user_nom" || $key != "user_prenom"){
		$liste_reponse[$key] = $value;
		if ($key == "admin_emaila") { $email = $value;}
	}
}

if (count($liste_reponse) && $email) {
	$message_mail = $_SESSION['interfaces'][$_INTERFACE['ID_INTERFACE']]->inscription_valide_panier($liste_reponse, $email);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."catalogue_panier_validation_step1.php");

//echo "INSCRIPTION_ALLOWED = " . $INSCRIPTION_ALLOWED . "<br />";
//echo "validation = " . $validation;
if ($INSCRIPTION_ALLOWED == 1 && $validation  ) {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_inscription_valide.inc.php");
} else {
	//header ("Location: _user_infos.php");
	header ("Location: catalogue_panier_validation_step1.php");
}

?>