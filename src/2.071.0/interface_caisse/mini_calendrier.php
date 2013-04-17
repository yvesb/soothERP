<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require_once ("_dir.inc.php");
require_once ("_profil.inc.php");
require_once ($DIR."_session.inc.php"); 

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if(!isset($_REQUEST["Udate_mini_calendrier"])){
	echo "la date au format timestamp UNIX n'est pas spécifié";
	exit;
}

$Udate_mini_calendrier = intval($_REQUEST["Udate_mini_calendrier"]/1000);
$Udate_now = time();

$Udate_fdm = mktime(0, 0, 0, strftime("%m", $Udate_mini_calendrier), 01, strftime("%Y", $Udate_mini_calendrier));
$Udate_ldm = strtotime("+1 month", $Udate_fdm)-86400;// 86400 = 1 jour

$d = strftime("%w", $Udate_fdm)+0;
if($d == 0){ //DIMANCHE
	$Udate_first_monday =  $Udate_fdm - 6*86400;
}else{ //AUTRES JOURS : 1 = Lundi; 6 = Samdedi
	$Udate_first_monday =  $Udate_fdm - ($d-1)*86400;
}
unset($d);

include ($THIS_DIR."pages/page_mini_calendrier.inc.php");

?>