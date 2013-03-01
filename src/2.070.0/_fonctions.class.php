<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION DES FONCTIONS DES UTILISATEURS 
// *************************************************************************************************************

class fonctions {

	protected $id_fonction;
	protected $lib_fonction;
	protected $desc_fonction;
	protected $id_fonction_parent;
	protected $id_profil;


function __construct ($id_fonction = "") {
	global $bdd;
	if (!is_numeric($id_fonction)) {
		return false;
	}

	$query = "SELECT id_fonction, lib_fonction, desc_fonction, id_fonction_parent, id_profil
						FROM fonctions 
						WHERE id_fonction = '".$id_fonction."' ";
	$resultat = $bdd->query ($query);
	if (!$fonctions = $resultat->fetchObject()) {
		return false; 
	}

	$this->id_fonction 				= $fonctions->id_fonction;
	$this->lib_fonction 			= $fonctions->lib_fonction;
	$this->desc_fonction 			= $fonctions->desc_fonction;
	$this->id_fonction_parent = $fonctions->id_fonction_parent;
	$this->id_profil 					= $fonctions->id_profil;

	return true;
}


// Ajoute une nouvelle fonction
public function create_fonction ($lib_fonction, $desc_fonction, $id_fonction_parent, $id_profil) {
	global $bdd;

	
	if ($lib_fonction == "") {
			$GLOBALS['_ALERTES']['lib_fonction_vide'] = 1;
	}

	// *************************************************
	// Verification qu'il n'y a pas eu d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	

	$query = "INSERT INTO fonctions (lib_fonction, desc_fonction, id_fonction_parent, id_profil)
						VALUES ('".addslashes($lib_fonction)."', '".addslashes($desc_fonction)."', 
										".num_or_null($id_fonction_parent).", '".$id_profil."') ";
	$bdd->exec ($query);
	
	$this->id_fonction 				= $bdd->lastInsertId();
	$this->lib_fonction 			= $lib_fonction;
	$this->desc_fonction 			= $desc_fonction;
	$this->id_fonction_parent = $id_fonction_parent;
	$this->id_profil 					= $id_profil;

	
	
	return true;
}


// Met a jour une fonction
public function maj_fonction ($lib_fonction, $desc_fonction, $id_fonction_parent, $id_profil) {
	global $bdd;

	if ($lib_fonction == "") {
			$GLOBALS['_ALERTES']['lib_fonction_vide'] = 1;
	}
	// *************************************************
	// Verification qu'il n'y a pas eu d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	$query = "UPDATE fonctions 
						SET lib_fonction = '".addslashes($lib_fonction)."', 
								desc_fonction = '".addslashes($desc_fonction)."',
								id_fonction_parent = ".num_or_null($id_fonction_parent).",
								id_profil = '".$id_profil."' 
						WHERE id_fonction = '".$this->id_fonction."'";
	$bdd->exec ($query);
	
	$this->lib_fonction 			= $lib_fonction;
	$this->desc_fonction 			= $desc_fonction;
	$this->id_fonction_parent = $id_fonction_parent;
	$this->id_profil 					= $id_profil;

	return true;
}



// Défini les permissions d'une fonction
public function set_fonction_perms ($permission_liste) {
	global $bdd;

	//suppression des droit existants
	$query = "DELETE FROM fonctions_permissions 
						WHERE id_fonction = '".$this->id_fonction."'";
	$bdd->exec ($query);

	// Création des droits associés
	$query_insert = "";
	foreach ($permission_liste as $permission) {
		if (!$permission) {continue;}
		if ($query_insert) { $query_insert .= ","; }
		$query_insert .= "('".$this->id_fonction."', '".$permission."', 1)";
	}
	if ($query_insert) {
		$query = "INSERT INTO fonctions_permissions
							( id_fonction, id_permission, value) 
							VALUES ".$query_insert;
		$bdd->exec ($query);
	}
	return true;
}




// Défini les fonctions d'un user
static function set_user_fonction ($ref_user, $liste_fonctions) {
	global $bdd;

	//suppression des fonctions de l'utilisateur existants
	$query = "DELETE FROM users_fonctions 
						WHERE ref_user = '".$ref_user."'";
	$bdd->exec ($query);

	// Création des droits associés
	$query_insert = "";
	foreach ($liste_fonctions as $id_fonction) {
		if ($query_insert) { $query_insert .= ","; }
		$query_insert .= "('".$id_fonction."', '".$ref_user."')";
	}
	if ($query_insert) {
		$query = "INSERT INTO users_fonctions  
							( id_fonction, ref_user) 
							VALUES ".$query_insert;
		$bdd->exec ($query);
	}
	return true;
}

//mise à jour des permissions des utilisateurs
static function maj_user_permissions ($ref_contact , $ref_user = "") {
	global $bdd;
	$contact_perms = array();
	
	//selection des permissions liées aux fonctions définies pour un utilisateur
	$query = "SELECT fp.id_fonction,id_permission, value
						FROM fonctions_permissions fp
						RIGHT JOIN annu_collab_fonctions acf ON acf.id_fonction = fp.id_fonction && acf.ref_contact = '".$ref_contact."'
						WHERE fp.id_fonction IS NOT NULL
						ORDER BY id_fonction,id_permission ASC
						";
	$resultat = $bdd->query ($query);
	$perms_list = array();
	while ($perms_fonctions = $resultat->fetchObject()) {
		if(array_key_exists($perms_fonctions->id_permission,$contact_perms)){
			$tmp_values = explode(",",$perms_fonctions->value);
			foreach($tmp_values as $value){
				if ($value == "ALL"){ $contact_perms[$perms_fonctions->id_permission] = array("ALL");}
				if(!in_array($value,$contact_perms[$perms_fonctions->id_permission]) && !in_array("ALL",$contact_perms[$perms_fonctions->id_permission])){
					$contact_perms[$perms_fonctions->id_permission][] = $value;
				}
			}
		}else{
			$contact_perms[$perms_fonctions->id_permission] = explode(",",$perms_fonctions->value);
		}
	}
	
	foreach ($contact_perms as $key=>$value){
		$contact_perms[$key] = implode (",",$value);
	}
	
	$query_user = "SELECT ref_user
								FROM users u 
								WHERE u.ref_contact = '".$ref_contact."'
								";
	if ($ref_user != ""){ $query_user.= " AND u.ref_user='".$ref_user."'"; }
	$result_users = $bdd->query ($query_user);
	while ($users_list= $result_users->fetchObject()) {
		$query_insert = "";
		foreach ($contact_perms as $perm_id=>$perm_value) {
			if ($perm_id) {
				if ($query_insert) { $query_insert .= ","; }
				$query_insert .= "('".$users_list->ref_user."', '".$perm_id."', '".$perm_value."')";
			}
		}	
	
		//liste des permissions 
		$query_perms = "";
		$querya = "SELECT p.id_permission
							FROM permissions p
							WHERE   !ISNULL(id_permission_parent) "; 
		$resultata= $bdd->query($querya);
		while ($tmp = $resultata->fetchObject()) {
			if (!$tmp->id_permission) {continue;}
			if ($query_perms) { $query_perms .= ","; }
			$query_perms .= "'".$tmp->id_permission."'";
		}
		
		//suppression des permissions de l'utilisateur existants
		if ($query_perms) {
			$query = "DELETE FROM users_permissions 
								WHERE ref_user = '".$users_list->ref_user."' && id_permission IN (".$query_perms.")";
			$bdd->exec ($query);
		}
		
		
		//insertion des permissions
		if ($query_insert) {
			$query = "INSERT INTO users_permissions (ref_user, id_permission, value) 
								VALUES ".$query_insert;
			$bdd->exec ($query);
		}
	
	}
	return true;
}

// Maj des permissions utilisateurs lors de mise à jour de fonction
public function maj_fonction_user_permissions () {
	global $bdd;

	//selection des utilisateurs liées aux fonctions
	$query = "SELECT DISTINCT u.ref_contact
						FROM users u
						LEFT JOIN users_permissions up ON up.ref_user = u.ref_user
						LEFT JOIN annu_collab_fonctions acf ON acf.ref_contact = u.ref_contact
						WHERE up.id_permission = '3' && acf.id_fonction = '".$this->id_fonction."' 
						";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		if ($tmp->ref_contact) {$this->maj_user_permissions ($tmp->ref_contact); }
	}
	return true;
}

