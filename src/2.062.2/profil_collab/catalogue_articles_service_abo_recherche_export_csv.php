<?php
// *************************************************************************************************************
// RECHERCHE DES ABONNEMENTS D'UN ARTICLE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}

$article = new article ($_REQUEST['ref_article']);
if (!$article->getRef_article()) {
	echo "La référence de l'article est inconnue";
	exit;
}


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

$ANNUAIRE_CATEGORIES	=	get_categories();
// *************************************************
// Profils à afficher
$profils = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() == 0) { continue; }
	$profils[] = $profil;
}
unset ($profil);


// *************************************************
// Données pour le formulaire et la recherche
$form['ref_client'] = "";
if (isset($_REQUEST['ref_client'])){
	if ($_REQUEST['ref_client']!="") {
		$form['ref_client'] = trim(urldecode($_REQUEST['ref_client']));
		$search['ref_client'] = trim(urldecode($_REQUEST['ref_client']));
	}else{
		$form['ref_client'] = "";
		$search['ref_client'] = "";
	}
}

$form['etat_abo'] = "";
if (isset($_REQUEST['etat_abo'])) {
	$form['etat_abo'] = trim(urldecode($_REQUEST['etat_abo']));
	$search['etat_abo'] = trim(urldecode($_REQUEST['etat_abo']));
}

$form['id_client_categ'] = "";
if (isset($_REQUEST['id_client_categ']) && $_REQUEST['id_client_categ']!=0) {
	$form['id_client_categ'] = trim(urldecode($_REQUEST['id_client_categ']));
	$search['id_client_categ'] = trim(urldecode($_REQUEST['id_client_categ']));
}else{
		$form['id_client_categ'] = "";
		$search['id_client_categ'] = "";
}

$form['date_souscription_min'] = "";
if (isset($_REQUEST['date_souscription_min'])) {
	$form['date_souscription_min'] = trim(urldecode($_REQUEST['date_souscription_min']));
	$search['date_souscription_min'] = trim(urldecode($_REQUEST['date_souscription_min']));
}
$form['date_souscription_max'] = "";
if (isset($_REQUEST['date_souscription_max'])) {
	$form['date_souscription_max'] = trim(urldecode($_REQUEST['date_souscription_max']));
	$search['date_souscription_max'] = trim(urldecode($_REQUEST['date_souscription_max']));
}
$form['date_echeance_min'] = "";
if (isset($_REQUEST['date_echeance_min'])) {
	$form['date_echeance_min'] = trim(urldecode($_REQUEST['date_echeance_min']));
	$search['date_echeance_min'] = trim(urldecode($_REQUEST['date_echeance_min']));
}
$form['date_echeance_max'] = "";
if (isset($_REQUEST['date_echeance_max'])) {
	$form['date_echeance_max'] = trim(urldecode($_REQUEST['date_echeance_max']));
	$search['date_echeance_max'] = trim(urldecode($_REQUEST['date_echeance_max']));
}
$form['date_fin_min'] = "";
if (isset($_REQUEST['date_fin_min'])) {
	$form['date_fin_min'] = trim(urldecode($_REQUEST['date_fin_min']));
	$search['date_fin_min'] = trim(urldecode($_REQUEST['date_fin_min']));
}

$form['date_fin_max'] = "";
if (isset($_REQUEST['date_fin_max'])) {
	$form['date_fin_max'] = trim(urldecode($_REQUEST['date_fin_max']));
	$search['date_fin_max'] = trim(urldecode($_REQUEST['date_fin_max']));
}

$form['adresse_code'] = "";
if (isset($_REQUEST['adresse_code'])) {
	$form['adresse_code'] = trim(urldecode($_REQUEST['adresse_code']));
	$search['adresse_code'] = trim(urldecode($_REQUEST['adresse_code']));
}

$form['adresse_ville'] = "";
if (isset($_REQUEST['adresse_ville'])) {
	$form['adresse_ville'] = trim(urldecode($_REQUEST['adresse_ville']));
	$search['adresse_ville'] = trim(urldecode($_REQUEST['adresse_ville']));
}

$form['adresse_pays'] = "";
if (isset($_REQUEST['adresse_pays'])) {
	$form['adresse_pays'] = trim(urldecode($_REQUEST['adresse_pays']));
	$search['adresse_pays'] = trim(urldecode($_REQUEST['adresse_pays']));
}

$form['ref_article'] = ($_REQUEST['ref_article']);
$search['ref_article'] = ($_REQUEST['ref_article']);

// *************************************************
// Résultat de la recherche
$fiches = array();

// Préparation de la requete
$query_join 	= "";
$query_where 	= "";

//ref_article
if (isset($search['ref_article'])) {
	if ($query_where) { $query_where .= " && "; }
	$query_where	.= " aa.ref_article = '".($search['ref_article'])."'";
}
	
