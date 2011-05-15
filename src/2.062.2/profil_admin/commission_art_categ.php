<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if ($COMMERCIAL_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($COMMERCIAL_ID_PROFIL);
	$liste_commissions_regles = contact_commercial::charger_commissions_regles ();
}

//chargement de la liste des art_categ et des informations de commissionnement
$fiches = array();
$fiches_tmp = array();
$query = "SELECT ac.ref_art_categ, lib_art_categ, modele, desc_art_categ, defaut_id_tva, duree_dispo, ref_art_categ_parent
									
					FROM art_categs ac
					ORDER BY lib_art_categ ASC 
					";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {
	$query_tmp = "SELECT cac.formule_comm, cac.id_commission_regle, cac.ref_art_categ
								FROM commissions_art_categ cac 
								WHERE cac.ref_art_categ = '".$fiche->ref_art_categ."'
							";
	$resultat_tmp = $bdd->query($query_tmp);
	$fiche->id_commission_regle = array();
	while ($regle_tmp = $resultat_tmp->fetchObject()) {
		$fiche->id_commission_regle[$regle_tmp->id_commission_regle] = $regle_tmp;
	} 
		unset ($resultat_tmp, $query_tmp, $regle_tmp);
	$fiches_tmp[] = $fiche; 
}
$fiches = order_by_parent ($fiches, $fiches_tmp, "ref_art_categ", "ref_art_categ_parent", "","");
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_art_categ.inc.php");

?>