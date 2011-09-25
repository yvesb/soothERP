<?php
// *************************************************************************************************************
// FONCTIONS DE GESTION DES COURRIERS 
// *************************************************************************************************************

function getCourriersDunDestinataire($ref_destinataire, $limite_basse = 0, $nb_element = 0, $critere_de_tri = "date", $ordre = "DESC"){
	global $bdd;
	
	$query_select = "";
	$query_left_join = "";
	$query_order_by = "ORDER 	BY ";
	$query_group_by = "";
	$query_limit = "";
	
	//définition de ORDER BY
	switch ($critere_de_tri) {
		//case "suivi":{$query_order_by.="c.suivi ";break;}
		case "objet"			:{$query_order_by.="c.objet ".$ordre;break;}
		case "date"				:{$query_order_by.="c.date_courrier ".$ordre;break;}
		case "expediteur"	:{$query_select.= 	 ", MIN( ce.date_event ) as date_event";
												$query_left_join.= "LEFT JOIN courriers_events ce ON c.id_courrier = ce.id_courrier
																						LEFT JOIN users u ON ce.ref_user = u.ref_user";
												if($query_group_by=="")
													$query_group_by="GROUP BY ";
												$query_group_by.= "c.id_courrier";
												$query_order_by.="u.pseudo ".$ordre.", c.date_courrier DESC";
												break;}
		default						:{$query_order_by.="c.date_courrier ".$ordre;break;}
	}
	
	//définition de LIMIT
	
	if($limite_basse >= 0 && $nb_element > 0){
		$query_limit .= "LIMIT ".$limite_basse.", ".$nb_element;
	}

	$courriers	= array();
	$query = "SELECT 	cd.id_courrier ".$query_select."
						FROM 		courriers_destinataires cd
						LEFT 		JOIN courriers c ON c.id_courrier = cd.id_courrier
						".$query_left_join."
						WHERE 	cd.ref_destinataire = '".$ref_destinataire."'
						".$query_group_by."
						".$query_order_by."
						".$query_limit;
	$resultat = $bdd->query ($query);
	while ($r = $resultat->fetchObject()) {
		$courriers[] = new CourrierEtendu($r->id_courrier);
	}
	return $courriers;
}


//chargement des types de courrier 
function infos_types_courrier_et_modele_de_pdf() {
	global $bdd;
	
	$infos_types	= array();
	$query = "SELECT *
						FROM courriers_modeles_pdf cmp
						LEFT JOIN courriers_types ct ON cmp.id_type_courrier = ct.id_type_courrier
						LEFT JOIN pdf_modeles pm ON cmp.id_pdf_modele = pm.id_pdf_modele
						LEFT JOIN pdf_types pt ON pm.id_pdf_type = pt.id_pdf_type";
	$resultat = $bdd->query ($query);
	while ($groupe = $resultat->fetchObject()) {
		$infos_types[] = $groupe;
	}
	return $infos_types;
}

//cahrgement des types de courrier 
function infos_types_courrier_actifs() {
	global $bdd;
	
	$infos_types	= array();
	$query = "SELECT ct.id_type_courrier, ct.lib_type_courrier, ct.code_courrier
						FROM courriers_types ct
						WHERE ct.actif = '1'";
	$resultat = $bdd->query ($query);
	while ($groupe = $resultat->fetchObject()) {
		$infos_types[] = $groupe;
	}
	return $infos_types;
}

//cahrgement du pdf par défaut pour un type de courrier
function modele_pdf_par_defaut_du_type($id_type_courrie) {
	global $bdd;
	
	$infos_types	= array();
	$query = "SELECT cmp.id_pdf_modele, pm.id_pdf_type, pm.lib_modele, pm.desc_modele, pm.code_pdf_modele
						FROM courriers_modeles_pdf cmp
						LEFT JOIN pdf_modeles pm ON cmp.id_pdf_modele = pm.id_pdf_modele
						WHERE cmp.usage = 'defaut' AND 
									cmp.id_type_courrier = '".$id_type_courrie."' ";
	$resultat = $bdd->query ($query);
	while ($line = $resultat->fetchObject()) {
		return $line;
	}
}


//cahrgement des modeles pdf valides pour un id_type_courrier
function modele_pdf_courrier_valide_du_type($id_type_courrier) {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT cmp.id_pdf_modele, pm.id_pdf_type, pm.lib_modele, pm.desc_modele, pm.code_pdf_modele
						FROM courriers_modeles_pdf cmp
						LEFT JOIN pdf_modeles pm ON cmp.id_pdf_modele = pm.id_pdf_modele
						WHERE cmp.id_type_courrier = '".$id_type_courrier."' AND 
									(cmp.usage = 'defaut' OR cmp.usage = 'actif')";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) {
		$modeles_liste[] = $modele_pdf;
	}
	return $modeles_liste;
}

//@TODO COURRIER : Gestion des filigranes : calsse courrier : charger_filigranes_pdf_courrier()
//liste des filigranes pour un document pdf
function charger_filigranes_pdf_courrier() {
	return "";
}



//désactivation d'un modele pdf
function desactive_courrier_modele_pdf($id_type_courrier) {
	
	if(!isset($id_type_courrier)){
		return false;
	}
	
	global $bdd;
	$query = "UPDATE courriers_types
						SET  `actif` = '0'
						WHERE id_type_courrier = '".$id_type_courrier."'";
	$bdd->exec ($query);
	return true;
}

//activation d'un modele pdf
function active_courrier_modele_pdf($id_type_courrier) {
	
	if(!isset($id_type_courrier)){
		return false;
	}
	
	global $bdd;
	$query = "UPDATE courriers_types
						SET  `actif` = '1'
						WHERE id_type_courrier = '".$id_type_courrier."'";
	$bdd->exec ($query);
	return true;
}


//définie le model par défaut d'un type de courrier
function set_defaut_courrier_modele_pdf($id_type_courrier, $id_pdf_modele) {
	
	if((!isset($id_type_courrier)) || (!isset($id_pdf_modele))){
		return false;
	}
	
	global $bdd;
	
	$bdd->beginTransaction();
	$query = "UPDATE courriers_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_type_courrier = '".$id_type_courrier."' AND
									`usage` = 'defaut'";
	echo $query;
	$bdd->exec ($query);
	$query = "UPDATE courriers_modeles_pdf
						SET  `usage` = 'defaut'
						WHERE id_type_courrier = '".$id_type_courrier."' AND
									id_pdf_modele = '".$id_pdf_modele."'";
	$bdd->exec ($query);
	
	$bdd->commit();
	return true;
}

//mise à jour du lib_type_courrier
function setLib_type_courrier($id_type_courrier, $lib_type_courrier){
	
	if((!isset($id_type_courrier)) || (!isset($lib_type_courrier))){
		return false;
	}
	
	global $bdd;
	
	$query = "UPDATE courriers_types SET lib_type_courrier = '".$lib_type_courrier."'
					WHERE id_type_courrier = '".$id_type_courrier."' ";
	$bdd->exec ($query);
	return true;
}

//charge la liste des etats disponibles pour les courrier 
function charger_etats_courrier(){
	global $bdd;

	$etats_courrier = array();
	$query = "SELECT id_etat_courrier , lib_etat_courrier
						FROM courriers_etats 
						ORDER BY ordre  ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $etats_courrier[] = $var; }

	return $etats_courrier;
}

?>