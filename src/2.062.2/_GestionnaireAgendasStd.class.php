<?php
// *************************************************************************************************************
// CLASSE GestionnaireAgendas 
// *************************************************************************************************************
abstract class GestionnaireAgendasStd {
	
	//$agendasPermissions[REF_AGENDA] = array();
	//$agendasPermissions[REF_AGENDA] = AgendasPermissions;
	private $agendasPermissions;
	
	private $user;
	
	public function __construct(&$user){
		$this->user =& $user;
		$this->chargerAgendasAvecDroits();
	}
	
	function __call($method,$args){
		return true;
	}
	
	  // *************************************************************************************************************
	 // Getters & Setters
	// *************************************************************************************************************
	
	public function &getUser(){
		return $this->user;
	}
	
	protected function setUser(&$user){
		$this->user =& $user;
	}
	
	public function &getAgendasPermissions($ref_agenda){
		if(is_null($ref_agenda) || $ref_agenda == "" || !isset($this->agendasPermissions[$ref_agenda]))
		{		$res = null; return $res;}
		
		//$agendasPermissions[REF_AGENDA] = array();
		//$agendasPermissions[REF_AGENDA] = AgendasPermissions;
		return $this->agendasPermissions[$ref_agenda];
	}
	
	protected function setAgendasPermissions(&$agendasPermissions){
		return $this->agendasPermissions =& $agendasPermissions;
	}
	
	// *************************************************************************************************************
	// DROITS SUR LES AGENDAS
	// *************************************************************************************************************
	
	//$agendasPermissions[REF_AGENDA] = array();
	//$agendasPermissions[REF_AGENDA] = AgendasPermissions;
	//private $agendasPermissions;
	public function chargerAgendasAvecDroits(){
		$this->agendasPermissions = array();
		
		global $bdd;
		$resultat = $bdd->query ($this->queryChargerAgendasAvecDroits());
		
		while ($r = $resultat->fetchObject()){
			if(isset($old_ref_agenda) && $old_ref_agenda != $r->ref_agenda){ 
				$this->agendasPermissions[$old_ref_agenda] = new AgendasPermissions($old_ref_agenda, $id_permission, $events_types_permission);
				$old_ref_agenda = $r->ref_agenda;
				$id_permission = intval($r->agenda_permission);
				$events_types_permission = array();
				if($r->id_type_event != "" && $r->event_type_permission != ""){
					$events_types_permission[intval($r->id_type_event)] = intval($r->event_type_permission);
				}
			}else{
				if(!isset($old_ref_agenda)){
					$old_ref_agenda = $r->ref_agenda;
					$id_permission = intval($r->agenda_permission);
					$events_types_permission = array();
				}
				
				if($r->id_type_event != "" && $r->event_type_permission != ""){
					$events_types_permission[intval($r->id_type_event)] = intval($r->event_type_permission);
				}
			}
			if(isset($old_ref_agenda)){ 
				$this->agendasPermissions[$old_ref_agenda] = new AgendasPermissions($old_ref_agenda, $id_permission, $events_types_permission);
			}
		}
	}
	
	protected function queryChargerAgendasAvecDroits(){
		return "SELECT	a.ref_agenda, aet.id_type_event, 9999 AS agenda_permission, 9999 AS event_type_permission
						FROM				agendas a
						LEFT JOIN		agendas_events_types aet ON a.id_type_agenda = aet.id_type_agenda
						ORDER BY 		a.ref_agenda, aet.id_type_event";
	}
	
	// ****************************************************************
	
	//$agendas[REF_AGENDA] = array();
	//$agendas[REF_AGENDA]["libAgenda"] = string;
	//$agendas[REF_AGENDA]["affiche"] = bool;
	//$agendas[REF_AGENDA]["droits"] = int;
	//$agendas[REF_AGENDA]["couleur1"] = string;
	//$agendas[REF_AGENDA]["couleur2"] = string;
	//$agendas[REF_AGENDA]["couleur3"] = string;
	//$agendas[REF_AGENDA]["id_type_agenda"] = int;
	//$agendas[REF_AGENDA]["lib_type_agenda"] = string;
	public function &getAgendasAvecDroits($id_liste_agenda = -1){
		return $this->getAgendasOfAllListeAvecDroits();
	}
	
