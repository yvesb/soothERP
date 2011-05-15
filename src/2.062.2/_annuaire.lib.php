<?php
// *************************************************************************************************************
// FONCTIONS LIEES A L'ANNUAIRE
// *************************************************************************************************************

// Fonction retournant la liste des catégories
function get_categories () {
	global $bdd;
	static $categories;

	if (is_array($categories)) {
		return $categories;
	}

	$categories = array();
	$query = "SELECT id_categorie , lib_categorie
						FROM annuaire_categories 
						ORDER BY ordre  ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $categories[] = $var; }

	return $categories;
}


// Fonction retournant la liste des civilites en fonction d'une catégorie
function get_civilites ($id_categorie = "") {
	global $bdd;
	$civilites = array();
	if (!$id_categorie) {
		$query = "SELECT c.id_civilite, c.lib_civ_court, c.lib_civ_long
							FROM civilites c 
					 		ORDER BY lib_civ_court ";
	} else {
		$query = "SELECT c.id_civilite, c.lib_civ_court, c.lib_civ_long
							FROM civilites c 
								LEFT JOIN civilites_categories  cc ON c.id_civilite = cc.id_civilite 
					 		WHERE cc.id_categorie=".$id_categorie."
							ORDER BY lib_civ_court ";
	}
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $civilites[] = $var; }

	return $civilites;
}


// Retourne la liste des constructeurs
function get_constructeurs ($ref_art_categ = "") {
	global $bdd;
 
	$where = "";
	if ($ref_art_categ) { $where = "WHERE a.ref_art_categ = '".$ref_art_categ."'"; }

	// Liste des constructeurs
	$constructeurs = array();
	$query = "SELECT DISTINCT (ac.ref_contact), c.nom
						FROM annu_constructeur ac
							LEFT JOIN articles a ON ac.ref_contact = a.ref_constructeur
							LEFT JOIN annuaire c ON c.ref_contact = ac.ref_contact
						".$where."
						ORDER BY c.nom ASC";
	$resultat = $bdd->query ($query);
	while ($constructeur = $resultat->fetchObject()) { $constructeurs[] = $constructeur; }
	
	return $constructeurs;
}



// Retourne la liste des email d'un contact
function get_contact_emails ($ref_contact) {
	global $bdd;

	if (!$ref_contact) { return false; }

	// Liste des email
	$emails = array();
	$query = "SELECT c.ref_contact, c.email
						FROM coordonnees c
						WHERE c.ref_contact = '".$ref_contact."' ";
	$resultat = $bdd->query ($query);
	while ($email = $resultat->fetchObject()) { $emails[] = $email; }
	
	return $emails;
}

// Retourne la liste des fax d'un contact
function get_contact_faxs ($ref_contact) {
	global $bdd;

	if (!$ref_contact) { return false; }
	// Liste des email
	$faxs = array();
	$query = "SELECT c.ref_contact, c.fax
						FROM coordonnees c
						WHERE c.ref_contact = '".$ref_contact."' ";
	$resultat = $bdd->query ($query);
	while ($fax = $resultat->fetchObject()) { $faxs[] = $fax; }
	
	return $faxs;
}

function getMax_ordre($table_cible, $ref_contact, $querymore = ""){
	global $bdd;
	$query = "SELECT MAX(ordre) ordre FROM ".$table_cible." WHERE ref_contact = '".$ref_contact."' ".$querymore;
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	return $tmp->ordre;
}

function getLangues () {
	global $bdd;
	
	$query = "SELECT id_langage, lib_langage, code_langage  
					FROM langages";
	$resultat	= $bdd->query ($query );
	$langages = $resultat->fetchAll();
	return $langages;
}

//fonction qui cré un petit libélé à afficher pour l'adresse pour un profil client (par exemple)
function getLib_adresse ($ref_adresse) {
	global $bdd;
	
	// Controle si la ref_adresse est précisée
	if (!$ref_adresse) { return false; }

	// Sélection des informations générales
	$query = "SELECT lib_adresse, text_adresse, code_postal, ville
						FROM adresses 
						WHERE ref_adresse = '".$ref_adresse."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_coord est trouvée
	if (!$adresse = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	if ($adresse->lib_adresse!="") {
		return substr($adresse->lib_adresse,0,20)."..";
	} else {
		return substr($adresse->text_adresse ."- " . $adresse->code_postal ."- " . $adresse->ville,0,20)."..";
	}
}


//fonction qui cré un petit libélé à afficher pour la coordonnée d'un utilisateur
function getLib_coordonnee ($ref_coord) {
	global $bdd;
	
	// Controle si la ref_coord est précisée
	if (!$ref_coord) { return false; }

	// Sélection des informations générales
	$query = "SELECT lib_coord, tel1, tel2, fax, email
						FROM coordonnees 
						WHERE ref_coord = '".$ref_coord."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_coord est trouvée
	if (!$coordonnee = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	if ($coordonnee->lib_coord!="") {
		return substr($coordonnee->lib_coord,0,20)."..";
	} else {
		return substr($coordonnee->tel1 ."- " . $coordonnee->tel2 ."- " . $coordonnee->fax ."- " . $coordonnee->email,0,20)."..";
	}
	
}

function fetch_all_profils_contacts() {
	global $bdd;
	
	$profils = array();
	$query = "SELECT id_profil, lib_profil, code_profil 
				FROM profils 
				ORDER BY lib_profil ASC;";
	$res = $bdd->query($query);
	while ($profil = $res->fetchObject()) {
		$profils[] = $profil;
	}
	return $profils;
}

function charge_modele_pdf_contact () {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT id_pdf_modele, id_pdf_type, lib_modele, desc_modele, code_pdf_modele 
				FROM pdf_modeles 
				WHERE id_pdf_type = '4';";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) { 
		$modeles_liste[] = $modele_pdf;
	}
	return $modeles_liste;
}



function check_email_present ($email) {
	global $bdd;
	$query = "SELECT  c.email 
				FROM coordonnees c 
				WHERE c.email = '" . addslashes($email) . "';";
	$resultat = $bdd->query ($query);
	if ($coordonnee = $resultat->fetchObject()) { 
		$GLOBALS['_ALERTES']['email_used'] = 1;
		return true;
	}
	return false;
}

function check_pseudo_present ($pseudo) {
	global $bdd;
	$query = "SELECT u.pseudo 
				FROM users u 
				WHERE u.pseudo = '" . addslashes($pseudo) . "';";
	$resultat = $bdd->query($query);
	if ($coordonnee = $resultat->fetchObject()) { 
		$GLOBALS['_ALERTES']['pseudo_used'] = 1;
		return true;
	}
	return false;
}

function getCivilite($id_civilite) {
	global $bdd;
	$query = "SELECT lib_civ_court FROM civilites WHERE id_civilite = '".$id_civilite."';";
	$res = $bdd->query($query);
	if ($tmp = $res->fetchObject()){
		return $tmp->lib_civ_court;
	}
	return "";
}

function getContacts_profil($id_profil) {
	global $bdd;
	$query = "SELECT *
                    FROM annuaire a
                    JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact
                    WHERE ap.id_profil = '".$id_profil."'
                    ORDER BY a.nom;";
	$res = $bdd->query($query);
        $contacts = array();
	while ($profil = $res->fetchObject()) {
		$contacts[] = $profil;
	}
	return $contacts;
}
?>
