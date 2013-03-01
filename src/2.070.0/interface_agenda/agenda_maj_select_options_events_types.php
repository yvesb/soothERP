<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST["ref_agenda"])){
	echo "la référence de l'agenda n'est pas spécifiée";
	exit;
}
$ref_agenda = $_REQUEST["ref_agenda"];

if(isset($_REQUEST["id_agenda"])){
	setcookie("cook_agenda_selected", $_REQUEST["id_agenda"], time() + $COOKIE_LOGIN_LT , '/');
}
global $bdd;
$query = "select `agenda_couleur_rule_1` couleur1, `agenda_couleur_rule_2` couleur2, `agenda_couleur_rule_3` couleur3 from `agendas_couleurs` where `id_agenda_couleurs` in (select `id_agenda_couleurs` from `agendas` where `ref_agenda` = '".$ref_agenda."') ";
$res = $bdd->query($query);
if($retour = $res->fetchObject()){
	setcookie("cook_agenda_selectedC1", substr($retour->couleur1, 1), time() + $COOKIE_LOGIN_LT , '/');
	setcookie("cook_agenda_selectedC2", substr($retour->couleur2, 1), time() + $COOKIE_LOGIN_LT , '/');
	setcookie("cook_agenda_selectedC3", substr($retour->couleur3, 1), time() + $COOKIE_LOGIN_LT , '/');
}

$eventsTypesAvecDroitOfAg = $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsTypesAvecDroits($ref_agenda);
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT] = array();
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["libEvent"] = string;
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["affiche"] = bool;
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["droits"] = int[];

reset($eventsTypesAvecDroitOfAg);
for ($i = 0; $i< count($eventsTypesAvecDroitOfAg); $i++){
	$index = key($eventsTypesAvecDroitOfAg); 
	?><option <?php echo 'value="'.$index.'" ';if($i==$_REQUEST["cook_agenda_selected"]){ echo 'selected="selected"'; } ?> ><?php 
	echo $eventsTypesAvecDroitOfAg[$index]["libEvent"];
	?></option>
<?php next($eventsTypesAvecDroitOfAg);} ?>