	//$agendas[REF_AGENDA] = array();
	//$agendas[REF_AGENDA]["libAgenda"] = string;
	//$agendas[REF_AGENDA]["affiche"] = bool;
	//$agendas[REF_AGENDA]["droits"] = int;
	//$agendas[REF_AGENDA]["couleur1"] = string;
	//$agendas[REF_AGENDA]["couleur2"] = string;
	//$agendas[REF_AGENDA]["couleur3"] = string;
	//$agendas[REF_AGENDA]["id_type_agenda"] = int;
	//$agendas[REF_AGENDA]["lib_type_agenda"] = string;
	protected function &getAgendasOfAllListeAvecDroits(){
		$agendas = array();

		//$agendas[REF_AGENDA] = AgendasPermissions;
		$query_IN = "";
		reset($this->agendasPermissions);
		for($i=0; $i< count($this->agendasPermissions); $i++){
			$index = key($this->agendasPermissions); 
			if($query_IN != "")
			{			$query_IN.= ", '".$index."'";}
			else{	$query_IN.= 	"'".$index."'";}
			next($this->agendasPermissions);
		}
		
		if($query_IN == "")return $agendas;
		
		$query = "SELECT a.ref_agenda, a.lib_agenda, a.id_type_agenda, at.lib_type_agenda, ac.agenda_couleur_rule_1, ac.agenda_couleur_rule_2, ac.agenda_couleur_rule_3, ua.affiche
							FROM agendas a
							LEFT JOIN agendas_types at										ON at.id_type_agenda = a.id_type_agenda
							LEFT JOIN agendas_couleurs ac 								ON a.id_agenda_couleurs = ac.id_agenda_couleurs
							LEFT JOIN agendas_users_agendas_affichage ua 	ON a.ref_agenda = ua.ref_agenda && ua.ref_user = '".$this->user->getRef_user()."'
							WHERE a.ref_agenda IN (".$query_IN.")
							ORDER BY a.ref_agenda";
		global $bdd;
		
		//var_dump($query);
		$resultat = $bdd->query ($query);
		
		$tmp_ref_agenda = "";
		while ($r = $resultat->fetchObject()){
				$tmp_ref_agenda = $r->ref_agenda;
				$agendas[$tmp_ref_agenda] = array();
				$agendas[$tmp_ref_agenda]["libAgenda"] = $r->lib_agenda;
				$agendas[$tmp_ref_agenda]["affiche"] = intval($r->affiche);
				if(isset($this->agendasPermissions[$tmp_ref_agenda])){
					$agendas[$tmp_ref_agenda]["droits"] = intval($this->agendasPermissions[$tmp_ref_agenda]->getAgenda_permission());
				}else{
					$agendas[$tmp_ref_agenda]["droits"] = null;
				}
				$agendas[$tmp_ref_agenda]["couleur1"] = $r->agenda_couleur_rule_1;
				$agendas[$tmp_ref_agenda]["couleur2"] = $r->agenda_couleur_rule_2;
				$agendas[$tmp_ref_agenda]["couleur3"] = $r->agenda_couleur_rule_3;
				$agendas[$tmp_ref_agenda]["id_type_agenda"] = intval($r->id_type_agenda);
				$agendas[$tmp_ref_agenda]["lib_type_agenda"] = $r->lib_type_agenda;
		}
		return $agendas;
	}
	
	// *************************************************************************************************************
	// FIN : DROITS SUR LES AGENDAS
	// *************************************************************************************************************
	
	//public bool 	majAgendasUsersAgendasAffichage(string, 		 0/1/null)
	public function majAgendasUsersAgendasAffichage($ref_agenda, $affichage){
		if($ref_agenda == "")return false;
			
		$query = "DELETE FROM agendas_users_agendas_affichage
							WHERE 		ref_user = '".$this->user->getRef_user()."'	&&
												ref_agenda = '".$ref_agenda."' ;";
		if(!is_null($affichage)){
			$query.= "INSERT INTO agendas_users_agendas_affichage
								(ref_user, ref_agenda, 	affiche) VALUES
								('".$this->user->getRef_user()."', '".$ref_agenda."', ".$affichage.")";
		}

		var_dump($query);
		
		global $bdd;
		$bdd->exec($query);
		return true;
	}
	
//public array getListesAgendasAvecDroitsNonVides()
	//$ListesAgendasAvecDroitsNonVides[ID_GROUPE] = libGroupe
	public function getListesAgendasAvecDroitsNonVides(){
		$ListesAgendasAvecDroitsNonVides = array();
		return $ListesAgendasAvecDroitsNonVides;
	}
	
	//public array getAgendasTypesAvecDroitsNonVides(){
	//$AgendasTypesAvecDroitsNonVides[ID_TYPE_AGENDA] = libTypeAgenda
	public function getAgendasTypesAvecDroitsNonVides(){
		$agendasTypes = array();

		global $bdd;
		$resultat = $bdd->query ($this->queryGetAgendasTypesAvecDroitsNonVides());
		
		while ($r = $resultat->fetchObject()){
				$agendasTypes[intval($r->id_type_agenda)] = $r->lib_type_agenda;
		}
	
		return $agendasTypes;
	}
	
