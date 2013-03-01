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
SELECT res.ref_article, res.lib_article, res.qte, res.qte_livree,
			res.date_creation_doc, res.ref_doc, res.ref_contact, res.nom_contact, res.ref_adr_contact, res.adresse_contact,
			res.code_postal_contact, res.ville_contact, res.id_pays_contact, res.ref_adr_livraison, res.adresse_livraison,
			res.code_postal_livraison, res.ville_livraison, res.id_pays_livraison, res.pays, res.pays_livraison,
			ad.ref_contact, ad.lib_adresse, ad.text_adresse, ad.code_postal, ad.ville, ad.id_pays, ad.note, c.lib_civ_court, co.tel1, co.tel2,
			cc.lib_client_categ
FROM ((
			SELECT dlA.ref_article, dlA.lib_article, IFNULL(dlA.qte, 0) as qte, IFNULL(dl_cdcA.qte_livree, 0) as qte_livree,
			docA.date_creation_doc, docA.ref_doc, docA.ref_contact, docA.nom_contact, docA.ref_adr_contact, docA.adresse_contact,
			docA.code_postal_contact, docA.ville_contact, docA.id_pays_contact, cdcA.ref_adr_livraison, cdcA.adresse_livraison,
			cdcA.code_postal_livraison, cdcA.ville_livraison, cdcA.id_pays_livraison, pAc.pays, pAl.pays as pays_livraison
			FROM 				docs_lines dlA 
			LEFT JOIN 	doc_lines_cdc dl_cdcA ON dl_cdcA.ref_doc_line = dlA.ref_doc_line
			LEFT JOIN 	documents docA ON dlA.ref_doc = docA.ref_doc
			LEFT JOIN 	doc_cdc cdcA ON cdcA.ref_doc = docA.ref_doc
			LEFT JOIN		pays pAc ON pAc.id_pays = docA.id_pays_contact
			LEFT JOIN		pays pAl ON pAl.id_pays = cdcA.id_pays_livraison
			WHERE 	docA.id_etat_doc = 9 &&
							dlA.ref_article = '".$article->getRef_article()."' && 
							cdcA.id_stock = '".$_SESSION['magasin']->getId_stock()."' &&
							cdcA.id_magasin = '".$_SESSION['magasin']->getId_magasin()."'
		)UNION(
			SELECT dlB.ref_article, dlB.lib_article, IFNULL(dlB.qte, 0) as qte, 0 as qte_livree,
			docB.date_creation_doc, docB.ref_doc, docB.ref_contact, docB.nom_contact, docB.ref_adr_contact, docB.adresse_contact,
			docB.code_postal_contact, docB.ville_contact, docB.id_pays_contact, cdcB.ref_adr_livraison, cdcB.adresse_livraison,
			cdcB.code_postal_livraison, cdcB.ville_livraison, cdcB.id_pays_livraison, pBc.pays, pBl.pays as pays_livraison
			FROM 				docs_lines dlB
			LEFT JOIN 	documents docB ON dlB.ref_doc = docB.ref_doc
			LEFT JOIN 	doc_cdc cdcB ON cdcB.ref_doc = docB.ref_doc
			LEFT JOIN		pays pBc ON pBc.id_pays = docB.id_pays_contact
			LEFT JOIN		pays pBl ON pBl.id_pays = cdcB.id_pays_livraison
			WHERE		docB.id_etat_doc	=9 &&
							dlB.ref_article		= '".$article->getRef_article()."' && 
							cdcB.id_stock			= '".$_SESSION['magasin']->getId_stock()."' &&
							cdcB.id_magasin		= '".$_SESSION['magasin']->getId_magasin()."' &&
							dlB.ref_doc_line NOT IN ( SELECT dlcdc.ref_doc_line FROM doc_lines_cdc dlcdc )
		)) res
		LEFT JOIN adresses		ad ON res.ref_adr_contact = ad.ref_adresse
		LEFT JOIN annuaire		an ON res.ref_contact = an.ref_contact
		LEFT JOIN civilites		c  ON an.id_civilite 	= c.id_civilite
		LEFT JOIN coordonnees co ON an.ref_contact 	= co.ref_contact && co.ordre = 1
		LEFT JOIN annu_client ac ON an.ref_contact = ac.ref_contact
		LEFT JOIN clients_categories cc ON ac.id_client_categ = cc.id_client_categ
		
		ORDER BY res.ref_contact";

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

$ligne= "Référence article;Libellé article;Quantité commandée;Quantité livrée;Reste à livrer;";
$ligne.="Date commande;Référence CDC;Nom du client 1;Nom du client 2;Catégorie de client;Adresse 1;Adresse 2;Adresse 3;Code Postal;";
$ligne.="Ville;Pays;Informations Adresse;tel 1;tel 2\n";

foreach ($fiches as $fiche) {
	
	$ad = explode("\n", $fiche->adresse_livraison);
	
	$adresse1 = "";
	if(count($ad)>0)
		$adresse1 = preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $ad[0]);
	
	$adresse2 = "";
	if(count($ad)>1) 
		$adresse2 = preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $ad[1]);
	
	$adresse3 = "";
	if(count($ad)>2)
		$adresse3 = preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $ad[2]);
	
	$info_adresse = "";
	if($fiche->ref_adr_contact != null)
		$info_adresse = preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->note);
	
	$ligne.= $fiche->ref_article;
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->lib_article);
	$ligne.= ";".$fiche->qte;
	$ligne.= ";".$fiche->qte_livree;
	$ligne.= ";".($fiche->qte - $fiche->qte_livree);
	$ligne.= ";".date_Us_to_Fr($fiche->date_creation_doc);
	$ligne.= ";".$fiche->ref_doc;
	
	$pos = stripos($fiche->nom_contact, "\n");
	
	if($pos == false){$pos = strlen($fiche->nom_contact);}
	else{$pos--;}
	
	//Nom du client 1;
	if($fiche->lib_civ_court != "")
	{		 $ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->lib_civ_court." ".substr($fiche->nom_contact, 0, $pos));}
	else{$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', substr($fiche->nom_contact, 0, $pos));}
	
	//Nom du client 2;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', substr($fiche->nom_contact, $pos+2));
	
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $fiche->lib_client_categ);
	$ligne.= ";".$adresse1.";".$adresse2.";".$adresse3;
	$ligne.= ";".$fiche->code_postal_livraison;
	$ligne.= ";".$fiche->ville_livraison;
	$ligne.= ";".$fiche->pays_livraison;
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $info_adresse);
	$ligne.= ";".$fiche->tel1;
	$ligne.= ";".$fiche->tel2;
	
	$ligne.= "\n";
	
	echo $ligne;
	$ligne = "";
}