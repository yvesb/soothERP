<?php
// *************************************************************************************************************
// ACCUEIL COMPTA CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

global $bdd;
/*$query = " SELECT count(*) as nb
FROM doc_fac df
LEFT JOIN factures_relances_niveaux frn ON df.id_niveau_relance = frn.id_niveau_relance
WHERE niveau_relance < 3 ";
$resultat = $bdd->query($query);
while($result = $resultat->fetchObject()){
    $nbre_non_editee = $result->nb;
}*/
$nbre_non_editee = get_nb_Factures_pour_niveau_relance(1);

/*$query = " SELECT count(*) as nb
FROM doc_fac df
LEFT JOIN factures_relances_niveaux frn ON df.id_niveau_relance = frn.id_niveau_relance
WHERE niveau_relance
BETWEEN 3
AND 12 ";
$resultat = $bdd->query($query);
while($result = $resultat->fetchObject()){
$nbre_relance = $result->nb;
}*/
$nbre_relance = get_nb_Factures_pour_niveau_relance(array(2,3,4,5,6,7,8,9,10,11,12));

/*$query = "SELECT count(*) as nb
FROM doc_fac df
LEFT JOIN factures_relances_niveaux frn ON df.id_niveau_relance = frn.id_niveau_relance
WHERE niveau_relance > 12 ";
$resultat = $bdd->query($query);
while($result = $resultat->fetchObject()){
$nbre_contentieux = $result->nb;
}*/
$nbre_contentieux = get_nb_Factures_pour_niveau_relance(array(13,14,15,16));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_situation_client2.inc.php");

?>