//catégorie de clients
if ($search['id_client_categ']) {
	if ($query_where) { $query_where .= " && "; }
	$query_join 	.= " LEFT JOIN annu_client ac ON a.ref_contact = ac.ref_contact  ";
	$query_where	.= "ac.id_client_categ  = '".$search['id_client_categ']."'";
}

//adresse 1
if ($search['adresse_code']) {
	if ($query_where) { $query_where .= " && "; }
	$query_where	.= "ad.code_postal LIKE '".$search['adresse_code']."%'";
}

//adresse 2
if ($search['adresse_ville']) {
	if ($query_where) { $query_where .= " && "; }
	$query_where	.= "ad.ville = '".$search['adresse_ville']."'";
}

//adresse 3
if ($search['adresse_ville'] || $search['adresse_code']) { 
	$query_join_count 	.= " LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  ";
}

//adresse 4
if ($search['adresse_pays']) {
	$query_join 	.= " LEFT JOIN pays p ON ad.id_pays = p.id_pays  ";
	if ($query_where) { $query_where .= " && "; }
	$query_where	.= "p.pays = '".$search['adresse_pays']."'";
}

// etat abonnement :
// 0 : TOUS
// 1 : Abonnements en cours
// 2 : Abonnements échus, à renouveller
// 3 : Abonnements terminés
if ($search['etat_abo']) {
	if ($query_where) { $query_where .= " && "; }
	// 1 : Abonnements en cours
	if ($search['etat_abo'] == 1) { $query_where	.= " aa.date_echeance > NOW() ";}
	// 2 : Abonnements échus, à renouveller
	if ($search['etat_abo'] == 2) { $query_where	.= " (aa.fin_abonnement > NOW() || aa.fin_abonnement = '0000-00-00 00:00:00') && aa.date_echeance < NOW()  ";}
	// 3 : Abonnements terminés
	if ($search['etat_abo'] == 3) { $query_where	.= " aa.fin_abonnement < NOW() && aa.fin_abonnement != '0000-00-00 00:00:00'";}
}

//date de souscription
if($search['date_souscription_min']){
	$query_where	.= " && aa.date_souscription > '".date_Fr_to_Us($search['date_souscription_min'])." 00:00:00'";
}
if($search['date_souscription_max']){
	$query_where	.= " && aa.date_souscription < '".date_Fr_to_Us($search['date_souscription_max'])." 00:00:00'";
}

//date de echeance
if($search['date_echeance_min']){
	$query_where	.= " && aa.date_echeance > '".date_Fr_to_Us($search['date_echeance_min'])." 00:00:00'";
}

if($search['date_echeance_max']){
	$query_where	.= " && aa.date_echeance < '".date_Fr_to_Us($search['date_echeance_max'])." 00:00:00'";
}

//date de fin
if($search['date_fin_min']){
	$query_where	.= " && aa.fin_abonnement > '".date_Fr_to_Us($search['date_fin_min'])." 00:00:00'";
}
if($search['date_fin_max']){
	$query_where	.= " && aa.fin_abonnement < '".date_Fr_to_Us($search['date_fin_max'])." 00:00:00'";
}

//ref_client
if ($search['ref_client']) {
	if ($query_where) { $query_where .= " && "; }
	$query_where	.= "a.ref_contact = '".addslashes($search['ref_client'])."'";
}
	
if (!$query_where) { 
	$query_where = 1; 
}

//ad.text_adresse, ad.code_postal, ad.ville, ad.ordre, co.tel1, co.tel2, co.fax,  co.ordre, email, url, si.ordre
// Recherche
$query = "SELECT 	an.ref_contact, c.lib_civ_court, an.nom, an.id_categorie, ar.lib_article,
									aa.ref_article, aa.id_abo, aa.date_souscription, aa.date_echeance , aa.date_preavis, aa.fin_engagement, aa.fin_abonnement, 
									ad.text_adresse, ad.code_postal, ad.ville, ad.note, p.pays, co.tel1, co.tel2, co.fax, co.email, cc.lib_client_categ
					FROM articles_abonnes 	aa
						LEFT JOIN articles 		ar ON ar.ref_article	= aa.ref_article 
						LEFT JOIN annuaire 		an ON an.ref_contact 	= aa.ref_contact 
						LEFT JOIN civilites 	c  ON an.id_civilite 	= c.id_civilite
						LEFT JOIN coordonnees co ON an.ref_contact 	= co.ref_contact && co.ordre = 1
						LEFT JOIN adresses 		ad ON an.ref_contact 	= ad.ref_contact  
						LEFT JOIN pays				p  ON p.id_pays 			= ad.id_pays
						LEFT JOIN sites_web 	si ON an.ref_contact 	= si.ref_contact && si.ordre = 1
						LEFT JOIN annu_client ac ON an.ref_contact = ac.ref_contact
						LEFT JOIN clients_categories cc ON ac.id_client_categ = cc.id_client_categ
						".$query_join."
					WHERE ".$query_where." 
					GROUP BY aa.id_abo
					ORDER BY aa.date_echeance DESC, an.nom ASC";

