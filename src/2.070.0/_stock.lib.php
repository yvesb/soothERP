<?php
// *************************************************************************************************************
// FONCTIONS DE GESTION DES STOCKS DE LA SOCIETE
// *************************************************************************************************************

/* LES 2 FONCTIONS SUIVANTES NE SONT PAS UTILISEE
function getStock_entrees ($id_stock, $date_debut, $date_fin, $begin = 0, $nb_fiches_showed = 100) {
	global $bdd;

	$entrees = array();
	$query = "SELECT sm.id_stock, sm.ref_article, sm.qte, sm.ref_doc, sm.date, s.lib_stock, s.abrev_stock
						FROM stocks_moves sm 
							LEFT JOIN stocks s ON sm.id_stock = s.id_stock 
						WHERE sm.id_stock = '".$id_stock."' && qte > 0 && sm.date >= '".$date_debut."' &&  sm.date <= '".$date_fin."'
						ORDE BY sm.date DESC
						LIMIT ".$begin.", ".$nb_fiches_showed;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $entrees[] = $tmp; }

	return $entrees;
}


function getStock_sorties ($id_stock, $date_debut, $date_fin, $begin = 0, $nb_fiches_showed = 100) {
	global $bdd;

	$sorties = array();
	$query = "SELECT sm.id_stock, sm.ref_article, sm.qte, sm.ref_doc, sm.date, s.lib_stock, s.abrev_stock
						FROM stocks_moves sm
							LEFT JOIN stocks s ON sm.id_stock = s.id_stock
						WHERE sm.id_stock = '".$id_stock."' && qte < 0 && sm.date >= '".$date_debut."' &&  sm.date <= '".$date_fin."'
						ORDE BY sm.date DESC
						LIMIT ".$begin.", ".$nb_fiches_showed;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $sorties[] = $tmp; }

	return $sorties;
}*/

// Affiche un tarif au format désiré
function qte_format($qte) {
	global $ARTICLE_QTE_NB_DEC;
	return round($qte,$ARTICLE_QTE_NB_DEC);
}

//**************************************\\
// Fonctions pour les modèles d'exports

function charge_modele_export_etat_stocks(){
	global $bdd;
	
	$modeles_liste	= array();
	$query = "SELECT id_export_modele, id_export_type, lib_modele, desc_modele , code_export_modele , extension
							FROM exports_modeles  
							WHERE id_export_type = '6';
							";
	$resultat = $bdd->query ($query);
	while ($modele_export = $resultat->fetchObject()) { $modeles_liste[] = $modele_export;}
	return $modeles_liste;
}


function get_code_export_etat_stocks(){
	global $bdd;
	$query = "SELECT code_export_modele FROM exports_modeles WHERE id_export_modele IN
		( SELECT id_export_modele FROM exports_modeles_usage WHERE `usage` = 'defaut');";
	$res = $bdd->query($query);
	//return ($res->fetchObject()) ? $res->fetchObject()->code_pdf_modele : '';
	if ($r = $res->fetchObject()) {
		$tmp = $r->code_export_modele;
	} else {
		$query = "SELECT code_export_modele FROM exports_modeles WHERE id_export_type ='6';";
		$res = $bdd->query($query);
		$tmp = ($r = $res->fetchObject()) ? $r->code_export_modele : false;
	}
	return $tmp;
}

//modele ods par défaut
function defaut_etat_stocks_export ($id_export_modele) {
	global $bdd;
	
	$query = "UPDATE exports_modeles_usage
						SET  `usage` = 'actif'
						WHERE `usage` = 'defaut' && id_objet ='6'
						";
	$bdd->exec ($query);
	
	$query = "UPDATE exports_modeles_usage
						SET  `usage` = 'defaut'
						WHERE id_export_modele = '".$id_export_modele."' 
						";
	$bdd->exec ($query);
	return true;
}

//activation d'un modele ods
function active_etat_stocks_export ($id_export_modele) {
	global $bdd;
	
	$query = "UPDATE exports_modeles_usage
						SET  `usage` = 'actif'
						WHERE  id_export_modele = '".$id_export_modele."' 
						";
	$bdd->exec ($query);
	return true;
}

//désactivation d'un modele ods
function desactive_etat_stocks_export ($id_export_modele) {
	global $bdd;
	
	$query = "UPDATE exports_modeles_usage
						SET  `usage` = 'inactif'
						WHERE id_export_modele = '".$id_export_modele."' 
						";
	$bdd->exec ($query);
	return true;
}

function getListeExportEtatStocks(){
	global $bdd;
	
	$liste = array();
	$query = "SELECT  smp.id_export_modele, smp.usage, pm.lib_modele, pm.desc_modele
		FROM exports_modeles_usage smp
		LEFT JOIN exports_modeles pm ON smp.id_export_modele = pm.id_export_modele
		WHERE pm.id_export_type = '6'
		ORDER BY pm.lib_modele ASC, smp.usage ASC;";
	$res = $bdd->query($query);
	while ($r = $res->fetchObject()) { $liste[] = $r;}
	return $liste;
}
//Fin pour les résultats commerciaux

