<?php
// *************************************************************************************************************
// FONCTIONS DE GESTION DES COURRIERS 
// *************************************************************************************************************


// ATTENTION, DANS BEAUCOUP DE PROCEDURE, ON TRAVAILLE AVEC DES POINTEURS !!! 


function RESSOURCE_ID_REFERENCE_TAG()
{		return 36;}

function &openAgenda($ref_agenda){ 
	$agenda = null;
	global $bdd;

	if($ref_agenda == null || $ref_agenda == "")return $agenda; // null
	
	$query = "SELECT 	ag.ref_agenda, ag.id_type_agenda
						FROM agendas ag
						WHERE ag.ref_agenda = '".$ref_agenda."'";
	
	$resultat = $bdd->query ($query);
	if (!$r = $resultat->fetchObject())
		return $agenda; // = null
		
	switch ($r->id_type_agenda) {
				case AgendaReservationRessource::_getId_type_agenda() :{
					$agenda = new AgendaReservationRessource($r->ref_agenda);
					break;}
			case AgendaContact::_getId_type_agenda() :{
					$agenda = new AgendaContact($r->ref_agenda);
					break;}
			case AgendaLoacationMateriel::_getId_type_agenda() :{
					$agenda = new AgendaLoacationMateriel($r->ref_agenda);
					break;}
			default: return $agenda; // = null
		}
		return $agenda;
}

/*
//AgendaContact 							-> params["ref_contact"]
//AgendaLoacationMateriel 		-> params["ref_article"]
//AgendaReservationRessource 	-> params["tabRessources"]
function &newAgenda($lib_agenda, $type_agenda, $params = null){ 
	$agenda = null;
	
	if( !is_numeric($type_agenda) || $lib_agenda == null || $lib_agenda == "")return $agenda; // null
		
	switch ($type_agenda) {
				case AgendaReservationRessource::_getId_type_agenda() :{
					if(!is_array(params) || !isset(params["tabRessources"]) || !is_array(params["tabRessources"]) ) return $agenda; // null
					$agenda =& AgendaReservationRessource::newAgendaReservationRessource($lib_agenda, params["ref_article"]);
					break;}
			case AgendaContact::_getId_type_agenda() :{
				if(!is_array(params) || isset(params["ref_contact"])) return $agenda; // null
					$agenda =& AgendaContact::newAgendaContact($lib_agenda, params["ref_contact"]);
					break;}
			case AgendaLoacationMateriel::_getId_type_agenda() :{
				if(!is_array(params) || isset(params["ref_article"])) return $agenda; // null
					$agenda =& AgendaLoacationMateriel::newAgendaLoacationMateriel($lib_agenda, params["ref_article"]);
					break;}
			default: return $agenda; // = null
		}
		return $agenda;
}*/

function &getAgendas($types_agenda = array()){
	
	$agendas = array();
	
	global $bdd;
	$query = 'SELECT 	ag.ref_agenda, ag.id_type_agenda
						FROM agendas ag ';
	if(count($types_agenda) > 0)
	$query.= 'WHERE ag.ag.id_type_agenda IN {"'.implode('", "', $types_agenda).'"} ';
	$query.= 'ORDER BY ag.id_type_agenda ASC';
	
	
	$resultat = $bdd->query ($query);
	while($r = $resultat->fetchObject()){
		switch ($r->id_type_agenda) {
			case AgendaReservationRessource::_getId_type_agenda() :{
					$agendas[$r->ref_agenda] = new AgendaReservationRessource($r->ref_agenda);
					break;}
			case AgendaContact::_getId_type_agenda() :{
					$agendas[$r->ref_agenda] = new AgendaContact($r->ref_agenda);
					break;}
			case AgendaLoacationMateriel::_getId_type_agenda() :{
					$agendas[$r->ref_agenda] = new AgendaLoacationMateriel($r->ref_agenda);
					break;}
		}
	}
	return $agendas;
}

/*
function &getEvents($Udate_deb = 0, $Udate_fin = 0, $duree_all_day = null){
	$events = array();
	
	global $bdd;
	$query = "SELECT 	ev.ref_agenda_event
						FROM 		agendas_events ev
						WHERE 	ev.ref_agenda_event_parent = '' ";
	if($duree_all_day != null && is_bool($duree_all_day))
	$query.="					&& ev.duree_all_day_agenda_event = '".$duree_all_day."' ";
	if($Udate_deb > 0)
	$query.= "				&& ev.date_agenda_event >= '".strftime("%Y-%m-%d %H:%M:%S", $Udate_deb)."' ";
	if($Udate_deb > 0)
	$query.= "				&& ev.date_agenda_event <= '".strftime("%Y-%m-%d %H:%M:%S", $Udate_fin)."' ";

	$resultat = $bdd->query ($query);
	while($r = $resultat->fetchObject()){
		$events[$r->ref_agenda_event] = new Event($r->ref_agenda_event);
	}
	return $events;
}
*/