// Supprime une fonction 
public function delete_fonction () {
	global $bdd;

	$query = "DELETE FROM fonctions WHERE id_fonction = '".$this->id_fonction."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}

static function add_user_permission ($ref_user, $id_permission, $value = "ALL") {
	global $bdd;
	
	if ($ref_user && $id_permission) {
			$query = "INSERT INTO users_permissions (ref_user, id_permission, value) 
								VALUES ('".$ref_user."', '".$id_permission."', '".$value."')";
			$bdd->exec ($query);
	}
	
	return true;

}

static function add_fonction_permission ($id_fonction, $id_permission, $value = "ALL") {
	global $bdd;
	
	if ($id_fonction && $id_permission) {
			$query = "INSERT INTO fonctions_permissions (id_fonction, id_permission, value) 
								VALUES ('".$id_fonction."', '".$id_permission."', '".$value."')";
			echo $query;
			$bdd->exec ($query);
	}
	
	return true;

}

static function del_user_permission ($ref_user, $id_permission) {
	global $bdd;
	
	if ($ref_user && $id_permission) {
			$query = "DELETE FROM users_permissions  WHERE ref_user = '".$ref_user."' && id_permission = '".$id_permission."' 
								";
			$bdd->exec ($query);
	}
	
	return true;

}

static function del_fonction_permission ($id_fonction, $id_permission) {
	global $bdd;
	
	if ($id_fonction && $id_permission) {
			$query = "DELETE FROM fonctions_permissions  WHERE id_fonction = '".$id_fonction."' && id_permission = '".$id_permission."' 
								";
			$bdd->exec ($query);
	}
	
	return true;

}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES
// *************************************************************************************************************

// Recupere le Libelle du profil de la fonction
public function get_profil_lib(){
	global $bdd;
	
	$query = "SELECT lib_profil 
						FROM profils
						WHERE id_profil = '".$this->id_profil."'";
	$resultat = $bdd->query ($query);
	if($var = $resultat->fetchObject()){
		return $var->lib_profil;
	}else{
		return "";
	}
}

public function get_liste_membres(){
	global $bdd;
	
	$liste_membres = array();
	
	$query = "SELECT DISTINCT acf.ref_contact,u.ref_user,nom,pseudo
						FROM annu_collab_fonctions acf
						LEFT JOIN users u ON u.ref_contact = acf.ref_contact
						LEFT JOIN annuaire a ON acf.ref_contact = a.ref_contact
						WHERE id_fonction = '".$this->id_fonction."' AND u.ref_user IS NOT NULL AND u.actif = 1;";
	$resultat = $bdd->query ($query);
	while ($membres = $resultat->fetchObject()){
		$membre_courant = $membres->nom." (".$membres->pseudo.") - <I>";
			$query = "SELECT DISTINCT acf.id_fonction,lib_fonction
						FROM annu_collab_fonctions acf
						LEFT JOIN fonctions f ON acf.id_fonction = f.id_fonction
						WHERE ref_contact = '".$membres->ref_contact."'";
			$resultat2 = $bdd->query ($query);
			while ($fonctions = $resultat2->fetchObject()){
				$membre_courant .=$fonctions->lib_fonction." "; 
			}
			$result = array ();
			$result["datas"] = $membres;
			$result["string"] = $membre_courant."</I>";
	$liste_membres[] = $result;
	}
	if (count($liste_membres) > 0){
		return $liste_membres;
	}else{
		return false;
	}
}


}
// FIN DE LA CLASSE 



