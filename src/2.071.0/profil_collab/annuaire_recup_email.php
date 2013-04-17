<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] RECHERCHE D'UNE FICHE DE CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


// *************************************************
// Données pour le formulaire && la requete

$nb_fiches = 0;

$form['cp'] = "";
if (isset($_REQUEST['cp'])) {
	$form['cp'] = trim(urldecode($_REQUEST['cp']));
	$search['cp'] = trim(urldecode($_REQUEST['cp']));
}

// *************************************************
// Résultat de la recherche
$fiches = array();
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= "date_archivage IS NULL";


$i = 0;
	// Recherche
	$query = "SELECT a.ref_contact, email
						FROM annuaire a 
							LEFT JOIN civilites c ON a.id_civilite = c.id_civilite 
							LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact 
							LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact 
							LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact 
							".$query_join."
						WHERE ".$query_where." && ad.code_postal = '".$search['cp']."'";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
	if ($fiche->email != "" && $fiche->email != " ")  {
		echo $fiche->email."; " ;
		$i++;
		if ($i == 39) {
		echo "<br /><br />";
		$i=0;
	}
	}
	
	// $fiches[] = $fiche; 
	 
	 }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>