//retourne la liste des événements compris entre $Udate_deb et $Udate_fin et qui se déroulent
//à partir d'une HEURE et pour une DUREE données.
//$Udate_fin et $Udate_fin sont des Timestamp
function &getEvents_atomiques($Udate_deb = 0, $Udate_fin = 0){
	$events = array();
	
	global $bdd;
	$query = "SELECT 	ev.ref_agenda_event
						FROM 		agendas_events ev
						WHERE 	ev.ref_agenda_event_parent = ''
						&&			ev.duree_all_day_agenda_event = 0
						&&			UNIX_TIMESTAMP(ev.date_agenda_event) + ev.duree_agenda_event * 60 <
										86400 * TRUNCATE(UNIX_TIMESTAMP(ev.date_agenda_event) / 86400, 0) + 82800 ";
	if($Udate_deb > 0)
	$query.= "				&& ev.date_agenda_event >= '".strftime("%Y-%m-%d %H:%M:%S", $Udate_deb)."' ";
	if($Udate_deb > 0)
	$query.= "				&& ev.date_agenda_event <= '".strftime("%Y-%m-%d %H:%M:%S", $Udate_fin)."' ";

	//echo "<br/><hr/><br/>".$query."<br/><hr/><br/>";
	$resultat = $bdd->query ($query);
	while($r = $resultat->fetchObject()){
		$events[$r->ref_agenda_event] = new Event($r->ref_agenda_event);
	}
	//echo count($events)."<br/>";
	return $events;
}

//Retourne une liste d'événements
//	Chaque événements répond l'une des clauses suivantes 
// 				ev.ref_agenda_event_parent = ''
//	&&		ev.date_agenda_event + ev.duree_agenda_event * 60 > $Udate_deb
//	&&		ev.date_agenda_event < $Udate_fin
//	&& ((	ev.date_agenda_event + ev.duree_agenda_event * 60 > 86400 * (1 + TRUNCATE(ev.date_agenda_event / 86400, 0) - 3600) )
//	|| (	ev.duree_all_day_agenda_event = true )) ";
function &getEvents_etendus($Udate_deb, $Udate_fin){
	$events = array();
	
	global $bdd;
	$query = "SELECT 	ev.ref_agenda_event
						FROM 		agendas_events ev
						WHERE 	ev.ref_agenda_event_parent = ''
							&&		UNIX_TIMESTAMP(ev.date_agenda_event) + ev.duree_agenda_event * 60 > ".$Udate_deb."
							&&		UNIX_TIMESTAMP(ev.date_agenda_event) < ".$Udate_fin."
							&&((	UNIX_TIMESTAMP(ev.date_agenda_event) + ev.duree_agenda_event * 60 >
										86400 * TRUNCATE(UNIX_TIMESTAMP(ev.date_agenda_event) / 86400, 0) + 82800
						)	|| (	ev.duree_all_day_agenda_event = ".true." ) ) ";
	
	//echo "<br/><hr/><br/>".$query."<br/><hr/><br/>";
	$resultat = $bdd->query ($query);
	while($r = $resultat->fetchObject()){
		$events[$r->ref_agenda_event] = new Event($r->ref_agenda_event);
	}
	//echo count($events)."<br/>";
	return $events;
}


//Met à jour la référence(pointer) de l'agenda de chaque Event
function maj_ref_agenda_events(&$Tagenda, &$Tevents){
	if($Tagenda == null || $Tevents == null)return false;
	
	reset($Tevents);
	for($i = 0; $i<count($Tevents); $i++){
		$index = key($Tevents);
		if(array_key_exists($Tevents[$index]->getRef_agenda(), $Tagenda)){
			$Tevents[$index]->setAgenda($Tagenda[$Tevents[$index]->getRef_agenda()]);
			$Tagenda[$Tevents[$index]->getRef_agenda()]->addEvent($Tevents[$index]);
		}
		next($Tevents);
	}
	return true;
}

/*
STRUCTURE :
resultat[id_type][lib_type]
*/
function getAllAgendaTypes(){
	$types = array();
	
	global $bdd;
	$query = "SELECT 	at.id_type_agenda, at.lib_type_agenda
						FROM 		agendas_types at
						ORDER BY at.lib_type_agenda ASC";
		
	$resultat = $bdd->query ($query);
	while($r = $resultat->fetchObject()){
		$types[$r->id_type_agenda] = array("lib_type"=>stripcslashes($r->lib_type_agenda)); 
	}
	return $types;
}


function getAllRessources_AgendaReservationRessource(){
	$ressources = array();
	
	global $bdd;
	$query = "SELECT 	r.ref_ressource, r.lib_ressource 
						FROM 		ressources r 
						ORDER BY r.lib_ressource ASC";
		
	$resultat = $bdd->query ($query);
	while($r = $resultat->fetchObject()){
		$ressources[$r->ref_ressource] = $r->lib_ressource; 
	}
	return $ressources;
}

function supprAgenda($ref_agenda){
	global $bdd;

	if($ref_agenda == null || $ref_agenda == "")return false;
	
	$query = "SELECT 	ag.ref_agenda, ag.id_type_agenda
						FROM agendas ag
						WHERE ag.ref_agenda = '".$ref_agenda."'";
	
	$resultat = $bdd->query ($query);
	if (!$r = $resultat->fetchObject())
		return false;
		
	switch ($r->id_type_agenda) {
		case AgendaReservationRessource::_getId_type_agenda() :{ return AgendaReservationRessource::_delete($r->ref_agenda);}
		case AgendaContact::_getId_type_agenda() 							:{ return AgendaContact::_delete($r->ref_agenda);}
		case AgendaLoacationMateriel::_getId_type_agenda() 		:{ return AgendaLoacationMateriel::_delete($r->ref_agenda);}
		default: return false;
	}
}


?>