//echo "<br/><hr/><br/>".nl2br($query)."<br/><hr/><br/>"; 

$resultat = $bdd->query($query);

header('Pragma: public'); 
header('Expires: 0'); 
header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
header('Content-Type: application/force-download'); 
header('Content-Type: application/octet-stream'); 
header('Content-Type: application/download'); 
header('Content-Type: application/csv; name="listedesabonnes'.urlencode(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", (($article->getLib_article())))))).'.csv"');
header('Content-Disposition: attachment; filename=listedesabonnes'.urlencode(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", (($article->getLib_article())))))).'.csv;'); 

$ligne = "Référence article;Libellé article;Etat;Date de souscription;Date d'écheance;Date de préavis;Date de fin d'engagement;Date de fin d'abonnement;";
$ligne.= "Référence contact;Nom du client 1;Nom du client 2;Catégorie de client;Adresse 1;Adresse 2;Adresse 3;Code Postal;Ville;Pays;Informations Adresse;tel 1;tel 2;fax;email\n";
echo $ligne;

while ($fiche = $resultat->fetchObject()) {
	$ligne = "";	//il est plus rapide d'utiliser une variable "ligne" que de faire des "echo" directements
	
	//Référence article;
	$ligne.=$fiche->ref_article;
	
	//Libellé article;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->lib_article);
	
	//Etat;
	$etat = "";
	if ($fiche->date_echeance > date("Y-m-d H:i:s", time())) { $etat.=";en cours ";}
	if ($fiche->fin_abonnement > date("Y-m-d H:i:s", time()) && $fiche->date_echeance < date("Y-m-d H:i:s", time())) { $etat.=";à renouveller ";}
	if ($fiche->fin_abonnement < date("Y-m-d H:i:s", time()) && $fiche->fin_abonnement != '0000-00-00 00:00:00') { $etat.=";expiré ";}
	if ($fiche->date_preavis != '0000-00-00 00:00:00')
	{ $etat.=";préavis déposé ";}
	$ligne.= $etat;
	//Date de souscription;
	$ligne.=";".date_Us_to_Fr($fiche->date_souscription);
	
	//Date d'écheance;
	$ligne.=";".date_Us_to_Fr($fiche->date_echeance);
	
	//Date de préavis;
	if ($fiche->date_preavis == '0000-00-00 00:00:00' || $fiche->date_preavis == '0000-00-00')
	{		$ligne.=";";}
	else{$ligne.=";".date_Us_to_Fr($fiche->date_preavis);}
	
	//Date de fin d'engagement;
	if ($fiche->fin_engagement == '0000-00-00 00:00:00' || $fiche->fin_engagement == '0000-00-00')
	{		$ligne.=";";}
	else{$ligne.=";".date_Us_to_Fr($fiche->fin_engagement);}
	
	//Date de fin d'abonnement;
	if ($fiche->fin_abonnement == '0000-00-00 00:00:00' || $fiche->fin_abonnement == '0000-00-00')
	{		$ligne.=";";}
	else{$ligne.=";".date_Us_to_Fr($fiche->fin_abonnement);}
	
	//Référence contact;
	$ligne.=";".$fiche->ref_contact;

	$pos = stripos($fiche->nom, "\n");
	if($pos == false){$pos = strlen($fiche->nom);}
	else{$pos--;}
	
	//Nom du client 1;
	if($fiche->lib_civ_court)
	{		 $ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->lib_civ_court." ".substr($fiche->nom, 0, $pos));}
	else{$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', substr($fiche->nom, 0, $pos));}
	
	//Nom du client 2;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', substr($fiche->nom, $pos+2));
	
	//Catégorie de client
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $fiche->lib_client_categ);
	
	$ad = explode("\n", $fiche->text_adresse);
	
	$adresse1 = "";
	if(count($ad)>0)
		$adresse1 = preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $ad[0]);
	
	$adresse2 = "";
	if(count($ad)>1) 
		$adresse2 = preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $ad[1]);
	
	$adresse3 = "";
	if(count($ad)>2)
		$adresse3 = preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', $ad[2]);
	
	//Adresse 1, 2 et 3
	$ligne.= ";".$adresse1.";".$adresse2.";".$adresse3;

	//Code Postal;
	$ligne.= ";".$fiche->code_postal;
	
	//Ville;
	$ligne.= ";".$fiche->ville;
	
	//Pays;
	$ligne.= ";".$fiche->pays;
	
	//Informations Adresse;
	if($fiche->ref_contact != null)
	{	 	 $ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->note);}
	else{$ligne.= ";";}
	
	//tel1, tel2 et fax
	$ligne.= ";".$fiche->tel1.";".$fiche->tel2.";".$fiche->fax;
	
	//email
	$ligne.= ";".$fiche->email;
	
	echo $ligne."\n";
}
	
?>