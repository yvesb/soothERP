<?php
// *************************************************************************************************************
// ACCUEIL COMPTA automatique des catégories d'articles (HT) VENTE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

//chargement de la liste des art_categ et des informations de plan comptable associées
$fiches = array();
$fiches_tmp = array();
$query = "SELECT ref_art_categ, lib_art_categ, modele, desc_art_categ, defaut_id_tva, duree_dispo, 
									defaut_numero_compte_vente, defaut_numero_compte_achat, ref_art_categ_parent,
									pc.lib_compte as defaut_lib_compte_achat,
									pc2.lib_compte as defaut_lib_compte_vente
									
					FROM art_categs ac
						LEFT JOIN plan_comptable pc ON pc.numero_compte = defaut_numero_compte_achat
						LEFT JOIN plan_comptable pc2 ON pc2.numero_compte = defaut_numero_compte_vente
						ORDER BY lib_art_categ ASC 
					";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {
	$fiches_tmp[] = $fiche; 
}
$fiches = order_by_parent ($fiches, $fiches_tmp, "ref_art_categ", "ref_art_categ_parent", "","");
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_automatique_art_categ_vente.inc.php");

?>