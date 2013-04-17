<?php
// *************************************************************************************************************
// GESTION des caisses
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("9",$_REQUEST["id_caisse"])) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}


$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);
$last_date_controle = $compte_caisse->getLast_date_controle ();
$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();

//affichage des derniers mouvement
$fiches = array();
// Recherche
$query = "SELECT ccm.id_compte_caisse_move, ccm.id_compte_caisse, ccm.id_move_type, ccm.id_reglement_mode, 
								 ccm.date_move, ccm.ref_user, ccm.montant_move, ccm.Info_supp,
								 rm.lib_reglement_mode, rm.type_reglement,
								 cmt.lib_move_type,
								 u.pseudo

					FROM comptes_caisses_moves ccm
						LEFT JOIN reglements_modes rm ON rm.id_reglement_mode = ccm.id_reglement_mode
						LEFT JOIN comptes_moves_types cmt ON cmt.id_move_type = ccm.id_move_type
						LEFT JOIN users u ON u.ref_user = ccm.ref_user
						
					WHERE  ccm.id_compte_caisse = '".$_REQUEST["id_caisse"]."'  
					ORDER BY ccm.date_move DESC
					LIMIT 10";
$resultat = $bdd->query($query);

while ($fiche = $resultat->fetchObject()) {
	$fiches[] = $fiche; 
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gestion2_caisse.inc.php");

?>