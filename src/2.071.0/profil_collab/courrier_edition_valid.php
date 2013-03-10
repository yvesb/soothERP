<?php
// *************************************************************************************************************
// enregistrement du broullon de la newsletter
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_courrier"])&&$_REQUEST["id_courrier"]!=""){ //le courrier existe déjà
	$courrier = new courrierEtendu($_REQUEST["id_courrier"]);
	$courrier->setContenu($_REQUEST["contenu_courrier"]);
	$courrier->setObjet($_REQUEST["objet_courrier"]);
}else{
	echo  "<br/>ref_destinataire - ".$_REQUEST["ref_destinataire"];
	echo  "<br/>objet_courrier - ".$_REQUEST["objet_courrier"];
	echo  "<br/>contenu_courrier - ".$_REQUEST["contenu_courrier"];
	
	//$courrier = new courrierEtendu($_REQUEST["ref_destinataire"], $_REQUEST["objet_courrier"], $_REQUEST["contenu_courrier"]);	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_courrier_edition_valid.inc.php");

?>