<?php 
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE LISTE
// *************************************************************************************************************

class liste {

	private $id_liste;
	private $lib_liste;
	private $type_liste;
	
function __construct($id_liste = "") {
	global $bdd;
	
	// Controle si l' id_liste est précisée
	if (!$id_liste) { return false; }

	// Sélection des informations générales
	$query = "SELECT id_liste, lib_liste, type_liste
						FROM listes
						WHERE id_liste = '".$id_liste."' ";
	$resultat = $bdd->query ($query);

	// Controle si l' id_liste est trouvée
	if (!$liste = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_liste 		= $id_liste;
	$this->lib_liste		= $liste->lib_liste;
	$this->type_liste		= $liste->type_liste;
	return true;
}
	

// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE LISTE
// *************************************************************************************************************

final public function create ($lib_liste) {

}

// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION D'UNE LISTE
// *************************************************************************************************************

public function add_exception ($sens, $ref, $id_liste_contenu) {
	global $bdd;	
	
	// Si tous les parametres sont présents
	if( isset($sens) && isset($ref) && isset($id_liste_contenu) ) {
		
		//Si le sens est valide
		if (!($sens == "ADD" || $sens == "DEL")) {return false; }
		
		// Ajout de contenu
			//Si le contenu existe
			$query = "SELECT *
								FROM listes_contenus
								WHERE id_liste_contenu = $id_liste_contenu";
			$resultat = $bdd->query ($query);
			if (!$type_liste = $resultat->fetchObject()) { return false; }
			
			// *************************************************
			// Insertion dans la base
			if ($sens == "ADD"){ $sens = 1; }
			if ($sens == "DEL"){ $sens = -1; }
			$query = "INSERT INTO listes_contenus_exceptions (sens,id_liste_contenu,ref)
								VALUES ('".$sens."','".$id_liste_contenu."','".$ref."' ) ";
			$bdd->exec ($query);
			
			return true;
	}else{ return false;}

}

public function del_exception ($id_liste_exception){
	global $bdd;
	
	if( isset($id_liste_exception) ){
		// *************************************************
		// Suppression dans la base
		$query = "DELETE FROM listes_contenus_exceptions
							WHERE id_liste_exception = ".$id_liste_exception;
		$bdd->exec ($query);
		return true;
	}
	return false;
}

public function is_in_liste($ref){
	global $bdd;
	
	if(isset($ref)){
		$query = "SELECT ref,sens FROM listes_contenus_exceptions lce
							RIGHT JOIN listes_contenus lc ON lc.id_liste_contenu = lce.id_liste_contenu
							WHERE lc.id_liste='".$this->id_liste."' AND ref='".$ref."'
							ORDER BY sens DESC";
		$resultat = $bdd->query ($query);
		if($exception = $resultat->fetchObject()){
			//Exceptions trouvées
			if($exception->sens == -1) { return false; }
			if($exception->sens == 1) { return true; }
		}else{
			//Pas d'exceptions pour cette Ref on cherche dans les vues
			$query = "SELECT view_name FROM listes_contenus 
								WHERE id_liste='".$this->id_liste."';";
			$resultat = $bdd->query ($query);
			while($view = $resultat->fetchObject()){
				$query = "SELECT ref FROM ".$view->view_name."
									WHERE ref = '".$ref."'";
				$resultat2 = $bdd->query ($query);
				if($ref_trouvee = $resultat2->fetchObject()){	return true; }
			}
		}
	}
	return false;
}

public function generate_full_liste(){
	global $bdd;
	
	$full_liste = array();
	
	//On charge les vues
	$query = "SELECT * FROM listes_contenus 
						WHERE id_liste='".$this->id_liste."';";
	$resultat = $bdd->query ($query);
	while($view = $resultat->fetchObject()){
		$query = "SELECT v.ref ref,t.".$view->champ_lib." lib FROM ".$view->view_name." v
							LEFT JOIN ".$view->table_nom." t ON v.ref = t.".$view->champ_ref.";";
		$resultat2 = $bdd->query ($query);
		//On ajoute le contenu de la vue
		while($ref = $resultat2->fetchObject()){ $full_liste[$ref->ref] = $ref->lib; }

		//On ajoute les exceptions +
		$query = "SELECT lce.ref,t.".$view->champ_lib." lib FROM listes_contenus_exceptions lce
							LEFT JOIN ".$view->table_nom." t ON lce.ref = t.".$view->champ_ref."
							WHERE sens = 1;";
		$resultat2 = $bdd->query ($query);
		while($ref = $resultat2->fetchObject()){ $full_liste[$ref->ref] = $ref->lib; }
		
		//On enleve les exceptions -
		$query = "SELECT lce.ref FROM listes_contenus_exceptions lce
							WHERE sens = -1;";
		$resultat2 = $bdd->query ($query);
		while($ref = $resultat2->fetchObject()){ 
			if( isset($full_liste[$ref->ref]) ) { unset($full_liste[$ref->ref]); }
		}
	}
	ksort($full_liste);
	return $full_liste;
}

}

?>