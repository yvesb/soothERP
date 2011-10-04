<?php

// *************************************************************************************************************
// CLASSE DE GESTION DES INFORMATIONS SPECIFIQUES A L'UTILISATEUR COLLABORATEUR 
// *************************************************************************************************************

class user_collab extends profil {

function __construct($profil) {
	parent::__construct($profil);
}


// Charger les taches crées par l'utilisateur
function charger_taches_crees ($order_by = "", $page = 1, $nb_taches = 20, $etat_tache = "0,1") {
	global $bdd;

	if (!$order_by) {
		$order_by = "urgence DESC, importance DESC, date_echeance DESC";
	}
	
	if (!isset($this->ref_user)) { $this->ref_user = $_SESSION['user']->getRef_user();}

	$taches_crees = array();
	$query = "SELECT id_tache
						FROM taches
						WHERE ref_user_createur = '".$this->ref_user."' && etat_tache IN (".$etat_tache.")
						ORDER BY ".$order_by." 
						LIMIT ".(($page-1)*$nb_taches).", ".$page*$nb_taches." ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {	$taches_crees[] =  new tache($tmp->id_tache);	}
	
	//comptage des taches crées par l'utilisateur	
	$nb_taches = 0;
	
	$query = "SELECT COUNT(id_tache) nb_taches
						FROM taches 
						WHERE ref_user_createur = '".$this->ref_user."' && etat_tache IN (".$etat_tache.")";
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_taches += $result->nb_taches; }
	// *************************************************
	// Retour des informations
	
	$GLOBALS['_INFOS']['nb_taches'] = $nb_taches;
	
	return $taches_crees;
}

// *************************************************************************************************************
// GESTION DES TACHES D'UN COLLABORATEUR [COLLAB]  
// *************************************************************************************************************

// Charger les taches du collaborateur en cours
function charger_taches_todo ($order_by = "", $page = 1, $nb_taches = 20, $etat_tache = "0,1") {
	global $bdd;

	if (!$order_by) {
		$order_by = "urgence DESC, importance DESC, date_echeance DESC";
	}

	if (!isset($this->ref_contact)) { $this->ref_contact = $_SESSION['user']->getRef_contact();}
	
	$taches_todo = array();
	$query = "SELECT DISTINCT t.id_tache
						FROM taches t
							LEFT JOIN taches_collabs tc ON t.id_tache = tc.id_tache
							LEFT JOIN taches_collabs_fonctions tcg ON t.id_tache = tcg.id_tache 
							LEFT JOIN annu_collab_fonctions cgc ON cgc.id_fonction = tcg.id_fonction
						WHERE etat_tache IN (".$etat_tache.") && 
									(tc.ref_contact = '".$this->ref_contact."' || cgc.ref_contact = '".$this->ref_contact."') 
						ORDER BY ".$order_by." 
						LIMIT ".(($page-1)*$nb_taches).", ".$page*$nb_taches." ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {	$taches_todo[] =  new tache($tmp->id_tache); }

	// Comptage les taches du collaborateur en cours
	$nb_taches = 0;
	$query = "SELECT COUNT(t.id_tache) nb_taches
						FROM taches t
								LEFT JOIN taches_collabs tc ON t.id_tache = tc.id_tache
								LEFT JOIN taches_collabs_fonctions tcg ON t.id_tache = tcg.id_tache 
								LEFT JOIN annu_collab_fonctions cgc ON cgc.id_fonction = tcg.id_fonction
						WHERE etat_tache IN (".$etat_tache.") && 
									(tc.ref_contact = '".$this->ref_contact."' || cgc.ref_contact = '".$this->ref_contact."')  ";
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_taches += $result->nb_taches; }
	
	// *************************************************
	// Retour des informations
	
	$GLOBALS['_INFOS']['nb_taches'] = $nb_taches;
	
	return $taches_todo;
}


// Charger les documents ouverts
function charger_open_docs () {
	global $bdd;

	$nb_docs = 5;

	$open_docs = array();
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, ref_contact, nom_contact, 
									( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
										FROM docs_lines dl
										WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
									 d.date_creation_doc as date_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE de.is_open = 1
						GROUP BY d.ref_doc 
						ORDER BY date_doc DESC
						LIMIT 0, ".$nb_docs;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {	$open_docs[] =  $tmp; }

	return $open_docs;
}



}


?>