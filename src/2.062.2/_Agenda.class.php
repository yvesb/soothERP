<?php




// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS SUR UN AGENDA
// *************************************************************************************************************
//  4 CLASSES
//	Agenda <: AgendaReservationRessource
//	Agenda <: AgendaContact
//	Agenda <: AgendaLoacationMateriel


// *************************************************************************************************************
// CLASSE Agenda 
// *************************************************************************************************************
abstract class Agenda implements IGestionnaireEvenements{

	//voir dans la BD la TABLE : AGENDAS
	private $ref_agenda;						//varchar(32) 	NOT NULL
	private $lib_agenda;						//varchar(64) 	NOT NULL

	//voir dans la BD la table : agendas_couleurs
	private $id_agenda_couleurs;		//smallint(5) 	unsigned default 1
	private $couleur_1;								//varchar(7) 		ex "#ffffff"
	private $couleur_2;								//varchar(7) 		ex "#ffffff"
	private $couleur_3;								//varchar(7) 		ex "#000000"
	
	//voir dans la BD la table : AGENDA_EVENTS
	private $events;						//liste des Events de l'agenda
	
	public function __construct($ref_agenda){
		global $bdd;
		if (!is_numeric($this->getId_type_agenda()))
			return false;
		
		$query = "SELECT 		ag.ref_agenda, ag.lib_agenda, agsr.id_agenda_couleurs, agsr.agenda_couleur_rule_1,
												agsr.agenda_couleur_rule_2, agsr.agenda_couleur_rule_3
							FROM 			agendas ag
							LEFT JOIN agendas_couleurs agsr ON agsr.id_agenda_couleurs = ag.id_agenda_couleurs 
							WHERE 		ag.ref_agenda = '".$ref_agenda."'";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject())
			return false;
		$this->events = null;
		
		$this->ref_agenda 					= ($r->ref_agenda);
		$this->lib_agenda 					= stripslashes($r->lib_agenda);
		$this->id_agenda_couleurs 	= intval($r->id_agenda_couleurs);
		$this->couleur_1 						= ($r->agenda_couleur_rule_1);
		$this->couleur_2 						= ($r->agenda_couleur_rule_2);
		$this->couleur_3 						= ($r->agenda_couleur_rule_3);
	}
	
	// *************************************************************************************************************
	// Getters & Setters
	// *************************************************************************************************************
	
	public function getRef_agenda()
	{		return $this->ref_agenda;}
	
	public function getLib_agenda()
	{		return $this->lib_agenda;}
	
	public function setLib_agenda($lib_agenda){
		if($lib_agenda == null || $lib_agenda == "")return false;
		if($lib_agenda != $this->lib_agenda){
			global $bdd;
			$query = "UPDATE agendas SET lib_agenda = '".addslashes($lib_agenda)."'
								WHERE ref_agenda = '".$this->ref_agenda."' ";
			$resultat = $bdd->query(($query));
			$this->lib_agenda = $lib_agenda;
		}
		return true;
	}

	public function &addNewEvent(&$event_Parent, $lib_event, $note_event, $date_event, $duree_event){
		$newEvent =& Event::newEvent($this, $event_Parent, $lib_event, $note_event, $date_event, $duree_event);
		if(is_null($newEvent))
		{		return null;}
		if(is_null($this->events))
		{		$this->events = array();}
		$this->events[$newEvent->getRef_event()] =& $newEvent;
		return $newEvent;
	}
	
	public function addEvent(&$event){
		if( $event == null || !($event instanceof Event) )
		{		return false;}
		if(is_null($this->events))
		{		$this->events = array();}
		$event->setAgenda($this);
		$this->events[$event->getRef_event()] =& $event;
		return true;
	}
	
	public function &getEvents(){
			if(is_null($this->events)){
			global $bdd;
			
			$query = "SELECT 	age.ref_agenda_event
								FROM agendas_events age
								WHERE ag.ref_agenda = '".$this->ref_agenda."'";
			
			$resultat = $bdd->query(($query));
			while ($r = $resultat->fetchObject())
				$this->addEvent(new Event(($r->ref_agenda_event)));
		}
		return $this->events;
	}
	
	public function &getEvent($ref_event){
		if(is_set($this->events[$ref_event]))
		{		return $this->events[$ref_event];}
		else{$res = null; return res;}//null
	}
	
