<?php
// *************************************************************************************************************
// [COLLABORRATEUR] RECHERCHE D'UN ARTICLE CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


if (!isset($_REQUEST['ref_article'])){
	echo "la référence de l'article n'est pas spécifiée.";
	exit;
}
$article = new article($_REQUEST['ref_article']);

// *************************************************
// Données pour le formulaire && la requete
// *************************************************

$nb_fiches = 0;

// *************************************************
// Résultat de la recherche
// *************************************************

$fiches = array();

$query = "
			SELECT	dlA.ref_article, dlA.lib_article, docA.date_creation_doc, IFNULL(dlA.qte, 0) as qte_a_livrer,
							docA.ref_doc, docA.ref_contact, docA.nom_contact, docA.ref_adr_contact, docA.adresse_contact,
							docA.code_postal_contact, docA.ville_contact, docA.id_pays_contact,
							ad.ref_contact, ad.lib_adresse, ad.text_adresse, ad.code_postal, ad.ville, ad.id_pays, ad.note,
							pAc.pays as pays_contact, c.lib_civ_court, co.tel1, co.tel2, cc.lib_client_categ
			FROM 				docs_lines dlA 
			LEFT JOIN 	documents docA ON dlA.ref_doc = docA.ref_doc
			LEFT JOIN 	doc_blc blcA ON blcA.ref_doc = docA.ref_doc
			LEFT JOIN		adresses ad ON docA.ref_adr_contact = ad.ref_adresse 
			LEFT JOIN		pays pAc ON pAc.id_pays = docA.id_pays_contact
			LEFT JOIN annuaire		an ON docA.ref_contact = an.ref_contact
			LEFT JOIN civilites		c  ON an.id_civilite 	= c.id_civilite
			LEFT JOIN coordonnees co ON an.ref_contact 	= co.ref_contact && co.ordre = 1
			LEFT JOIN annu_client ac ON an.ref_contact = ac.ref_contact
			LEFT JOIN clients_categories cc ON ac.id_client_categ = cc.id_client_categ
			WHERE 	docA.id_etat_doc = 13 &&
							dlA.ref_article = '".$article->getRef_article()."' && 
							blcA.id_stock = '".$_SESSION['magasin']->getId_stock()."' &&
							blcA.id_magasin = '".$_SESSION['magasin']->getId_magasin()."'
			ORDER BY docA.ref_contact";

//echo "<br/><hr/><br/>".nl2br($query)."<br/><hr/><br/>";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {
	$fiches[] = $fiche; 
}
unset ($fiche, $resultat, $query);


// *************************************************************************************************************
// EXPORT CSV
// *************************************************************************************************************

header('Pragma: public'); 
header('Expires: 0'); 
header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
header('Content-Type: application/force-download'); 
header('Content-Type: application/octet-stream'); 
header('Content-Type: application/download'); 
header('Content-Type: application/csv; name="listedesabonnes'.urlencode(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", (($article->getLib_article())))))).'.csv"');
header('Content-Disposition: attachment; filename=listedesabonnes'.urlencode(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", (($article->getLib_article())))))).'.csv;'); 

$ligne= "Référence article;Libellé article;Quantité à livrer;Date livraison;Référence BLC;";
$ligne.="Nom du client 1;Nom du client 2;Catégorie de client;Adresse 1;Adresse 2;Adresse 3;Code Postal;Ville;Pays;Informations Adresse;tel 1;tel 2\n";

foreach ($fiches as $fiche) {
	
	$ad = explode("\n", $fiche->adresse_contact);
	
	$adresse1 = "";
	if(count($ad)>0)
		$adresse1 = str_replace("\r", "", str_replace("\n", " ", $ad[0]));
	
	$adresse2 = "";
	if(count($ad)>1) 
		$adresse2 = str_replace("\r", "", str_replace("\n", " ", $ad[1]));
	
	$adresse3 = "";
	if(count($ad)>2)
		$adresse3 = str_replace("\r", "", str_replace("\n", " ", $ad[2]));
	
	$info_adresse = "";
	if($fiche->ref_adr_contact != null)
		$info_adresse = str_replace("\r", "", str_replace("\n", ",", $fiche->note));
	
	$ligne.= $fiche->ref_article;
	$ligne.= ";".$fiche->lib_article;
	$ligne.= ";".$fiche->qte_a_livrer;
	$ligne.= ";".date_Us_to_Fr($fiche->date_creation_doc);
	$ligne.= ";".$fiche->ref_doc;
	
	$pos = stripos($fiche->nom_contact, "\n");
	
	if($pos == false){$pos = strlen($fiche->nom_contact);}
	else{$pos--;}
	
	//Nom du client 1;
	if($fiche->lib_civ_court)
	{		 $ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->lib_civ_court." ".substr($fiche->nom_contact, 0, $pos));}
	else{$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', substr($fiche->nom_contact, 0, $pos));}
	
	//Nom du client 2;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', substr($fiche->nom_contact, $pos+2));
	
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $fiche->lib_client_categ);
	$ligne.= ";".$adresse1.";".$adresse2.";".$adresse3;
	$ligne.= ";".$fiche->code_postal_contact;
	$ligne.= ";".$fiche->ville_contact;
	$ligne.= ";".$fiche->pays_contact;
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $info_adresse);
	$ligne.= ";".$fiche->tel1;
	$ligne.= ";".$fiche->tel2;
	
	$ligne.= "\n";
	
	echo $ligne;
	$ligne = "";
}