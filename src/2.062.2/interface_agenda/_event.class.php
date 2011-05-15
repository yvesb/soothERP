<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS D'UN EVENEMENT
// *************************************************************************************************************
// 
// 
// 

// *************************************************************************************************************
// CLASSE Event 
// *************************************************************************************************************
class Event{

	private $agenda; 				//Obj Agenda
	private $ref_agenda;
	private $id_type_agenda;
	
	private $event_Parent;			//Obj Event
	private $ref_event_parent;
	private $events_fils; 		//Tableau d'obj Event
	private $ref_events_fils;	//Tableau de ref
	
	private $ref_event;
	private $lib_event;
	private $note_event;
	private $Udate_event;			// int : temps mesurée en secondes depuis le début de l'époque UNIX, (1er janvier 1970 00:00:00 GMT). 
	private $duree_event;			// int
	private $duree_all_day;
	
	public function __construct($ref_event){
		global $bdd;
		if ($ref_event == null || $ref_event == "")	return false;
			
		$query = "SELECT 	ev.ref_agenda_event, ev.ref_agenda, ev.lib_agenda_event, ev.note_agenda_event, UNIX_TIMESTAMP(ev.date_agenda_event) as Udate_agenda_event,
											ev.duree_agenda_event, ev.ref_agenda_event_parent, ev.duree_all_day_agenda_event, ag.id_type_agenda 
							FROM 		agendas_events ev
							LEFT 		JOIN agendas ag ON ev.ref_agenda = ag.ref_agenda
							WHERE 	ev.ref_agenda_event = '".$ref_event."'";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false; 
		
		$this->ref_event = $r->ref_agenda_event;
		$this->ref_event_parent = $r->ref_agenda_event_parent;
		
		$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';
				
		$this->lib_event = str_replace($order, $replace, nl2br(stripslashes($r->lib_agenda_event)));
		$this->note_event = stripslashes($r->note_agenda_event);
		$this->Udate_event = $r->Udate_agenda_event;
		$this->duree_event = $r->duree_agenda_event;
		$this->id_type_agenda = $r->id_type_agenda;
		$this->ref_agenda = $r->ref_agenda;
		$r->duree_all_day_agenda_event;
		$this->duree_all_day = $r->duree_all_day_agenda_event;
	}
	
	public static function EVENT_ID_REFERENCE_TAG()
	{		return 35;}
	
	public final static function &newEvent(&$agenda, &$event_Parent, $lib_event, $note_event, $Udate_event, $duree_event, $duree_all_day = false){
		global $bdd;
		$newEvent = null;
		if ( $agenda == null || $lib_event == null || $lib_event == "" || !is_numeric($Udate_event) || !is_numeric($duree_event) || !is_bool($duree_all_day)) return $newEvent; // = null
		
		$reference = new reference(Event::EVENT_ID_REFERENCE_TAG());
		$ref_event = $reference->generer_ref();

		$ref_agenda = $agenda->getRef_agenda();
		
		if( $event_Parent == null)
		{		$ref_event_parent = "";}
		else
		{		$ref_event_parent = $event_Parent->getRef_event();}
	
		$query = "INSERT INTO agendas_events
			(	ref_agenda_event, ref_agenda, lib_agenda_event, note_agenda_event, date_agenda_event, duree_agenda_event, ref_agenda_event_parent, duree_all_day_agenda_event) VALUES
			('".$ref_event."', '".$ref_agenda."', '".addslashes($lib_event)."', '".addslashes($note_event)."', FROM_UNIXTIME(".$Udate_event."), '".$duree_event."', '".$ref_event_parent."', '".$duree_all_day."')";

		$bdd->exec ($query);

		$newEvent = new Event($ref_event);
		$newEvent->agenda =& $agenda;
		return $newEvent;
	}
			
	// *************************************************************************************************************
	// Getters & Setters pour l'event
	// *************************************************************************************************************
	
	public function getRef_agenda(){
		return $this->ref_agenda;
	}

	public function &getAgenda(){
		if($this->agenda != null)
		{		return $this->agenda;}

		$this->agenda =& openAgenda($this->ref_agenda);

		return $this->agenda;
	}
	
	public function setRef_Agenda($ref_agenda){
		if($this->ref_agenda != $ref_agenda){
			global $bdd;
			$query = "UPDATE agendas_events SET ref_agenda = '".$ref_agenda."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->agenda = null; // l'agenda est chargé à la demande
		}
	}
	
