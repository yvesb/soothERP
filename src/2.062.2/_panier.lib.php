<?php
// *************************************************************************************************************
// FONCTION DE VERIFICATION DE L'EXISTANCE DU PANIER
// *************************************************************************************************************

//fonction qui charge ou cré le document panier du client pour une utilisation
function open_client_panier () {
	global $bdd;
	global $DIR;
	global $PANIER_CLIENT_ID_TYPE_DOC;
	
	//$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] =  $_SESSION['user']->getRef_contact ();
	
	$query = "SELECT ref_doc, id_type_doc FROM documents
						WHERE ref_contact = '".$_SESSION['user']->getRef_contact ()."' && id_type_doc = '".$PANIER_CLIENT_ID_TYPE_DOC."' && id_etat_doc = '41'
						LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if ($doc = $resultat->fetchObject()) {
		require_once ($DIR."documents/_doc_".strtolower($_SESSION['types_docs'][$doc->id_type_doc]->code_doc).".class.php");
		// Creation de l'objet correspondant
		$classe_doc = "doc_".$_SESSION['types_docs'][$doc->id_type_doc]->code_doc;
		$document = new $classe_doc ($doc->ref_doc);
		$document->open_doc();
	
	} else {
		require_once ($DIR."documents/_doc_".strtolower($_SESSION['types_docs'][$PANIER_CLIENT_ID_TYPE_DOC]->code_doc).".class.php");
		// Creation d'un nouvel objet correspondant
		$classe_doc = "doc_".$_SESSION['types_docs'][$PANIER_CLIENT_ID_TYPE_DOC]->code_doc;
		$document = new $classe_doc ();
		$document->create_doc ();
	}

		if (!$document->getRef_doc()) { return false; }

	return $document;

}

function gestion_panier() {
	global $bdd;
	global $PANIER_CLIENT_ID_TYPE_DOC;
	global $_INTERFACE;
	global $COOKIE_INTERFACE_LT;
	global $TMP_PANIER_LT;
	
	
	$id_panier = "";
	if (isset($_COOKIE["panier_interface_".$_INTERFACE['ID_INTERFACE']] )) {
		$id_panier = $_COOKIE["panier_interface_".$_INTERFACE['ID_INTERFACE']];
	}
	if (isset( $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]) && $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]) {
		//récupération du numéro de panier
		$id_panier = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"];
	}
	if (!isset($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"])) {
		$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] = $_INTERFACE['APP_TARIFS'];
	}
	
	//chargement des infos du panier (si il n'existe pas on le cré, si il est dépassé on le supprime et on en cré un nouveau)
	$query = "SELECT id_panier, id_interface, date FROM interface_panier
						WHERE  id_panier = '".$id_panier."' && date > '".date("Y-m-d", time()-$TMP_PANIER_LT)."'
						
						";
	$resultat = $bdd->query ($query);
	if (!$panier = $resultat->fetchObject()) {
		// on supprime les panier dépassés
		$query = "DELETE FROM interface_panier WHERE  date < '".date("Y-m-d", time()-$TMP_PANIER_LT)."'";		
		$bdd->exec ($query);
		
		//on cré le nouveau
		$query = "INSERT INTO interface_panier (id_interface, date) VALUES ('".$_INTERFACE['ID_INTERFACE']."', NOW())";		
		$bdd->exec ($query);
		$id_panier = $bdd->lastInsertId();
		
	}
	
	setcookie("panier_interface_".$_INTERFACE['ID_INTERFACE'], $id_panier , time()+$COOKIE_INTERFACE_LT , '/');
	$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"] = $id_panier;

	$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"] = array();
	//chargement du contenu du panier
	$query = "SELECT ref_article, qte FROM interface_panier_contenu
						WHERE id_panier = '".$id_panier."' 
						";
	$resultat = $bdd->query ($query);
	while ($lines = $resultat->fetchObject()) {
		$line = new stdclass;
		$line->qte = $lines->qte;
		$line->type_of_line = "article";
		
		$line->article = new article($lines->ref_article);
		$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"][] = $line;
		
		unset ($line);
	}
}

function interface_add_line_panier ($ref_article, $qte) {
	global $bdd;
	global $_INTERFACE;
	
	//si l'article est déjà dans le panier	on met juste à jour la qte
	$query = "SELECT ref_article, qte FROM interface_panier_contenu
						WHERE id_panier = '".$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]."'  && ref_article = '".$ref_article."'
						";
	$resultat = $bdd->query ($query);
	if ($art = $resultat->fetchObject()) {
		interface_maj_line_panier ($ref_article, $qte) ;
		return true;
	}
	
	$query = "INSERT INTO interface_panier_contenu (id_panier, ref_article, qte) VALUES ('".$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]."' ,'".$ref_article."' , '".$qte."')";		
	$bdd->exec ($query);
		
	update_panier_validiter ();
	gestion_panier();
}

function interface_maj_line_panier ($ref_article, $qte) {
	global $bdd;
	global $_INTERFACE;
	
	$query = "UPDATE interface_panier_contenu SET qte = '".$qte."' 
						WHERE  id_panier = '".$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]."' && ref_article = '".$ref_article."' ";		
	$bdd->exec ($query);
		
	update_panier_validiter ();
	gestion_panier();

}

function interface_del_line_panier ($ref_article) {
	global $bdd;
	global $_INTERFACE;
	
	$query = "DELETE FROM  interface_panier_contenu 
						WHERE  id_panier = '".$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]."' && ref_article = '".$ref_article."' ";		
	$bdd->exec ($query);
		
	update_panier_validiter ();
	gestion_panier();

}


function interface_del_panier () {
	global $bdd;
	global $_INTERFACE;
	
	$query = "DELETE FROM  interface_panier_contenu 
						WHERE  id_panier = '".$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]."'  ";		
	$bdd->exec ($query);
		
	update_panier_validiter ();
	gestion_panier();

}

function update_panier_validiter () {
	global $bdd;
	global $_INTERFACE;

	$query = "UPDATE interface_panier SET date = NOW() WHERE id_panier = '".$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["id_panier"]."'";		
	$bdd->exec ($query);
	return true;
}

function interface_article_pv ($article, $qte) {
	global $bdd;
	global $ID_MAGASIN;

	// Tarif par défaut pour le magasin en cours
	$id_tarif = $_SESSION['magasins'][$ID_MAGASIN]->getId_tarif();
	$pu_ht = 0;

	// Sélection de la grille tarifaire particulière à ce client, si définie
	if ($_SESSION['user']->getRef_contact()) {
		$query = "SELECT id_tarif FROM annu_client 
							WHERE ref_contact = '".$_SESSION['user']->getRef_contact()."' ";
		$resultat = $bdd->query($query);
		$tmp = $resultat->fetchObject();
		if (isset($tmp->id_tarif) && $tmp->id_tarif) { $id_tarif = $tmp->id_tarif; }
	}

	// Sélection du tarif applicable
	$query = "SELECT pu_ht, indice_qte
						FROM articles_tarifs
						WHERE ref_article = '".$article->getRef_article()."' && id_tarif = '".$id_tarif."' 
						ORDER BY indice_qte DESC";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {
		$pu_ht = $tmp->pu_ht;
		if ($qte >= $tmp->indice_qte) { break; }
	}

	return $pu_ht;
}
?>