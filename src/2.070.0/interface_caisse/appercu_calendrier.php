<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************
require_once ("_dir.inc.php");
require_once ("_profil.inc.php");
require_once ($DIR."_session.inc.php");

// *************************************************************************************************************
// Controle
// *************************************************************************************************************

//Reference de l'id
if (!isset($_REQUEST['ref_date'])) 
{
	echo "La référence de la date n'est pas précisée";
	exit;
}

//La date 
if(isset($_REQUEST["Udate_mini_calendrier"]))
{
	$Udate_mini_calendrier = intval($_REQUEST["Udate_mini_calendrier"]/1000);
}
else
	$Udate_mini_calendrier = time();

$Udate_selected = 0;
if(!empty($_REQUEST["selected"]))
    $Udate_selected = $_REQUEST["selected"];

$date_format = (!empty($_REQUEST['date_format']))? $_REQUEST['date_format'] : "%d-%m-%Y";
// ******************************
// Traitement de la date renvoyée
// ******************************
$Udate_now = time();
if(isset($_REQUEST["date_min"]))
$min=$_REQUEST["date_min"];
else
$min='';
if(isset($_REQUEST["date_max"]))
$max=$_REQUEST["date_max"];
else
$max='';

$date_min=strtotime($min);
$date_max=strtotime($max);

$Udate_fdm = mktime(0, 0, 0, strftime("%m", $Udate_mini_calendrier), 01, strftime("%Y", $Udate_mini_calendrier));
$Udate_ldm = strtotime("+1 month", $Udate_fdm)-86400;// 86400 = 1 jour



$d = strftime("%w", $Udate_fdm)+0;
if($d == 0){ //DIMANCHE
	$Udate_first_monday =  $Udate_fdm - 6*86400;
}else{ //AUTRES JOURS : 1 = Lundi; 6 = Samdedi
	$Udate_first_monday =  $Udate_fdm - ($d-1)*86400;
}
unset($d);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_appercu_calendrier.inc.php");

?>