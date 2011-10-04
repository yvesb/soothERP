<?php
// *************************************************************************************************************
// FONCTIONS LIEES AU CATALOGUE
// *************************************************************************************************************

// Renvoie un tableau des catégories d'articles disponibles
function get_articles_categories ($ref_cle_ignored = "", $liste_ignored = array()) {
	global $bdd;
	
	$where = "";
	if (count($liste_ignored)) {
		foreach ($liste_ignored as $ignore) {
			if ($where) {$where .= " && ";}
			if (!$where) {$where .= " WHERE ";}
			$where .= " ref_art_categ != '".$ignore."' ";
		}
	}
	$categs_tmp = array();
	$query = "SELECT ref_art_categ, lib_art_categ, modele, desc_art_categ, duree_dispo, ref_art_categ_parent
						FROM art_categs
						".$where."
						 ORDER BY lib_art_categ ASC ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $categs_tmp[] = $var; }

	$categs = order_by_parent ($categs, $categs_tmp, "ref_art_categ", "ref_art_categ_parent", "", $ref_cle_ignored);

	return $categs;
}

//fonction renvoyant les art_categ principales (racine)
function get_art_categs_racine () {
	global $bdd;
	
	$categs_racine = array();
	$query = "SELECT ref_art_categ, lib_art_categ, modele, desc_art_categ, duree_dispo, ref_art_categ_parent
						FROM art_categs
						WHERE ISNULL(ref_art_categ_parent)
						ORDER BY lib_art_categ ASC ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $categs_racine[] = $var; }

	return $categs_racine;
}

// Renvoie un tableau des catégories d'articles disponibles
function get_child_categories ($categs, $ref_art_categ = "") {
	global $bdd;
	
	$categs[] = $ref_art_categ; 
	
	$query = "SELECT ref_art_categ, ref_art_categ_parent
						FROM art_categs
						WHERE ref_art_categ_parent = '".$ref_art_categ."' 
						";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		if ($var->ref_art_categ ) {
			$categs = get_child_categories ($categs, $var->ref_art_categ);
		}
	}

	return $categs;
}


/*
Renvoie un arbre d'obejts art_categ
RACINE -> tableau de taille n
|
+---NOEUD -> tableau de taille 2
|   +---objet art_categ
|   +--- tab d'obejts de art_categs
|       |   catalogue_articles_service_abo_renouveller_all_checked.php
|       |   
|       +---FEUILLE  -> tableau de taille 1
|				|		+---objet art_categ
|       |
|       +---FEUILLE  -> tableau de taille 1
|				|		+---objet art_categ
|       |
|       +---FEUILLE  -> tableau de taille 1
|						+---objet art_categ
|
+---NOEUD -> tableau de taille 2
|   +---objet art_categ
|   +--- tab d'obejts de art_categs
|       |   catalogue_articles_service_abo_renouveller_all_checked.php
|       |   
|       +---FEUILLE  -> tableau de taille 1
|						+---objet art_categ
|   
*---FEUILLE  -> tableau de taille 1
				+---objet art_categ
*/

function get_child_obj_categories ($ref_art_categ_parent = "", $profondeur = -1) {
	global $bdd;
	
	$categs = array();

	if($ref_art_categ_parent != ""){
		$query_where = "ref_art_categ_parent = '".$ref_art_categ_parent."'";
	}else{
		$query_where = "ISNULL(ref_art_categ_parent)";
	}
	
	$query = "SELECT ref_art_categ, lib_art_categ
						FROM art_categs
						WHERE ".$query_where."  
						ORDER BY lib_art_categ ASC ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		if ($var->ref_art_categ ) {
			if($profondeur == 0){
				$categs[] = array( new art_categ($var->ref_art_categ));
			}else{
				$categs[] = array( new art_categ($var->ref_art_categ), get_child_obj_categories ($var->ref_art_categ, $profondeur - 1) );
			}
		}
	}
	return $categs;
}


// Renvoie un tableau des catégories d'articles disponibles
function get_articles_categories_materiel ($ref_cle_ignored = "") {
	global $bdd;
	
	$categs_tmp = array();
	$query = "SELECT ref_art_categ, lib_art_categ, modele, desc_art_categ, duree_dispo, ref_art_categ_parent
						FROM art_categs
						WHERE modele = 'materiel'
						ORDER BY lib_art_categ ASC ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $categs_tmp[] = $var; }

	$categs = order_by_parent ($categs, $categs_tmp, "ref_art_categ", "ref_art_categ_parent", "", $ref_cle_ignored);

	return $categs;
}

