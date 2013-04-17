<?php

// *************************************************************************************************************
// CLASSE GestionnaireEvenements 
// *************************************************************************************************************
abstract class GestionnaireEvenementsStd{

	//voir dans la BD la table : AGENDA_EVENTS
	//$eventsTypesPermissions[ID_TYPE_EVENT] = array();
	//$eventsTypesPermissions[ID_TYPE_EVENT] = int permission
	private $eventsTypesPermissions;						//liste des Events
	private $user;
	private $gestionnaireAgendas;
	
	//public GestionnaireEvenementsStd(User, GestionnaireAgendas)
	public function __construct(&$user, &$gestionnaireAgendas){
		$this->user =& $user;
		$this->gestionnaireAgendas =& $gestionnaireAgendas;
		$this->chargerEventsTypesAvecDroits();
	}
	
	//public bool __call(string, array)
	public function __call($method,$args){
		return true;
	}
	
	  // *************************************************************************************************************
	 // Getters & Setters
	// *************************************************************************************************************
	
	//public &array getEventsTypesPermissions()	
	public function &getEventsTypesPermissions(){
		return $this->eventsTypesPermissions;
	}
	
	//protected void setEventsTypesPermissions(&array)
	protected function setEventsTypesPermissions(&$eventsTypesPermissions){
		$this->eventsTypesPermissions =& $eventsTypesPermissions;
	}
	
	//public &User getUser(){
	public function &getUser(){
		return $this->user;
	}
	
	//protected void setUser(&User){
	protected function setUser(&$user){
		$this->user =& $user;
	}
	
	//public &GestionnaireAgendas getGestionnaireAgendas()
	public function &getGestionnaireAgendas(){
		return $this->gestionnaireAgendas;
	}
	
	//protected void getGestionnaireAgendas(&GestionnaireAgendas)
	protected function setGestionnaireAgendas(&$gestionnaireAgendas){
		$this->gestionnaireAgendas =& $gestionnaireAgendas;
	}
	
	  // *************************************************************************************************************
	 // 
	// *************************************************************************************************************
	
	//public void chargerEventsTypesAvecDroits()
	public function chargerEventsTypesAvecDroits(){
		$this->eventsTypesPermissions = array();
		
		global $bdd;		
		$resultat = $bdd->query ($this->queryChargerEventsTypesAvecDroits());
		
		while ($r = $resultat->fetchObject()){
			$this->eventsTypesPermissions[intval($r->id_type_event)] = intval($r->id_permission);
		}
	}
	
	//protected string queryChargerEventsTypesAvecDroits()
	protected function queryChargerEventsTypesAvecDroits(){
		return "SELECT 		et.id_type_event, 9999 as id_permission
						FROM			agendas_events_types et
						ORDER BY	et.id_type_event ASC";
	}

		// *************************************************************************************************************
	 // 
	// *************************************************************************************************************
	
	//$eventsTypessAvecDroit[ID_TYPE_EVENT] = array();
	//$eventsTypessAvecDroit[ID_TYPE_EVENT]["libEvent"] = string;
	//$eventsTypessAvecDroit[ID_TYPE_EVENT]["affiche"] = bool;
	//$eventsTypessAvecDroit[ID_TYPE_EVENT]["droits"] = int[];
	
	//public array getEventsTypesAvecDroits(string/int/null, int/null)
	public function getEventsTypesAvecDroits($agenda = null, $permissions = null){
		if(is_null($agenda))				//aucun agenda n'est demandé
		{			return $this->getEventsTypesOfAllTypeAgendaAvecDroits($permissions);}
		elseif(is_string($agenda))	//une ref agenda est passée en parametre
		{			return $this->getEventsTypesOfAgendaAvecDroits($agenda, $permissions);}
		elseif(is_numeric($agenda))	//un type d'agenda est passé en parametre
		{			return $this->getEventsTypesOfTypeAgendaAvecDroits($agenda, $permissions);}
		else{	return array();}
	}
	
	//$eventsTypes[ID_TYPE_EVENT] = array();
	//$eventsTypes[ID_TYPE_EVENT]["libEvent"] = string;
	//$eventsTypes[ID_TYPE_EVENT]["affiche"] = bool;
	//$eventsTypes[ID_TYPE_EVENT]["droits"] = int;
	
	//protected array getEventsTypesOfAllTypeAgendaAvecDroits(int/null)
	protected function getEventsTypesOfAllTypeAgendaAvecDroits($permissions = null){
		$eventsTypes = array();
		
		global $bdd;
		$resultat = $bdd->query ($this->queryGetEventsTypesOfAllTypeAgendaAvecDroits($permissions));

		while ($r = $resultat->fetchObject()){
			$tmp_id_type_event = intval($r->id_type_event);
			$eventsTypes[$tmp_id_type_event] = array();
			$eventsTypes[$tmp_id_type_event]["libEvent"] = $r->lib_type_event;
			$eventsTypes[$tmp_id_type_event]["id_type_agenda"] = intval($r->id_type_agenda);
			$eventsTypes[$tmp_id_type_event]["affiche"] = $r->affiche;
			$eventsTypes[$tmp_id_type_event]["droits"] = intval($r->id_permission);
		}
		return $eventsTypes;
	}
	
