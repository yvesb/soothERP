<?php
// *************************************************************************************************************
// GESTION des terminaux de paiement electronique et virtuels
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_tpe"])) {
if (!$_SESSION['user']->check_permission ("33",$_REQUEST["id_tpe"])) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}
	
//on traite un TPE
$compte_tp	= new compte_tpe($_REQUEST["id_tpe"]);
$query_search = "
						SELECT rec.ref_reglement, ccm.id_compte_caisse, 
									 r.ref_contact, r.date_saisie, r.montant_reglement, r.date_reglement,
									 rd.ref_doc,
									 rm.lib_reglement_mode, rm.abrev_reglement_mode,
									 cc.lib_caisse,
									 u.pseudo, 
									 a.nom
	
						FROM regmt_e_cb rec
							LEFT JOIN reglements r ON r.ref_reglement = rec.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN comptes_caisses_moves ccm ON ccm.id_compte_caisse_move = rec.id_compte_caisse_move
							LEFT JOIN comptes_caisses cc ON cc.id_compte_caisse = ccm.id_compte_caisse
							LEFT JOIN users u ON u.ref_user = ccm.ref_user
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
							
						WHERE  rec.id_compte_tpe_dest = '".$_REQUEST["id_tpe"]."'   && r.valide = '1'
						GROUP BY rec.ref_reglement
						ORDER BY r.date_reglement DESC
						LIMIT 10";
}
//sinon un TPV
if (isset($_REQUEST["id_tpv"])) {
if (!$_SESSION['user']->check_permission ("37",$_REQUEST["id_tpv"])) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}
//on traite un TPE
$compte_tp	= new compte_tpv($_REQUEST["id_tpv"]);
$query_search = "
						SELECT rec.ref_reglement,
									 r.ref_contact, r.date_saisie, r.montant_reglement, r.date_reglement,
									 rd.ref_doc,
									 rm.lib_reglement_mode, rm.abrev_reglement_mode, 
									 a.nom
	
						FROM regmt_e_tpv rec
							LEFT JOIN reglements r ON r.ref_reglement = rec.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
							
						WHERE  rec.id_compte_tpv_dest = '".$_REQUEST["id_tpv"]."'   && r.valide = '1'
						GROUP BY rec.ref_reglement
						ORDER BY r.date_reglement DESC
						LIMIT 10";

}

$last_date_telecollecte = $compte_tp->getLast_date_telecollecte ();
$totaux_theoriques = $compte_tp->collecte_total ();



//affichage des derniers mouvement
$fiches = array();
$resultat = $bdd->query($query_search);

while ($fiche = $resultat->fetchObject()) {
	$fiches[] = $fiche; 
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gestion2_terminaux.inc.php");

?>