// Chargement de la liste des fonctions
function charger_fonctions ($id_profil = "") {
	global $bdd;   

	$query_where = "";
	if ($id_profil) { $query_where = " WHERE id_profil = '".$id_profil."' "; }
	$fonction_tmp = array();
		$query = "SELECT id_fonction, lib_fonction, desc_fonction, id_fonction_parent, id_profil 
						FROM fonctions
						".$query_where."
						";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { 
		$var->permissions = array();
		$query_perms = "SELECT fp.id_permission, p.lib_permission, fp.value
										FROM fonctions_permissions fp 
										LEFT JOIN permissions p ON p.id_permission = fp.id_permission
										WHERE id_fonction = '".$var->id_fonction."'
										";
		$resultat_perms = $bdd->query ($query_perms);
		while ($var_fperms = $resultat_perms->fetchObject()) { $var->permissions[] = $var_fperms;}
		$fonction_tmp[] = $var; 
		unset ($query_perms, $var_fperms, $resultat_perms);
	}

	unset ($query, $var, $resultat );
	
	$fonction = order_by_parent ($fonction,$fonction_tmp,"id_fonction","id_fonction_parent","","");

	return $fonction;
}

// Chargement de la liste des permissions dépendantes
function charger_permissions_dependantes ($id_permission = "") {
	global $bdd;

	$permissions_dependantes = array();
	
		$query = "SELECT pd.id_permission, p.lib_permission
							FROM permissions_dependances pd
							LEFT JOIN permissions p ON pd.id_permission = p.id_permission
 							WHERE id_permission_necessaire = ".$id_permission;
		
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
			$permissions_dependantes[$var_depends->id_permission] = $var_depends->lib_permission;
		}
		return $permissions_dependantes;
}

