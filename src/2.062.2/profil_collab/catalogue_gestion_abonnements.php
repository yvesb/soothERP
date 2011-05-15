<?php
// *************************************************************************************************************
// GESTION des abonnements
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	global $bdd;

	$liste_abonnements = array();
	$query = "	SELECT a.ref_article, a.lib_article, ac.lib_art_categ, a.ref_art_categ, (
					SELECT COUNT( aa1.ref_contact )
					FROM articles_abonnes aa1
					WHERE aa1.ref_article = a.ref_article && aa1.date_echeance >= NOW( )
					) AS nb_abo_en_cours, (
					SELECT COUNT( aa2.ref_contact )
					FROM articles_abonnes aa2
					WHERE aa2.ref_article = a.ref_article && aa2.date_echeance < NOW( ) && aa2.fin_abonnement > NOW( )
					) AS nb_abo_a_renouv
					FROM articles a
					LEFT JOIN art_categs ac ON ac.ref_art_categ = a.ref_art_categ
					WHERE a.modele = 'service_abo'
					ORDER BY ac.lib_art_categ ASC , a.lib_article ASC";
	$resultat = $bdd->query ($query);
	while ($abo = $resultat->fetchObject()) { $liste_abonnements[] = $abo; }

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_gestion_abonnements.inc.php");

?>