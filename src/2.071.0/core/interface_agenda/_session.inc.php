<?php

// *************************************************************************************************************
// 
// *************************************************************************************************************

function initSESSIONAgenda(){

	$_SESSION["agenda"] = array();
	$_SESSION["agenda"]["GestionnaireAgendas"] 		= new GestionnaireAgendas($_SESSION['user']);
	$_SESSION["agenda"]["GestionnaireEvenements"] = new GestionnaireEvenements($_SESSION['user'], $_SESSION["agenda"]["GestionnaireAgendas"]);
	
	$_SESSION["agenda"]["vision_jour"] = array();
	$_SESSION["agenda"]["vision_jour"]["HAUTEUR_DEMIE_HEURE"] = 20; 				//en px
	$_SESSION["agenda"]["vision_jour"]["HEURE_DE_DEPART"] 		= 16 * 20;		//en px 

	$_SESSION["agenda"]["vision_semaine"] = array();
	$_SESSION["agenda"]["vision_semaine"]["HAUTEUR_DEMIE_HEURE"] 	= 20;				//en px
	$_SESSION["agenda"]["vision_semaine"]["HEURE_DE_DEPART"] 			= 16 * 20;	//en px 

	$_SESSION["agenda"]["vision_mois"] = array();
	$_SESSION["agenda"]["vision_mois"]["HAUTEUR_JOUR"] = 20;									//en px
	$_SESSION["agenda"]["vision_mois"]["NB_ENVENTS_BY_DAY"] = 5;
	$_SESSION["agenda"]["vision_mois"]["NB_SEMAINE"] = 5;
	
}

function clearSESSIONagenda(){
	unset($_SESSION["agenda"]);
}

// *************************************************************************************************************
// 
// *************************************************************************************************************


if(!isset($_SESSION["agenda"])){
	initSESSIONAgenda();
}

initSESSIONAgenda();

//echo "<PRE>";
//
//var_dump($_SESSION["agenda"]["GestionnaireAgendas"]);
//echo "<br />--------------------------------------------------------------<br />";
//echo 			 "--------------------------------------------------------------<br />";
//echo 			 "--------------------------------------------------------------<br />";
//echo 			 "--------------------------------------------------------------<br />";
//echo 			 "--------------------------------------------------------------<br />";
//
//var_dump($_SESSION["agenda"]["GestionnaireEvenements"]);
//
//exit;

$event_duree_moyenne = 1800;//1800 sec = 30 min

?>