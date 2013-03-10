<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES DUREES D'ABONNEMENT POUR L'AFFICHAGE DANS LES DOCUMENTS
// *************************************************************************************************************


class duree_abo {

	private $ref_doc_line;
	private $date_debut;
	private $duree;


public function __construct ($ref_doc_line = 0) {
	global $bdd;
	if (!$ref_doc_line) { return false; }

	//$this->ref_doc_line = $ref_doc_line;

	// *************************************************
	// Sélection dans la base
	$query = "SELECT ref_doc_line, date_debut, duree
						FROM doc_line_duree
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$duree = $resultat->fetchObject()) { return false; }

	$this->ref_doc_line		= $duree->ref_doc_line;
	$this->date_debut               = $duree->date_debut;
	$this->duree            	= $duree->duree;
        
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A CREATION D'UNE DUREE D'ABONNEMENT
// *************************************************************************************************************
function create_duree_abo($ref_doc_line,$date_deb_abo,$duree_mois_abo,$duree_jours_abo){
	global $bdd;

	/*if (!is_numeric($date_debut)) {
		$GLOBALS['_ALERTES']['bad_id_client_categ'] = 1;
	}*/

        if(empty($date_deb_abo) || $date_deb_abo == "0000-00-00")
            $date_deb_abo = NULL;

	$this->ref_doc_line		= $ref_doc_line;
	$this->date_debut		= $date_deb_abo;
	$this->duree			= $duree_mois_abo."M".$duree_jours_abo."J";

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

        if($date_deb_abo != NULL)
            $date_deb_abo = date_Fr_to_Us($date_deb_abo);

	// Insertion dans la base
	$query = "INSERT INTO `doc_line_duree` (`ref_doc_line`,`date_debut`,`duree`)
				 VALUES ('".$ref_doc_line."','".$date_deb_abo."','".$duree_mois_abo."M".$duree_jours_abo."J')";

	$bdd->exec ($query);
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A MODIFICATION D'UNE DUREE D'ABONNEMENT
// *************************************************************************************************************
function maj_duree_abo ($ref_doc_line,$date_deb_abo,$duree_mois_abo,$duree_jours_abo) {
	global $bdd;
       
	/*if (!is_numeric($date_debut)) {
		$GLOBALS['_ALERTES']['bad_id_client_categ'] = 1;
	}*/

        if(empty($date_deb_abo) || $date_deb_abo == "0000-00-00")
            $date_deb_abo = NULL;

	$this->ref_doc_line		= $ref_doc_line;
	$this->date_debut		= $date_deb_abo;
	$this->duree			= $duree_mois_abo."M".$duree_jours_abo."J";

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

        if($date_deb_abo != NULL)
            $date_deb_abo = date_Fr_to_Us($date_deb_abo);
	// *************************************************

	// Insertion dans la base
	$query = "UPDATE `doc_line_duree`
					SET `date_debut` = '".$date_deb_abo."',
						`duree` = '".$duree_mois_abo."M".$duree_jours_abo."J'
					WHERE `ref_doc_line` = '".$ref_doc_line."'";
	$bdd->exec ($query);

	return true;
}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************
function getRef_doc_line () {
	return $this->ref_doc_line;
}

function getDate_debut () {
	return $this->date_debut;
}

function getDuree () {
	return $this->duree;
}
}



// *************************************************************************************************************
// FONCTION DE GESTION DE LA DUREE DES ABONNEMENTS
// *************************************************************************************************************


function getDuree_abo ($ref_doc_line) {
	global $bdd;

	$duree_abo = new duree_abo();
	$query = "SELECT ref_doc_line, date_debut, duree
						FROM doc_line_duree
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	
	$resultat = $bdd->query ($query);
	
	if (!$duree_abo = $resultat->fetchObject()) { return false; }
	
	return $duree_abo;

}

?>