// Chargement de la liste des permissions dépendantes activées pour un utilisateur
function charger_permissions_dependantes_actives ($id_permission = "", $ref_user = "", $reset=false) {
	global $bdd;

	static $permissions_dependantes_a = array();
	
	if($reset){$permissions_dependantes_a = array();}
	
		$query = "SELECT pd.id_permission, p.lib_permission, up.ref_user
							FROM permissions_dependances pd
							LEFT JOIN permissions p ON pd.id_permission = p.id_permission
              LEFT JOIN users_permissions up ON pd.id_permission = up.id_permission
 							WHERE id_permission_necessaire = ".$id_permission." && up.ref_user = '".$ref_user."'";
		
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
			$permissions_dependantes_a[$var_depends->id_permission] = $var_depends->lib_permission;
			charger_permissions_dependantes_actives ($var_depends->id_permission,$ref_user);
		}
		return $permissions_dependantes_a;
}

// Chargement de la liste des permissions dépendantes activées pour une fonction
function charger_permissions_dependantes_actives_fonctions ($id_permission = "", $id_fonction = "", $reset=false) {
	global $bdd;

	static $permissions_dependantes_a = array();
	
	if($reset){$permissions_dependantes_a = array();}
	
		$query = "SELECT pd.id_permission, p.lib_permission, fp.id_fonction
							FROM permissions_dependances pd
							LEFT JOIN permissions p ON pd.id_permission = p.id_permission
              LEFT JOIN fonctions_permissions fp ON pd.id_permission = fp.id_permission
 							WHERE id_permission_necessaire = ".$id_permission." && fp.id_fonction = '".$id_fonction."'";
		
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
			$permissions_dependantes_a[$var_depends->id_permission] = $var_depends->lib_permission;
			charger_permissions_dependantes_actives_fonctions ($var_depends->id_permission,$id_fonction);
		}
		return $permissions_dependantes_a;
}

// Chargement de la liste des permissions dépendantes du meme type
function charger_permissions_dependantes_meme_type ($id_permission = "", $reset=false) {
	global $bdd;

	static $permissions_dependantes_mt = array();
	static $perm_depart = 0;
	
	if($reset){
		$permissions_dependantes_mt = array();
		$perm_depart = $id_permission;
	}
	
		$query = "SELECT p.id_permission,p.lib_permission
								FROM permissions_dependances pd
								LEFT JOIN permissions p ON pd.id_permission=p.id_permission
								WHERE pd.id_permission_necessaire=".$id_permission." && `values` in (select `values` from permissions where id_permission=".$id_permission.")";
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
			if (!array_key_exists($var_depends->id_permission,$permissions_dependantes_mt) && $var_depends->id_permission!=$perm_depart){
			$permissions_dependantes_mt[$var_depends->id_permission] = $var_depends->lib_permission;
			charger_permissions_dependantes_meme_type ($var_depends->id_permission);
			}
		}
		return $permissions_dependantes_mt;
}