	//protected string queryGetEventsTypesOfAllTypeAgendaAvecDroits(int/null)
	protected function queryGetEventsTypesOfAllTypeAgendaAvecDroits($permissions = null){
		return "SELECT 		et.id_type_event, IFNULL(p.affiche, 0) as affiche, 9999 as id_permission, et.lib_type_event, et.id_type_agenda
						FROM			agendas_events_types et
						LEFT JOIN agendas_users_events_type_affiche_permissions p ON et.id_type_event = p.id_type_event && p.ref_user = '".$this->user->getRef_user()."'
						ORDER BY	p.id_type_event";
	}
	
	// *************************************************************************************
		
	//$eventsTypes[ID_TYPE_EVENT] = array();
	//$eventsTypes[ID_TYPE_EVENT]["libEvent"] = string;
	//$eventsTypes[ID_TYPE_EVENT]["affiche"] = bool;
	//$eventsTypes[ID_TYPE_EVENT]["droits"] = int;
	
	//protected array getEventsTypesOfTypeAgendaAvecDroits(int, int/null)
	protected function getEventsTypesOfTypeAgendaAvecDroits($id_type_agenda, $permissions = null){
		$eventsTypes = array();
		
		global $bdd;
		$resultat = $bdd->query ($this->queryGetEventsTypesOfTypeAgendaAvecDroits($id_type_agenda, $permissions));

		while ($r = $resultat->fetchObject()){
			$tmp_id_type_event = intval($r->id_type_event);
			$eventsTypes[$tmp_id_type_event] = array();
			$eventsTypes[$tmp_id_type_event]["libEvent"] = $r->lib_type_event;
			$eventsTypes[$tmp_id_type_event]["id_type_agenda"] = intval($r->id_type_agenda);
			$eventsTypes[$tmp_id_type_event]["affiche"] = $r->affiche;
			$eventsTypes[$tmp_id_type_event]["droits"] = intval($r->id_permission);
		}
		return $eventsTypes;
	}
	
	//protected string queryGetEventsTypesOfTypeAgendaAvecDroits(int, int/null)
	protected function queryGetEventsTypesOfTypeAgendaAvecDroits($id_type_agenda, $permissions = null){		
		return "SELECT 		et.id_type_event, p.affiche, 9999 as id_permission, et.lib_type_event, et.id_type_agenda
						FROM			agendas_events_types et
						LEFT JOIN agendas_users_events_type_affiche_permissions p ON et.id_type_event = p.id_type_event		
						WHERE 		p.ref_user = '".$this->user->getRef_user()."'
						&&				et.id_type_agenda = ".$id_type_agenda."
						ORDER BY	p.id_type_event";
	}
	
	// *************************************************************************************
	
	//$eventsTypes[ID_TYPE_EVENT] = array();
	//$eventsTypes[ID_TYPE_EVENT]["libEvent"] = string;
	//$eventsTypes[ID_TYPE_EVENT]["affiche"] = bool;
	//$eventsTypes[ID_TYPE_EVENT]["droits"] = int;
	
	//protected array getEventsTypesOfAgendaAvecDroits(string, int/null)
	protected function getEventsTypesOfAgendaAvecDroits($ref_agenda, $permissions = null){
		$eventsTypes = array();
		
		$query = "SELECT 		et.id_type_event, et.lib_type_event, et.id_type_agenda, IFNULL(ap.affiche, 0) as affiche
							FROM			agendas_events_types et
							LEFT JOIN agendas_users_events_type_affiche_permissions ap ON ap.id_type_event = et.id_type_event
							LEFT JOIN agendas a ON a.id_type_agenda = et.id_type_agenda
							WHERE 		a.ref_agenda = '".$ref_agenda."'
							ORDER BY	et.id_type_event";
		
		global $bdd;
		$resultat = $bdd->query ($query);

		while ($r = $resultat->fetchObject()){
			$tmp_id_type_event = intval($r->id_type_event);
			$eventsTypes[$tmp_id_type_event] = array();
			$eventsTypes[$tmp_id_type_event]["libEvent"] = $r->lib_type_event;
			$eventsTypes[$tmp_id_type_event]["id_type_agenda"] = intval($r->id_type_agenda);
			$eventsTypes[$tmp_id_type_event]["affiche"] = intval($r->affiche);
			$eventsTypes[$tmp_id_type_event]["droits"] = 9999;
		}
		return $eventsTypes;
	}
		
	// *************************************************************************************
	
	//public bool gride_is_locked()
	public function gride_is_locked(){
		return false;
	}
	
