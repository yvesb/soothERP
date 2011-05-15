<?php
// *************************************************************************************************************
// RECHERCHE DES EVENEMENTS DES CONTACTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************



// *************************************************
// Données pour le formulaire && la requete
$form['orderby'] = $search['orderby'] = "date_event";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

$form['id_comm_event_type'] = "";
if (isset($_REQUEST['id_comm_event_type']) && $_REQUEST['id_comm_event_type']) {
	$form['id_comm_event_type'] = trim(urldecode($_REQUEST['id_comm_event_type']));
	$search['id_comm_event_type'] = trim(urldecode($_REQUEST['id_comm_event_type']));
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= "";

	
	// Profils
	if (isset($search['id_comm_event_type'])) { 
		if ($query_where) { $query_where .= " && "; }
		if (!$query_where) { $query_where .= " WHERE "; }
		$query_where 	.= "ce.id_comm_event_type = '".$search['id_comm_event_type']."'";
	}


	// Recherche
	$query = "SELECT 	c.lib_civ_court, a.nom, 
										text_adresse, ad.code_postal, ad.ville, p.pays, ad.note,
										tel1, tel2, fax, email, url,
										ce.id_comm_event, ce.date_event, ce.duree_event, ce.ref_user, ce.ref_contact, ce.id_comm_event_type, ce.texte, ce.date_rappel,
										u.pseudo, cet.lib_comm_event_type
						FROM comm_events ce 
							LEFT JOIN users 			u  ON ce.ref_user = u.ref_user
							LEFT JOIN annuaire		a  ON ce.ref_contact = a.ref_contact
							LEFT JOIN comm_events_types cet ON ce.id_comm_event_type = cet.id_comm_event_type
							LEFT JOIN civilites		c  ON a.id_civilite = c.id_civilite 
							LEFT JOIN adresses		ad ON a.ref_contact = ad.ref_contact && ad.ordre = 1
							LEFT JOIN pays				p  ON p.id_pays 		= ad.id_pays
							LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact && co.ordre = 1
							LEFT JOIN sites_web 	si ON a.ref_contact = si.ref_contact 
							".$query_join."
						 ".$query_where." 
						GROUP BY ce.id_comm_event
						ORDER BY ".$search['orderby']." ".$search['orderorder']." ";
						
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

header('Pragma: public'); 
header('Expires: 0'); 
header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
header('Content-Type: application/force-download'); 
header('Content-Type: application/octet-stream'); 
header('Content-Type: application/download'); 
header('Content-Type: application/php; name="recherche_evenements.csv"');
header('Content-Disposition: attachment; filename=recherche_evenements.csv;'); 

echo "Référence contact;Civilite;Nom 1;Nom 2;Adresse 1;Adresse 2;Adresse 3;Code postal;Ville;Pays;Informations Adresse;telephone 1;telephone 2;fax;email;url;description;Date;Heure;Durée;Utilisateur;Type\n";

foreach ($fiches as $fiche) {
	//Référence contact;
	$ligne =$fiche->ref_contact;
	
	$ligne.=";".$fiche->lib_civ_court;
	
	$pos = stripos($fiche->nom, "\n");
	if($pos == false){$pos = strlen($fiche->nom);}
	else{$pos--;}
	
	//Nom du client 1;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', substr($fiche->nom, 0, $pos));
	
	//Nom du client 2;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ' ', substr($fiche->nom, $pos+2));
	
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
	
	//Code postal
	$ligne.=";".$fiche->code_postal;
	
	//Ville
	$ligne.=";".$fiche->ville;
	
	//Pays;
	$ligne.= ";".$fiche->pays;
	
	//Informations Adresse
	$ligne.= ";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->note);
	
	//tel1, tel2 et fax
	$ligne.=";".$fiche->tel1;
	$ligne.=";".$fiche->tel2;
	$ligne.=";".$fiche->fax;
	
	$ligne.=";".$fiche->email;
	$ligne.=";".$fiche->url;
	$ligne.=";".preg_replace('/\\r\\n|\\n|\\r|;/i', ',', $fiche->texte);
	
	//Date et heure Event
	$ligne.=";".date_Us_to_Fr($fiche->date_event);
	$ligne.=";".getTime_from_date($fiche->date_event);
	$ligne.=";".substr($fiche->duree_event,0,5);
	
	//Pseudo
	$ligne.=";".$fiche->pseudo;
	
	//Event type
	$ligne.=";".$fiche->lib_comm_event_type;
	
	echo $ligne."\n";
}

?>