// Renvoie un tableau des composants d'un article
function get_article_composants ($ref_article) {
	global $bdd;
	
	$composants = array();
	
	$query = "SELECT ac.ref_article_lot, ac.ref_lot_contenu, ac.ref_article_composant, ac.qte, ac.niveau, ac.ordre,
									 a.lib_article, a.lot, a.valo_indice
						FROM articles_composants ac
							LEFT JOIN articles a ON a.ref_article = ac.ref_article_composant
						WHERE ac.ref_article_lot = '".$ref_article."'
						ORDER BY ac.niveau, ac.ordre ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $composants[] = $tmp; }

	return $composants;
}


// Renvoie un tableau des tarifs d'un article
function get_article_tarifs ($ref_article, $id_tarif) {
	global $bdd;

	$tarifs = array();

	$query = "SELECT indice_qte, pu_ht
						FROM articles_tarifs at
						WHERE at.ref_article = '".$ref_article."' && at.id_tarif = '".$id_tarif."'
						ORDER BY indice_qte ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $tarifs[] = $tmp; }

	return $tarifs;
}


// Renvoie un tableau des taxes d'un article
function get_article_taxes ($ref_article, $id_pays = 0) {
	global $bdd;
	global $DEFAUT_ID_PAYS;
	
	if (!$id_pays) { $id_pays = $DEFAUT_ID_PAYS; }

	$taxes = array();
	
	$query = "SELECT t.id_taxe, lib_taxe, montant_taxe
						FROM articles_taxes at
							LEFT JOIN taxes t ON at.id_taxe = t.id_taxe
						WHERE at.ref_article = '".$ref_article."' && t.id_pays = '".$id_pays."'
						ORDER BY lib_taxe ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $taxes[] = $tmp; }
	
	return $taxes;
}


// Renvoie les différents types de liaisons actives
function get_liaisons_types () {
	global $bdd;

	$liaisons = array();
	$query = "SELECT id_liaison_type, lib_liaison_type , ordre, actif, systeme
						FROM art_liaisons_types
						WHERE actif=1 && systeme = 0
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($liaison = $resultat->fetchObject()) { $liaisons[] = $liaison; }
	
	return $liaisons;
}


// Renvoie les différents types de liaisons existants
function get_liaisons_types_exist () {
	global $bdd;

	$liaisons = array();
	$query = "SELECT id_liaison_type, lib_liaison_type , ordre, actif, systeme
						FROM art_liaisons_types
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($liaison = $resultat->fetchObject()) { $liaisons[] = $liaison; }
	
	return $liaisons;
}


//liste des tva
function get_tvas ($id_pays) {
	global $bdd;
	
	$tvas = array();
	$query = "SELECT id_tva, tva, id_pays,num_compte_achat ,num_compte_vente 
										,pc.lib_compte as lib_compte_achat, pc2.lib_compte as lib_compte_vente
						FROM tvas 
						LEFT JOIN plan_comptable pc ON pc.numero_compte = num_compte_achat
						LEFT JOIN plan_comptable pc2 ON pc2.numero_compte = num_compte_vente
						WHERE id_pays='".$id_pays."' 
						ORDER BY tva ASC";
	$resultat = $bdd->query ($query);
	$tvas = $resultat->fetchAll();
	return $tvas;
}

//liste des tvas pas pays
function fetch_all_tvas () {
	global $bdd;
	
	$tvas = array();
	$query = "SELECT id_tva, tva, t.id_pays, p.pays
						FROM tvas t	
						JOIN pays p ON t.id_pays=p.id_pays
						ORDER BY t.id_pays ASC";
	$resultat = $bdd->query ($query);
	$tvas = $resultat->fetchAll();
	return $tvas;
}
//ajout tva
function add_tva ($infos_tva) {
	global $bdd;
	
	$query = "INSERT INTO tvas (tva, id_pays)
						VALUES ('".$infos_tva["tva"]."', '".$infos_tva["id_pays"]."') ";
	$bdd->exec($query);
}

//modification tva
function maj_tva ($id_tva, $infos_tva) {
	global $bdd;
	
	$query = "UPDATE tvas 
						SET ";
	foreach ($infos_tva as $key=>$val) {
		$query .= " ".$key." = '".$val."' ";
	}				
	$query .= "WHERE id_tva='".$id_tva."' ";
	
	$bdd->exec($query);
}

//suppression tva
function del_tva ($id_tva) {
	global $bdd;
	
	$query = "DELETE FROM tvas 
						WHERE id_tva='".$id_tva."' ";
	$bdd->exec($query);
}

// Renvoi un tableau des différentes valorisations
function get_valorisations () {
	global $bdd;
	
	$articles_valos = array();
	$query = "SELECT id_valo, groupe, lib_valo, abrev_valo, popup
						FROM articles_valorisations
						ORDER BY groupe ASC, lib_valo ASC ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $articles_valos[] = $var; }

	return $articles_valos;
}
?>