// Chargement de la liste des permissions dépendantes du meme type
function charger_permissions_parentes_meme_type ($id_permission = "", $reset=false) {
	global $bdd;

	static $permissions_parentes = array();
	static $perm_depart = 0;
	
	if($reset){
		$permissions_parentes = array();
		$perm_depart = $id_permission;
	}
	
		$query = "SELECT p.id_permission,p.lib_permission
								FROM permissions_dependances pd
								LEFT JOIN permissions p ON pd.id_permission_necessaire=p.id_permission
								WHERE pd.id_permission=".$id_permission." && `values` in (select `values` from permissions where id_permission=".$id_permission.")";
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
			if (!array_key_exists($var_depends->id_permission,$permissions_parentes) && $var_depends->id_permission!=$perm_depart){
			$permissions_parentes[$var_depends->id_permission] = $var_depends->lib_permission;
			charger_permissions_parentes_meme_type ($var_depends->id_permission);
			}
		}
		return $permissions_parentes;
}


// Chargement de la liste des permissions dépendantes désactivées pour un utilisateur
function charger_permissions_dependantes_inactives ($id_permission = "", $ref_user = "", $reset=false) {
	global $bdd;

	static $permissions_dependantes_i = array();
	
	if($reset){$permissions_dependantes_i = array();}
	
		$query = "SELECT pd.id_permission_necessaire, p.lib_permission,up.ref_user
							FROM permissions_dependances pd
							LEFT JOIN permissions p ON pd.id_permission_necessaire = p.id_permission
  						LEFT JOIN users_permissions up on (p.id_permission=up.id_permission  && (ref_user='".$ref_user."' || ref_user is null))
							WHERE pd.id_permission = ".$id_permission."";
		
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
				if(is_null($var_depends->ref_user)){
			$permissions_dependantes_i[$var_depends->id_permission_necessaire] = $var_depends->lib_permission;
				}
			charger_permissions_dependantes_inactives ($var_depends->id_permission_necessaire,$ref_user);
		}
		return $permissions_dependantes_i;
}

// Chargement de la liste des permissions dépendantes désactivées pour une fonction
function charger_permissions_dependantes_inactives_fonctions ($id_permission = "", $id_fonction = "", $reset=false) {
	global $bdd;

	static $permissions_dependantes_i = array();
	
	if($reset){$permissions_dependantes_i = array();}
	
		$query = "SELECT pd.id_permission_necessaire, p.lib_permission,fp.id_fonction
							FROM permissions_dependances pd
							LEFT JOIN permissions p ON pd.id_permission_necessaire = p.id_permission
  						LEFT JOIN fonctions_permissions fp on (p.id_permission=fp.id_permission  && (id_fonction='".$id_fonction."' || id_fonction is null))
							WHERE pd.id_permission = ".$id_permission."";
		
		$resultat = $bdd->query ($query);
		while ($var_depends = $resultat->fetchObject()) {
				if(is_null($var_depends->id_fonction)){
			$permissions_dependantes_i[$var_depends->id_permission_necessaire] = $var_depends->lib_permission;
				}
			charger_permissions_dependantes_inactives_fonctions ($var_depends->id_permission_necessaire,$id_fonction);
		}
		return $permissions_dependantes_i;
}


// Chargement de la liste des permissions
function charger_permissions ($id_profil = "") {
	global $bdd;   

	$query_where = "";
	if ($id_profil) { $query_where = " && id_profil = '".$id_profil."' "; }
	$permissions_tmp = array();
		$query = "SELECT id_permission, lib_permission, desc_permission, `values`, id_permission_parent
							FROM permissions
							WHERE !ISNULL(id_permission_parent) ".$query_where."
							ORDER BY ordre, lib_permission ASC";
	$resultat = $bdd->query ($query);
	while ($var_perms = $resultat->fetchObject()) { 
		$var_perms->depends = array();
		$query = "SELECT id_permission, id_permission_necessaire
							FROM permissions_dependances
							WHERE id_permission=".$var_perms->id_permission;
		$resultat2 = $bdd->query ($query);
		while ($var_depends = $resultat2->fetchObject()) {
			$var_perms->depends[] = $var_depends->id_permission_necessaire;
		}
		$permissions_tmp[] = $var_perms; 
	}
	unset ($query, $var_perms, $resultat, $resultat2, $var_depends );
	
	$perms = order_by_parent_bis ($perms, $permissions_tmp, "id_permission", "id_permission_parent", "3", "3");
	//$perms = $permissions_tmp;
	return $perms;
}

