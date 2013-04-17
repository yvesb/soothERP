<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
$id_modele	=	$art_categ->getModele ();
$old_art_categ = new art_categ ($_REQUEST['old_ref_art_categ']);
$old_id_modele	=	$old_art_categ->getModele ();

if ($old_id_modele != $id_modele) {
//affichage d'une réponse pour traitement par javascript et appel du nouveau model
echo "new";
}
?>