<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST["id_stock"])){
	echo "stock non specifié";
	exit;
}
$id_stock = $_REQUEST["id_stock"];
$ref_article = $_REQUEST["ref_article"];
$ref_agenda = $_REQUEST["ref_agenda"];
$date_deb = $_REQUEST["date_deb"];
$heure_deb = $_REQUEST["heure_deb"];
$heure_fin = $_REQUEST["heure_fin"];


global $bdd;
$query = "SELECT `qte` FROM `stocks_articles` WHERE `ref_article` = '".$ref_article."' AND `id_stock` = '".$id_stock."' ";
$res = $bdd->query($query);
if(!$retour = $res->fetchObject()){
	return false;
}
$qte_tot = $retour->qte;

$date_debut = mktime(substr($heure_deb,0,2),substr($heure_deb,3,2),0,substr($date_deb,3,2),substr($date_deb,0,2),substr($date_deb,-4));
$date_fin = mktime(substr($heure_fin,0,2),substr($heure_fin,3,2),0,substr($date_deb,3,2),substr($date_deb,0,2),substr($date_deb,-4));

$query2 = "SELECT `ref_agenda_event`, UNIX_TIMESTAMP(`date_agenda_event`) date_agenda_event, `duree_agenda_event` FROM `agendas_events` 
									WHERE `ref_agenda` = '".$ref_agenda."' 
									AND ((UNIX_TIMESTAMP(date_agenda_event) < ".$date_debut." AND UNIX_TIMESTAMP(DATE_ADD(date_agenda_event, INTERVAL `duree_agenda_event` MINUTE))  > ".$date_debut.")
									OR 	(UNIX_TIMESTAMP(date_agenda_event) >= ".$date_debut." AND UNIX_TIMESTAMP(date_agenda_event)  < ".$date_fin."))";
$res2 = $bdd->query($query2);
while($retour2 = $res2->fetchObject())
{
	$agenda_event[]=$retour2;
}
if(isset($agenda_event))
{
	$tab_quantite = array();
	for($i=0;$i<count($agenda_event);$i++)
	{
			$tempsFinCalcule = $agenda_event[$i]->date_agenda_event+($agenda_event[$i]->duree_agenda_event)*60;
			$query3 = "SELECT SUM(`quantite`) quantite FROM `agendas_events_location` WHERE `ref_agenda_event` IN (";
			$query3 .= "SELECT `ref_agenda_event` FROM `agendas_events` 
										WHERE `ref_agenda` = '".$ref_agenda."'
										AND ((UNIX_TIMESTAMP(date_agenda_event) < ".$agenda_event[$i]->date_agenda_event." AND UNIX_TIMESTAMP(DATE_ADD(date_agenda_event, INTERVAL `duree_agenda_event` MINUTE))  > ".max($agenda_event[$i]->date_agenda_event,$date_debut).")
										OR 	(UNIX_TIMESTAMP(date_agenda_event) >= ".$agenda_event[$i]->date_agenda_event." AND UNIX_TIMESTAMP(date_agenda_event)  < ". min($tempsFinCalcule,$date_fin) ." )) ";
			$query3 .= ") AND `id_stock` = '".$id_stock."' ";
			//echo $query3;
			$res3 = $bdd->query($query3);
			if($retour = $res3->fetchObject())
			{
				$tab_quantite[$i] = $retour->quantite;
				//echo $tab_quantite[$i]."<br>";
			}
	}
	$qte_tot -= max($tab_quantite);
}

echo $qte_tot;

 ?>