// Chargement de la liste des fonctions d'un utilisateur
function charger_user_fonctions ($ref_user = "") {
	global $bdd;   

	$user_fonctions = array();
	
	if (!$ref_user) { return false;}
	
	$query = "SELECT id_fonction, ref_user
						FROM users_fonctions
						WHERE ref_user = '".$ref_user."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $user_fonctions[] = $var; }
	
	return $user_fonctions;
}

// Chargement de la liste des fonctions d'un utilisateur
function charger_user_permissions ($ref_user = "") {
	global $bdd;   

	$user_permissions = array();
	
	if (!$ref_user) { return false;}
	
	$query = "SELECT id_permission, ref_user, value
						FROM users_permissions
						WHERE ref_user = '".$ref_user."'";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $user_permissions[$var->id_permission] = $var; }
	
	return $user_permissions;
}



// Chargement de la liste des permissions d'une fonction
function charger_fonction_permissions ($id_fonction = "") {
	global $bdd;   

	$fonction_permissions = array();
	
	if (!$id_fonction) { return false;}
	
	$query = "SELECT id_permission, id_fonction, value
						FROM fonctions_permissions
						WHERE id_fonction = '".$id_fonction."'";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $fonction_permissions[$var->id_permission] = $var; }
	
	return $fonction_permissions;
}

function getDroitVoirAgenda($ref_user, $id_perm){
	global $bdd;
	$tab_tmp = array();
	$tableauDroits = array();
	$tab_droits = array("Voir la dispo","Voir les détails","Modifier");
	
	$query = "SELECT value FROM users_permissions WHERE ref_user = '".$ref_user."' AND id_permission = ".$id_perm." ";
	$res = $bdd->query($query);
	if($retour = $res->fetchObject()){
		$values = $retour->value;
		$tabValues = explode(";",$values);
		for($i=0;$i<count($tabValues);$i++){
			$tab_tmp[] = explode("#",$tabValues[$i]);
		}
		for($i=0;$i<count($tab_tmp);$i++){
			$tableauDroits[$tab_tmp[$i][0]][$tab_tmp[$i][1]]=$tab_tmp[$i][2];
		}
		return $tableauDroits;
	}
	else
	return $tableauDroits;
		
}
function getDroitVoirAdresse($ref_user){
	global $bdd;
	$tableauDroits = array();
	
	$query = "SELECT value FROM users_permissions WHERE ref_user = '".$ref_user."' AND id_permission = 39 ";
	$res = $bdd->query($query);
	if($retour = $res->fetchObject()){
		$values = $retour->value;
		$tabValues = explode(",",$values);
			return $tabValues;
	}
	else
	return $tableauDroits;
		
}
function getDroitVoirCoordonnees($ref_user){
	global $bdd;
	$tableauDroits = array();
	
	$query = "SELECT value FROM users_permissions WHERE ref_user = '".$ref_user."' AND id_permission = 40 ";
	$res = $bdd->query($query);
	if($retour = $res->fetchObject()){
		$values = $retour->value;
		$tabValues = explode(",",$values);
			return $tabValues;
	}
	else
	return $tableauDroits;
		
}
function getDroitVoirSiteWeb($ref_user){
	global $bdd;
	$tableauDroits = array();
	
	$query = "SELECT value FROM users_permissions WHERE ref_user = '".$ref_user."' AND id_permission = 41 ";
	$res = $bdd->query($query);
	if($retour = $res->fetchObject()){
		$values = $retour->value;
		$tabValues = explode(",",$values);
			return $tabValues;
	}
	else
	return $tableauDroits;
		
}

