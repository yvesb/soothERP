<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************
require ("_dir.inc.php");
include ("./_redirection_extension.inc.php");

require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// RECUPERATION DES VARIABLES
// *************************************************************************************************************

if(!isset($_REQUEST["Udate_used"])){
	echo "la date au format timestamp UNIX n'est pas spécifié";
	exit;
}
$Udate_used = intval($_REQUEST["Udate_used"]/1000);


// *************************************************************************************************************
// TRAITEMENT
// *************************************************************************************************************

$array_Udate_used = getdate($Udate_used);
//$Udate_fdm = date du 1er jour du mois 01/MM/YYYY à 00h00
$Udate_fdm = mktime( 0,  0,  0, $array_Udate_used["mon"]  , 1, $array_Udate_used["year"]);
//$Udate_ldm = date du dernier jour du mois 28/02/YYYY ou 29/02/YYYY ou 30/MM/YYYY ou 31/MM/YYYY à 00h00
$Udate_ldm = mktime(23, 59, 59, $array_Udate_used["mon"]+1, 0, $array_Udate_used["year"]);

$Udate_now 	= time();
$numSemaine = strftime("%W", $Udate_fdm);

unset($array_Udate_used);

$nb_jour_en_moins = strftime("%w", $Udate_fdm)-1;
if($nb_jour_en_moins == -1)//DIMANCHE
{	 $nb_jour_en_moins =   6;}
$array_Udate_used = getdate($Udate_fdm);
$Udate_first_monday = mktime( 0,  0,  0, $array_Udate_used["mon"], $array_Udate_used["mday"]-$nb_jour_en_moins, $array_Udate_used["year"]);
unset($array_Udate_used, $nb_jour_en_moins);


$nb_jour_en_plus = 7-strftime("%w", $Udate_ldm);
if($nb_jour_en_plus == 7)//DIMANCHE
{	 $Udate_last_sunday = $Udate_ldm;}
else{
	$array_Udate_used = getdate($Udate_ldm);
	$Udate_last_sunday = mktime( 23,  59,  59, $array_Udate_used["mon"], $array_Udate_used["mday"]+$nb_jour_en_plus, $array_Udate_used["year"]);
	unset($array_Udate_used);
}
unset($nb_jour_en_plus);

//echo strftime("Udate_ldm : %Y-%m-%d %H:%M:%S %w", $Udate_ldm);
//echo strftime("Udate_last_sunday : %Y-%m-%d %H:%M:%S %w", $Udate_last_sunday);

// *********** Récupération des événements
	$joursMois = array();
	$Udate_tmp_deb = $Udate_first_monday;
	$s = 0;
	
	while ($Udate_tmp_deb < $Udate_last_sunday){
		$joursMois[] = array();
		for($j = 0; $j<7; $j++){
			$Udate_tmp_fin = strtotime("+1 day", $Udate_tmp_deb);
			$joursMois[$s][] =& $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsGrilleAvecDroit($Udate_tmp_deb, $Udate_tmp_fin-1);
			$Udate_tmp_deb = $Udate_tmp_fin;
		}
		$s++;
	}
	
	unset($Udate_tmp_deb, $Udate_tmp_fin);
	$events_etendus = array();
// *****************************************

$droitsUserAgendas=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),42);
$droitsUserEvents=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),43);
	
$gride_is_locked = $_SESSION["agenda"]["GestionnaireEvenements"]->gride_is_locked();

//echo "<PRE>";
//var_dump($joursMois);
//echo "</PRE>";

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_view_mois.inc.php");


?>