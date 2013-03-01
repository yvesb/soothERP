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
	private $id_agenda_couleurs;			//smallint(5) 	unsigned default 1
	private $couleur_1;								//varchar(7) 		ex "#ffffff"
	private $couleur_2;								//varchar(7) 		ex "#ffffff"
	private $couleur_3;								//varchar(7) 		ex "#000000"
	
	private $event_Parent;			//Obj Event
	private $ref_event_parent;
	private $events_fils; 		//Tableau d'obj Event
	private $ref_events_fils;	//Tableau de ref
	
	private $ref_event;
	private $lib_event;
	private $note_event;
	private $Udate_event;			// int : temps mesurée en secondes depuis le début de l'époque UNIX, (1er janvier 1970 00:00:00 GMT). 
	private $duree_event;			// int
	private $affichage_journee;
	
	private $id_type_event;
	
	private $gestionnaireEvenements;
	
	public function __construct($ref_event){
		
		global $bdd;
		if ($ref_event == null || $ref_event == "")	return false;
			
		$query = "SELECT 	ev.ref_agenda_event, ev.ref_agenda, ev.lib_agenda_event, ev.note_agenda_event, UNIX_TIMESTAMP(ev.date_agenda_event) as Udate_agenda_event,
											ev.duree_agenda_event, ev.ref_agenda_event_parent, ev.affichage_journee, ev.id_type_event, ag.id_type_agenda, agsr.id_agenda_couleurs,
											agsr.agenda_couleur_rule_1, agsr.agenda_couleur_rule_2, agsr.agenda_couleur_rule_3
							FROM 			agendas_events ev
							LEFT JOIN agendas ag ON ev.ref_agenda = ag.ref_agenda
							LEFT JOIN agendas_couleurs agsr ON agsr.id_agenda_couleurs = ag.id_agenda_couleurs 
							WHERE 	ev.ref_agenda_event = '".$ref_event."'";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false; 
		
		$this->ref_event 					= ($r->ref_agenda_event);
		$this->ref_event_parent		= ($r->ref_agenda_event_parent);

		$this->lib_event 					= nl2br(stripslashes($r->lib_agenda_event));
		$this->note_event 				= stripslashes($r->note_agenda_event);
		$this->Udate_event 				= $r->Udate_agenda_event;
		$this->duree_event 				= $r->duree_agenda_event;
		$this->id_type_agenda 		= intval($r->id_type_agenda);
		$this->ref_agenda 				= $r->ref_agenda;
		$this->id_agenda_couleurs = intval($r->id_agenda_couleurs);
		$this->duree_all_day 			= $r->affichage_journee;
		$this->couleur_1 					= $r->agenda_couleur_rule_1;
		$this->couleur_2 					= $r->agenda_couleur_rule_2;
		$this->couleur_3 					= $r->agenda_couleur_rule_3;
		
		$this->id_type_event			= intval($r->id_type_event);
	}
	
	public static function EVENT_ID_REFERENCE_TAG()
	{		return 35;}
	
	public final static function &newEvent(&$agenda, $id_type_event, &$event_Parent, $lib_event, $note_event, $Udate_event, $duree_event, $affichage_journee = 0){
		global $bdd;
		$newEvent = null;
		if ( $agenda == null || $lib_event == null || $lib_event == "" || !is_numeric($id_type_event) || $id_type_event < 1 ||!is_numeric($Udate_event) || !is_numeric($duree_event)) return $newEvent; // = null
		
		$reference = new reference(Event::EVENT_ID_REFERENCE_TAG());
		$ref_event = $reference->generer_ref();

		if(is_string($agenda))
		{		$ref_agenda = $agenda;}
		elseif(is_subclass_of($agenda, "Agenda"))
		{		$ref_agenda = $agenda->getRef_agenda();}
		else
		{		 return $newEvent;} // = null
		
		
		if( $event_Parent == null)
		{		$ref_event_parent = "";}
		else
		{		$ref_event_parent = $event_Parent->getRef_event();}
	
		$query = "INSERT INTO agendas_events
			(	ref_agenda_event, ref_agenda, id_type_event, lib_agenda_event, note_agenda_event, date_agenda_event, duree_agenda_event, ref_agenda_event_parent, affichage_journee) VALUES
			('".$ref_event."', '".$ref_agenda."', ".$id_type_event.", '".addslashes($lib_event)."', '".addslashes($note_event)."', FROM_UNIXTIME(".$Udate_event."), '".$duree_event."', NULL , ".$affichage_journee.")";
		
		$bdd->exec(($query));

		$newEvent = new Event($ref_event);
		if(!is_string($agenda) && is_subclass_of($agenda, "Agenda")){
			$newEvent->agenda =& $agenda;
		}
		return $newEvent;
	}
			
	// *************************************************************************************************************
	// Getters & Setters pour l'event
	// *************************************************************************************************************
	
	protected function chargerCouleur(){
		global $bdd;
		
		$query = "SELECT 	agsr.agenda_couleur_rule_1, agsr.agenda_couleur_rule_2, agsr.agenda_couleur_rule_3
							FROM 			agendas_events ev
							LEFT JOIN agendas ag ON ev.ref_agenda = ag.ref_agenda
							LEFT JOIN agendas_couleurs agsr ON agsr.id_agenda_couleurs = ag.id_agenda_couleurs 
							WHERE 	ev.ref_agenda_event = '".$this->ref_event."'";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false; 
		$this->couleur_1 					= $r->agenda_couleur_rule_1;
		$this->couleur_2 					= $r->agenda_couleur_rule_2;
		$this->couleur_3 					= $r->agenda_couleur_rule_3;
		return true;
	}
	
	//retourne la couleur n°1 sous forme d'une chaine de charactère de la forme #e3a869
	public function getCouleur_1(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getCouleur_1($this)){
			if(is_null($this->agenda)){
				return $this->couleur_1;
			}else{
				return $this->agenda->getCouleur_1();
			}
		}else{
			return false;
		}
	}
	
	//retourne la couleur n°2 sous forme d'une chaine de charactère de la forme #e3a869
	public function getCouleur_2(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getCouleur_2($this)){
			if(is_null($this->agenda)){
				return $this->couleur_2;
			}else{
				return $this->agenda->getCouleur_2();
			}
		}else{
			return false;
		}
	}
	
	//retourne la couleur n°3 sous forme d'une chaine de charactère de la forme #e3a869
	public function getCouleur_3(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getCouleur_3($this)){
			if(is_null($this->agenda)){
				return $this->couleur_3;
			}else{
				return $this->agenda->getCouleur_3();
			}
		}else{
			return false;
		}
	}
	
	public function getRef_agenda(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getRef_agenda($this))
		{			return $this->ref_agenda;}
		else{	return false;}
	}

	public function &getAgenda(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getAgenda($this)){
			if($this->agenda != null)
			{		return $this->agenda;}
	
			$this->agenda =& Lib_interface_agenda::openAgenda($this->ref_agenda);
	
			return $this->agenda;
		}else{
			return null;
		}
	}
	
	public function setRef_Agenda($ref_agenda, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setRef_Agenda($this)){
			if($this->ref_agenda != $ref_agenda){
				global $bdd;
				$query = "UPDATE agendas_events SET ref_agenda = '".$ref_agenda."'
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->agenda = null; // l'agenda est chargé à la demande
				$this->chargerCouleur();
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function setAgenda(&$agenda, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setAgenda($this)){
			global $bdd;
			
			if( $agenda == null ){
				$this->agenda = null;
				$this->ref_agenda = "";
				$query = "UPDATE agendas_events SET ref_agenda = ''
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				return true;
			}
			
			if(! ($agenda instanceof Agenda) ) return false;
	
			if($this->ref_agenda != $agenda->getRef_agenda()){
				$query = "UPDATE agendas_events SET ref_agenda = '".$agenda->getRef_agenda()."'
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->ref_agenda = $agenda->getRef_agenda();
			}
			$this->agenda =& $agenda;
			return true;
		}else{
			return false;
		}
	}
	
	public function getRef_event_parent(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getRef_event_parent($this))
		{			return $this->ref_event_parent;}
		else{	return "";}
	}
	
	public function &getEvent_parent(&$gestionnaireEvenements = null){
		$val_null = null;
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getEvent_parent($this)){
			if ($this->ref_event_parent == "")
			{			return $val_null;}
			else
			{	if(is_null($this->event_parent)){
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
				return $this->event_parent;
			}
		}else{
			return $val_null;
		}
	}

	public function getRef_events_fils(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getRef_events_fils($this)){
			return $this->ref_events_fils;
		}else{
			return false;
		}
	}
	
	public function &getEvents_fils(&$gestionnaireEvenements = null){
		$val_null = null;
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getEvents_fils($this)){
			if(count($this->ref_events_fils) == 0){
				return $val_null;
			}else{
				if(is_null($this->events_fils)){
					$this->events_fils = array(count($this->ref_events_fils));
					foreach ($this->ref_events_fils as $ref_ev_fils){
						$ev = new Event($ref_ev_fils);
						$ev->event_parent =& $this;
						//ATTENTION $this->events_fils[$i]->event_parent != $this;
						//il faut mettre à jour la référence de l'objet
						$this->events_fils[] = ev;
					}
				}
				return $this->events_fils;
			}
		}else{
			$val_null;
		}
	}

	public function getRef_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getRef_event($this))
		{			return $this->ref_event;}
		else{	return "";}
	}
	
	public function getLib_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getLib_event($this))
		{			return $this->lib_event;}
		else{	return false;}
	}
	
	public function setLib_event($lib, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setLib_event($this)){
			if($this->lib_event != $lib){
				global $bdd;
				$query = "UPDATE agendas_events SET lib_agenda_event = '".nl2br(addslashes($lib))."'
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->lib_event = $lib;
			}
			return true;
		}else
		{		return false;}
	}

	public function getNote_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getNote_event($this)){
			return $this->note_event;
		}else{
			return false;
		}
	}
	
	public function setNote_event($note, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setNote_event($this)){
			if($this->note_event != $note){
				global $bdd;
				$query = "UPDATE agendas_events SET note_agenda_event = '".addslashes($note)."'
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->note_event = $note;
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function getUdate_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getUdate_event($this)){
			return $this->Udate_event;
		}else{
			return false;
		}
	}
	
	public function setUdate_event($Udate, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setUdate_event($this)){
			if($this->Udate_event != $Udate){
				global $bdd;
				$query = "UPDATE agendas_events SET date_agenda_event = FROM_UNIXTIME(".$Udate.")
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->Udate_event = $Udate;
			}
			return true;
		}else{
			return false;
		}
	}
			
	public function getDuree_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getDuree_event($this)){
			return $this->duree_event;
		}else{
			return false;
		}
	}
	
	public function setDuree_event($min, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setDuree_event($this)){
			if($this->duree_event != $min){
				global $bdd;
				$query = "UPDATE agendas_events SET duree_agenda_event = '".$min."'
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->duree_event = $min;
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function getDuree_all_day_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getDuree_all_day_event($this)){
			return $this->duree_all_day;
		}else{
			return false;
		}
	}
	
	public function setDuree_all_day_event($affichage_journee, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setDuree_all_day_event($this)){
			if(is_bool($affichage_journee)){
				global $bdd;
				$query = "UPDATE agendas_events SET affichage_journee = '".$affichage_journee."'
									WHERE ref_agenda_event = '".$this->ref_event."' ";
				$resultat = $bdd->query(($query));
				$this->duree_all_day = $affichage_journee;
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function deleteOnCascade(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getDuree_all_day_event($this)){
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
			$bdd->exec(($query));
			return true;
		}else{
			return false;
		}
	}
	
	public function getId_type_event(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getId_type_event($this)){
			return $this->id_type_event;
		}else{
			return false;
		}
	}
	
	public function setId_type_event($id_type_event, &$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->setId_type_event($this)){
			global $bdd;
			$query = "UPDATE agendas_events SET id_type_event = '".$id_type_event."'
								WHERE ref_agenda_event = '".$this->ref_event."' ";
			$resultat = $bdd->query(($query));
			$this->id_type_event = $id_type_event;
			return true;
		}else{
			return false;
		}
	}
	
	public function getId_type_agenda(&$gestionnaireEvenements = null){
		if(is_null($gestionnaireEvenements) || $gestionnaireEvenements->getId_type_agenda($this)){
			return $this->id_type_agenda;
		}else{
			return false;
		}
	}	
}
?>