	protected function queryGetAgendasTypesAvecDroitsNonVides(){
		return "SELECT 		a.id_type_agenda, at.lib_type_agenda
						FROM			agendas a
						LEFT JOIN agendas_types at ON at.id_type_agenda = a.id_type_agenda
						ORDER BY 	at.lib_type_agenda";	
	}
	
	//public array  getTypesEventsAvecDroits(int1)
	//$typesEvents[$tmp_id_type_event] = array();
	//$typesEvents[$tmp_id_type_event]["libTypeEvent"] = $r->lib_type_event;
	//$typesEvents[$tmp_id_type_event]["affiche"] = $r->affiche;
	//$typesEvents[$tmp_id_type_event]["droits"] = intval($r->id_permission);
	public function getTypesEventsAvecDroits($id_type_agenda = -1){
		$typesEvents = array();
		global $bdd;
		
		$resultat = $bdd->query($this->queryGetTypesEventsAvecDroits($id_type_agenda));
		
		$tmp_ref_agenda = "";
		while ($r = $resultat->fetchObject()){
			$tmp_id_type_event = intval($r->id_type_event);
			$typesEvents[$tmp_id_type_event] = array();
			$typesEvents[$tmp_id_type_event]["libTypeEvent"] = $r->lib_type_event;
			$typesEvents[$tmp_id_type_event]["affiche"] = $r->affiche;
			$typesEvents[$tmp_id_type_event]["droits"] = intval($r->id_permission);
		}
		return $typesEvents;
	}
	
	protected function queryGetTypesEventsAvecDroits($id_type_agenda = -1){
		if($id_type_agenda != -1)
		{		$where = " && et.id_type_agenda = ".$id_type_agenda;}
		else{	$where = "";}
		
		return "SELECT 		et.id_type_event, et.lib_type_event, ap.affiche, 9999 as id_permission
						FROM			agendas_events_types  et
						LEFT JOIN agendas_users_events_type_affiche_permissions ap ON et.id_type_event = ap.id_type_event
						WHERE 		ap.ref_user = '".$this->user->getRef_user()."'
											".$where."
						ORDER BY 	et.lib_type_event";
	}
	
	//public bool 	majAgendasUsersEventsTypesAffichage(int, 		 0/1/null)
	public function majAgendasUsersEventsTypesAffichage($id_type_agenda, $affichage){
		if(!is_numeric($id_type_agenda)) return false;
		
		if(is_null($affichage))
		{		$aff = "NULL";}
		elseif($affichage < 0 || $affichage > 1)
		{		return false;}
		else
		{		$aff = $affichage;}
		
		$query = "UPDATE agendas_users_events_type_affiche_permissions SET affiche = ".$aff."
							WHERE ref_user = '".$this->user->getRef_user()."' &&
										id_type_event = ".$id_type_agenda;
		echo $query;
		global $bdd;
		$bdd->exec($query);
		return true;
	}
	
	//public string getJAVASCRIPTagendasPermissions(string, string){
	//$portee = "var" ou "" 
	public function getJAVASCRIPTagendasPermissions($portee, $nomVarRetour){
		//$agendasPermissions[REF_AGENDA] = array();
		//$agendasPermissions[REF_AGENDA] = AgendasPermissions;
		$script = $portee." ".$nomVarRetour."= new Array();\n";
		$script.= "var tmpAgendasPermissions = new Array();\n";
		
		reset($this->agendasPermissions);
		for($i = 0 ; $i < count($this->agendasPermissions) ; $i++ ){
			
			$index = key($this->agendasPermissions);
			
			$events_types_permission = $this->agendasPermissions[$index]->getEvents_types_permission(); 
			reset($events_types_permission);
			for($j = 0 ; $j < count($events_types_permission) ; $j++ ){
				$index2 = key($events_types_permission);
				$script.= "tmpAgendasPermissions[".$index2."] = ".$events_types_permission[$index2].";\n";
				next($events_types_permission);
			}
			$script.= $nomVarRetour."['".$index."'] = new new_DroitAgenda('".$this->agendasPermissions[$index]->getRef_agenda()."', ".$this->agendasPermissions[$index]->getAgenda_permission().", tmpAgendasPermissions);\n\n";
			$script.= "tmpAgendasPermissions = new Array();\n";
			
			next($this->agendasPermissions);
		}
		return $script;
	}
}
?>