	//retourne la couleur n°1 sous forme d'une chaine de charactère de la forme #e3a869
	public function getCouleur_1(){
		return $this->couleur_1;
	}
	
	//retourne la couleur n°2 sous forme d'une chaine de charactère de la forme #e3a869
	public function getCouleur_2(){
		return $this->couleur_2;
	}
	
	//retourne la couleur n°3 sous forme d'une chaine de charactère de la forme #e3a869
	public function getCouleur_3(){
		return $this->couleur_3;
	}
	
	public function setCouleur_1($couleur){
     if($couleur == null || $couleur == "" || !preg_match('`#[0-9a-fA-F]{6}`', $couleur)) 
     	return false;
		//else
    global $bdd;
		$query = "UPDATE agendas_couleurs SET agenda_couleur_rule_1 = '".$couleur."'
							WHERE id_agenda_couleurs = '".$this->id_agenda_couleurs."' ";
		$resultat = $bdd->query(($query));
		return true;
	}
	
	public function setCouleur_2($couleur){
     if($couleur == null || $couleur == "" || !preg_match('`#[0-9a-fA-F]{6}`', $couleur)) 
     	return false;
		//else
    global $bdd;
		$query = "UPDATE agendas_couleurs SET agenda_couleur_rule_2 = '".$couleur."'
							WHERE id_agenda_couleurs = '".$this->id_agenda_couleurs."' ";
		$resultat = $bdd->query(($query));
		return true;
	}
	
	public function setCouleur_3($couleur){
     if($couleur == null || $couleur == "" || !preg_match('`#[0-9a-fA-F]{6}`', $couleur)) 
     	return false;
		//else
    global $bdd;
		$query = "UPDATE agendas_couleurs SET agenda_couleur_rule_3 = '".$couleur."'
							WHERE id_agenda_couleurs = '".$this->id_agenda_couleurs."' ";
		$resultat = $bdd->query(($query));
		return true;
	}
	
	public function getId_agenda_style_rule()
	{		return $this->id_agenda_couleurs;}
	
	public function setId_agenda_style_rule($id_agenda_couleurs){
		global $bdd;
		if(!is_numeric($id_agenda_couleurs))
			return false;
		//else
		$query = "UPDATE agendas SET id_agenda_couleurs = '".$id_agenda_couleurs."'
							WHERE ref_agenda = '".$this->ref_agenda."' ";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject())return false;
		$this->loadagendas_couleurs();
		return true;
	}
	
	public function loadagendas_couleurs(){
		global $bdd;
		$query = "SELECT 		agsr.id_agenda_couleurs, agsr.agenda_couleur_rule_1, agsr.agenda_couleur_rule_2, agsr.agenda_couleur_rule_3
							FROM 			agendas_couleurs agsr
							LEFT JOIN agendas ag ON agsr.id_agenda_couleurs = ag.id_agenda_couleurs 
							WHERE 		ag.ref_agenda = '".$this->ref_agenda."'";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject())return false;
		$this->id_agenda_couleurs = intval($r->id_agenda_couleurs);
		$this->$couleur_1 = 				($r->agenda_couleur_rule_1);
		$this->$couleur_2 = 				($r->agenda_couleur_rule_2);
		$this->$couleur_3 = 				($r->agenda_couleur_rule_3);
	}
	
	// *************************************************************************************************************
	// FONCTION DE SUPPRESSION
	// *************************************************************************************************************
	
	public function delete_Event_by_Ref($ref_event){
		if(isset($this->events[$ref_event])){
			unset($this->events[$ref_event]);
			return true;	
		}
		return false;
	}
	
	
	public function delete_Event(&$event){
		if(isset($this->events[$event->getRef_event()])){
			unset($this->events[$event->getRef_event()]);
			return true;
		}
		return false;
	}
		
	// *************************************************************************************************************
	// ATTRIBUTS ET FONCTIONS "STATIC"
	// *************************************************************************************************************
	
	public abstract function AGENDA_ID_REFERENCE_TAG();
	public abstract function setLib_type($lib_type);
	public abstract function getLib_type();
	public abstract function getId_type_agenda();
	public abstract function loadType_informations();

}

?>