	public function setAgenda(&$agenda){
		global $bdd;
		
		if( $agenda == null ){
			$this->agenda = null;
			$this->ref_agenda = "";
			$query = "UPDATE agendas_events SET ref_agenda = ''
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			return true;
		}
		
		if(! ($agenda instanceof Agenda) ) return false;

		if($this->ref_agenda != $agenda->getRef_agenda()){
			$query = "UPDATE agendas_events SET ref_agenda = '".$agenda->getRef_agenda()."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->ref_agenda = $agenda->getRef_agenda();
		}
		$this->agenda =& $agenda;
		return true;
	}
	
	public function getRef_event_parent(){
		return $this->ref_event_parent;
	}
	
	public function &getEvent_parent(){
		if ($this->ref_event_parent == ""){
			return null;
		}else{
			if($this->event_parent !=null){
				return $this->event_parent;
			}else{
				$this->event_parent = new Event($this->ref_event_parent);
				//ATTENTION $this->event_parent->events_fils[$i] != $this;
				//il faut mettre à jour la référence de l'objet
				$cousins =& $this->event_parent->getEvents_fils();
				for ($i = 0; i< count($cousins); $i++){
					if($cousins[$i]->getRef_event() == $this->getRef_event())
						$cousins[$i] =& $this;
						break;
				}
			}
		}
	}

	public function getRef_events_fils(){
		return $this->ref_events_fils;
	}
	
	public function &getEvents_fils(){
		if(count($this->ref_events_fils) == 0){
			return null;
		}else{
			if($this->events_fils !=null){
				return $this->events_fils;
			}else{
				$this->events_fils = array(count($this->ref_events_fils));
				foreach ($this->ref_events_fils as $ref_ev_fils){
					$ev = new Event($ref_ev_fils);
					$ev->event_parent =& $this;
					//ATTENTION $this->events_fils[$i]->event_parent != $this;
					//il faut mettre à jour la référence de l'objet
					$this->events_fils[] = ev;
				}
				return $this->events_fils;
			}
		}
	}

	public function getRef_event(){
		return $this->ref_event;
	}
	
	public function getLib_event(){
		return $this->lib_event;
	}
	
	public function setLib_event($lib){
		if($this->lib_event != $lib){
			global $bdd;
			$order   = array("\r\n", "\n", "\r");
			$replace = '<br />';
				
			$query = "UPDATE agendas_events SET lib_agenda_event = '".str_replace($order, $replace, nl2br(addslashes($lib)))."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->lib_event = $lib;
		}
	}

	public function getNote_event(){
		return $this->note_event;
	}
	
	public function setNote_event($note){
		if($this->note_event != $note){
			global $bdd;
			$query = "UPDATE agendas_events SET note_agenda_event = '".addslashes($note)."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->note_event = $note;
		}
	}
	
	public function getUdate_event(){
		return $this->Udate_event;
	}
	
	public function setUdate_event($Udate){
		if($this->Udate_event != $Udate){
			global $bdd;
			$query = "UPDATE agendas_events SET date_agenda_event = FROM_UNIXTIME(".$Udate.")
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->Udate_event = $Udate;
		}
	}
			
	public function getDuree_event(){
		return $this->duree_event;
	}
	
	public function setDuree_event($min){
		if($this->duree_event != $min){
			global $bdd;
			$query = "UPDATE agendas_events SET duree_agenda_event = '".$min."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->duree_event = $min;
		}
	}
	
	public function getDuree_all_day_event(){
		return $this->duree_all_day;
	}
	
	public function setDuree_all_day_event($duree_all_day){
		if(is_bool($duree_all_day)){
			global $bdd;
			$query = "UPDATE agendas_events SET duree_all_day_agenda_event = '".$duree_all_day."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query ($query);
			$this->duree_all_day = $duree_all_day;
		}
	}
	
	public function deleteOnCascade(){
		if($this->agenda != null){
			$this->agenda->delete_Event($this);
			$this->agenda = null;
		}
		$this->event_Parent = null;
		for ($i = 0; $i<count($this->events_fils); $i++){
			$this->events_fils[$i]->deleteOnCascade();
		}
		$this->events_fils = null;
		
		global $bdd;
		$query = "DELETE  FROM  agendas_events 
							WHERE ref_agenda_event = '".$this->ref_event."'";
		$bdd->exec($query);
	}
}
?>