	  // *************************************************************************************************************
	 // 
	// *************************************************************************************************************
	
	//retourne la liste des événements compris entre $Udate_deb et $Udate_fin et qui se déroulent
	//à partir d'une HEURE et pour une DUREE données.
	
	//public array &getEventsGrilleAvecDroit(Timestamp = 0, 	Timestamp = 0)
	public function &getEventsGrilleAvecDroit($Udate_deb = 0, $Udate_fin = 0){
		$events = array();
		
		global $bdd;
		$resultat = $bdd->query ($this->queryGetEventsGrilleAvecDroit($Udate_deb, $Udate_fin));
		
		$last_ref_agenda = "";
		$last_events_types_permission = null;
		
		while($r = $resultat->fetchObject()){
			if($last_ref_agenda != $r->ref_agenda){
				$last_ref_agenda = $r->ref_agenda;
				$last_events_types_permission = $this->gestionnaireAgendas->getAgendasPermissions($last_ref_agenda)->GetEvents_types_permission();
			}
			if(isset($last_events_types_permission[intval($r->id_type_event)]) && $last_events_types_permission[intval($r->id_type_event)] == 0)
			{		continue;}// Pour cet agenda, on a aucun doit sur ce type d'événement, donc, on ignore cet événement
			$events[$r->ref_agenda_event] = new Event($r->ref_agenda_event);
		}
		unset($last_ref_agenda, $last_events_types_permission);

		return $events;
	}
	
	//protected string queryGetEventsGrilleAvecDroit(Timestamp = 0, 	Timestamp = 0)
	protected function queryGetEventsGrilleAvecDroit($Udate_deb = 0, $Udate_fin = 0){
		/*$query = "SELECT 		e.ref_agenda_event, e.id_type_event, e.ref_agenda
							FROM			agendas_users_agendas_affichage uaa
							LEFT JOIN agendas_events e ON e.ref_agenda = uaa.ref_agenda
							LEFT JOIN agendas_users_events_type_affiche_permissions etap ON etap.id_type_event = e.id_type_event
							WHERE 	uaa.affiche = 1
							&&			etap.affiche = 1
							&&			e.ref_agenda_event_parent IS NULL
							&&			e.affichage_journee = 0
							&&			UNIX_TIMESTAMP(e.date_agenda_event) + e.duree_agenda_event * 60 <
											86400 * TRUNCATE(UNIX_TIMESTAMP(e.date_agenda_event) / 86400, 0) + 82800 ";*/
		$query = "SELECT e.ref_agenda_event, e.id_type_event, e.ref_agenda FROM agendas_events e 
						LEFT JOIN agendas_users_agendas_affichage auaa ON auaa.ref_agenda = e.ref_agenda
						WHERE auaa.affiche = 1 && auaa.ref_user='".$_SESSION['user']->getRef_user()."' ";
		if($Udate_deb > 0)
		{$query.="&&			e.date_agenda_event >= '".strftime("%Y-%m-%d %H:%M:%S", $Udate_deb)."' ";}
		if($Udate_deb > 0)
		{$query.="&&			e.date_agenda_event <= '".strftime("%Y-%m-%d %H:%M:%S", $Udate_fin)."' ";}
		$query.= "ORDER BY e.date_agenda_event, e.ref_agenda, e.id_type_event, e.ref_agenda_event";
		
		return $query;
	}
	
	//public bool canBeShown(Event / string)
	public function canBeShown(&$event){
		if(is_string($event)){
			$ref_event = $event;
		}elseif($event instanceof Event){
			$ref_event = $event->getRef_event($this);
			if($ref_event === false){return false;}
		}else{return false;}
		
		global $bdd;
		$query = "SELECT 		uaa.affiche as afficheAG, etap.affiche as afficheTEV
							FROM			agendas_events ev
							JOIN			agendas_users_agendas_affichage 							uaa		ON ev.ref_agenda = uaa.ref_agenda						
							JOIN			agendas_users_events_type_affiche_permissions etap 	ON etap.id_type_event = ev.id_type_event
							WHERE 	ev.ref_agenda_event_parent IS NULL
							&&			ev.affichage_journee = 0
							&&			ev.ref_agenda_event = '".$ref_event."'
							&&			uaa.ref_user  = '".$this->getUser()->getRef_user()."'
							&&			etap.ref_user = '".$this->getUser()->getRef_user()."'";
		$resultat = $bdd->query(($query));
		if(!$res = $resultat->fetchObject()){return false;}
		return (min($res->afficheAG, $res->afficheTEV) > 0); //On retourne un VRAI bool
	}

	  // *************************************************************************************************************
	 // Gestion des droits
	// *************************************************************************************************************
	
	//public array getDroitsTypesEvents()
	public function getDroitsTypesEvents(){
		return $this->eventsTypesPermissions;
	}
	
}

?>