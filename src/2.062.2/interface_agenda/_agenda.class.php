<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS SUR UN AGENDA
// *************************************************************************************************************
// 4 CLASSES
//	Agenda <: AgendaReservationRessource
//	Agenda <: AgendaContact
//	Agenda <: AgendaLoacationMateriel


// *************************************************************************************************************
// CLASSE Agenda 
// *************************************************************************************************************
abstract class Agenda{

	//voir dans la BD la TABLE : AGENDAS
	private $ref_agenda;						//varchar(32) 	NOT NULL
	private $lib_agenda;						//varchar(64) 	NOT NULL

	//voir dans la BD la table : AGENDA_STYLE_RULES
	private $id_agenda_style_rule;		//smallint(5) 	unsigned default 1
	private $couleur_1;								//varchar(7) 		ex "#ffffff"
	private $couleur_2;								//varchar(7) 		ex "#ffffff"
	private $couleur_3;								//varchar(7) 		ex "#000000"
		
	//voir dans la BD la table : AGENDA_EVENTS
	private $events;						//liste des Events de l'agenda

	public function __construct($ref_agenda){
		global $bdd;
		if (!is_numeric($this->getId_type_agenda()))
			return false;
		
		$query = "SELECT 		ag.ref_agenda, ag.lib_agenda, agsr.id_agenda_style_rule, agsr.agenda_couleur_rule_1,
												agsr.agenda_couleur_rule_2, agsr.agenda_couleur_rule_3
							FROM 			agendas ag
							LEFT JOIN agenda_style_rules agsr ON agsr.id_agenda_style_rule = ag.id_agenda_style_rule 
							WHERE 		ag.ref_agenda = '".$ref_agenda."'";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())
			return false;
		$this->events = null;
		
		$this->ref_agenda 					= $r->ref_agenda;
		$this->lib_agenda 					= stripslashes($r->lib_agenda);
		$this->id_agenda_style_rule = $r->id_agenda_style_rule;
		$this->couleur_1 					= $r->agenda_couleur_rule_1;
		$this->couleur_2 					= $r->agenda_couleur_rule_2;
		$this->couleur_3 					= $r->agenda_couleur_rule_3;
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
			$query = "UPDATE agendas SET lib_agenda = '".$lib_agenda."'
								WHERE ref_agenda = '".$this->ref_agenda."' ";
			$resultat = $bdd->query ($query);
			$this->lib_agenda = $lib_agenda;
		}
		return true;
	}

	public function &addNewEvent(&$event_Parent, $lib_event, $note_event, $date_event, $duree_event){
		$newEvent =& Event::newEvent($this, $event_Parent, $lib_event, $note_event, $date_event, $duree_event);
		if($newEvent == null) return null;
		$events[] =& $newEvent;
		return $newEvent;
	}
	
	public function addEvent(&$event){
		if( $event == null || !($event instanceof Event) ) return false;
		$event->setAgenda($this);
		$this->events[$event->getRef_event()] =& $event;
		return true;
	}
	
	public function &getEvents(){
		if($this->events == null){
			global $bdd;
			
			$query = "SELECT 	age.ref_agenda_event
						FROM agendas_events age
						WHERE ag.ref_agenda = '".$this->ref_agenda."'";
			
			$resultat = $bdd->query ($query);
			while ($r = $resultat->fetchObject())
				$this->addEvent(new Event($r->ref_agenda_event));
		}
		return $this->events;
	}
	
	public function &getEvent($ref_event){
		for ($i = 0; $i<count($this->events); $i++){
			 if($this->events[$i]->getRef_event() == $ref_event) return $this->events[$i];
		}
		return null;
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
		$query = "UPDATE agenda_style_rules SET agenda_couleur_rule_1 = '".$couleur."'
							WHERE id_agenda_style_rule = '".$this->id_agenda_style_rule."' ";
		$resultat = $bdd->query ($query);
		return true;
	}
	
	public function setCouleur_2($couleur){
     if($couleur == null || $couleur == "" || !preg_match('`#[0-9a-fA-F]{6}`', $couleur)) 
     	return false;
		//else
    global $bdd;
		$query = "UPDATE agenda_style_rules SET agenda_couleur_rule_2 = '".$couleur."'
							WHERE id_agenda_style_rule = '".$this->id_agenda_style_rule."' ";
		$resultat = $bdd->query ($query);
		return true;
	}
	
	public function setCouleur_3($couleur){
     if($couleur == null || $couleur == "" || !preg_match('`#[0-9a-fA-F]{6}`', $couleur)) 
     	return false;
		//else
    global $bdd;
		$query = "UPDATE agenda_style_rules SET agenda_couleur_rule_3 = '".$couleur."'
							WHERE id_agenda_style_rule = '".$this->id_agenda_style_rule."' ";
		$resultat = $bdd->query ($query);
		return true;
	}
	
	public function getId_agenda_style_rule()
	{		return $this->id_agenda_style_rule;}
	
	public function setId_agenda_style_rule($id_agenda_style_rule){
		global $bdd;
		if(!is_numeric($id_agenda_style_rule))
			return false;
		//else
		$query = "UPDATE agendas SET id_agenda_style_rule = '".$id_agenda_style_rule."'
							WHERE ref_agenda = '".$this->ref_agenda."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())return false;
		$this->loadAgenda_style_rules();
		return true;
	}
	
	public function loadAgenda_style_rules(){
		global $bdd;
		$query = "SELECT 		agsr.id_agenda_style_rule, agsr.agenda_couleur_rule_1, agsr.agenda_couleur_rule_2, agsr.agenda_couleur_rule_3
							FROM 			agenda_style_rules agsr
							LEFT JOIN agendas ag ON agsr.id_agenda_style_rule = ag.id_agenda_style_rule 
							WHERE 		ag.ref_agenda = '".$this->ref_agenda."'";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())return false;
		$this->id_agenda_style_rule = $r->id_agenda_style_rule;
		$this->$couleur_1 = 					$r->agenda_couleur_rule_1;
		$this->$couleur_2 = 					$r->agenda_couleur_rule_2;
		$this->$couleur_3 = 					$r->agenda_couleur_rule_3;
	}
	
	// *************************************************************************************************************
	// FONCTION DE SUPPRESSION
	// *************************************************************************************************************
	
	public function delete_Event_by_Ref($ref_event){
		for ($i = 0; $i<count($this->events); $i++){
			 if($this->events[$i]->getRef_event() == $ref_event){
			 	array_splice($this->events, $i, 1);
			 	return true;
			 }
		}
		return false;
	}
	
	public function delete_Event(&$event){
		for ($i = 0; $i<count($this->events); $i++){
			if($this->events[$i] == $event || $this->events[$i]->getRef_event() == $event->getRef_event()){
			 	array_splice($this->events, $i, 1);
			 	return true;
			 }
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

// *************************************************************************************************************
// CLASSE AgendaReservationRessource
// *************************************************************************************************************
class AgendaReservationRessource extends Agenda{

	// POUR l'instant 1 AGENDA gère 1 RESSOURCE
	// A l'AVENIR 1 AGENDA gèrera plusiseurs ressources
	private $ressources; //array
	//structure :
	//	$ressource[N]["ref_agenda"]
	//	$ressource[N]["ref_ressource"]
	//	$ressource[N]["lib_ressource"]
	
	// *************************************************************************************************************
	// CONSTRUCTEUR
	// *************************************************************************************************************
		
	public function __construct($ref_agenda){
		if(AgendaReservationRessource::$lib_type == "")
			AgendaReservationRessource::_loadType_informations();
		
		$b = parent::__construct($ref_agenda);
		$this->loadRessources();
		if(!$b)return false;
	}
	
	public final static function &newAgendaReservationRessource($lib_agenda, $tabRessources, $id_agenda_style_rule){
		//$tabRessources[] = ref_ressource
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || count($tabRessources)<=0 || !is_numeric($id_agenda_style_rule)) return false;
		
		$reference = new reference(AgendaReservationRessource::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$query_a = "INSERT INTO agendas
			(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_style_rule) VALUES
			('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaReservationRessource::_getId_type_agenda()."', ".$id_agenda_style_rule.")";
		
		$query_b = "INSERT INTO agendas_reservations_ressource(ref_agenda, ref_ressource) VALUES";
		foreach ($tabRessources as $ref_ressource){
			$query_b .= "('".$ref_agenda."', '".$ref_ressource."'),";
		}
		
		$query_b = substr($query_b, 0, -1);
		
		$bdd->beginTransaction();{
			$bdd->exec ($query_a);
			$bdd->exec ($query_b);
		}$bdd->commit();
		$ag = new AgendaReservationRessource($ref_agenda);
		return $ag;
	}
	
	public final static function _delete($ref_agenda){
		global $bdd;
				
		if ($ref_agenda == null || $ref_agenda == "") return false;

		$query = "SELECT  ag.id_agenda_style_rule
							FROM 		agendas ag
							WHERE 	ag.ref_agenda = '".$ref_agenda."'";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		$id_agenda_style_rule = $r->id_agenda_style_rule;

		$query_a = "DELETE  FROM  agendas 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_b = "DELETE  FROM  agendas_reservations_ressource 
								WHERE 	ref_agenda = '".$ref_agenda."'";
		$query_c = "DELETE  FROM  agenda_style_rules 
								WHERE id_agenda_style_rule = ".$id_agenda_style_rule;
		
		$bdd->beginTransaction();{
			$bdd->exec ($query_a);
			$bdd->exec ($query_b);
			$bdd->exec ($query_c);
		}$bdd->commit();
		return true;
	}
	
	// *************************************************************************************************************
	// Getters & Setters
	// *************************************************************************************************************
	//Cerataines fonctions sont redondante avec les fonctions "static" -> normales, c'est plus simple à utiliser
	
	public function getRessources()
	{		return $this->ressources;}
	
	public function setRef_ressources($ref_ressources){
		if($ref_ressources == null || !is_array($ref_ressources))return false;
		global $bdd;
		$query = "";
		$bdd->beginTransaction();{
			for($i=0; $i<count($ref_ressources); $i++){
				$query = "UPDATE agendas_reservations_ressource SET ref_ressource  = '".$ref_ressources[$i]."'
									WHERE ref_agenda = '".$this->getRef_agenda()."';";
				$bdd->exec($query);
			}
		}$bdd->commit();
		$this->loadRessources();
		return true;
	}

	public function loadRessources(){
		global $bdd;
		$this->ressources = array();
				
		$query = "SELECT 		agrr.ref_agenda, agrr.ref_ressource, ress.lib_ressource
							FROM 			agendas_reservations_ressource agrr
							LEFT JOIN ressources ress ON agrr.ref_ressource = ress.ref_ressource
							WHERE 		agrr.ref_agenda = '".$this->getRef_agenda()."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
			$this->ressources[] = array("ref_agenda" => $r->ref_agenda, "ref_ressource" => $r->ref_ressource, "lib_ressource" => stripslashes($r->lib_ressource));
		while ($r = $resultat->fetchObject())
			$this->ressources[] = array("ref_agenda" => $r->ref_agenda, "ref_ressource" => $r->ref_ressource, "lib_ressource" => stripslashes($r->lib_ressource));
	}
			
	public function AGENDA_ID_REFERENCE_TAG()
	{		return AgendaReservationRessource::_AGENDA_ID_REFERENCE_TAG();}

	public function getId_type_agenda()
	{		return AgendaReservationRessource::_getId_type_agenda();}

	public function setLib_type($lib_type)
	{		return AgendaReservationRessource::_setLib_type();}
	
	public function loadType_informations()
	{		return AgendaReservationRessource::_loadType_informations();}
	
	public function getLib_type()
	{		return AgendaReservationRessource::_getLib_type();}

	// *************************************************************************************************************
	// ATTRIBUTS ET FONCTIONS "STATIC"
	// *************************************************************************************************************

	public static function _AGENDA_ID_REFERENCE_TAG()
	{		return 32;}
	
	// RENSEIGNEMENT SUR LE TYPE D'AGENDA **************************************************************************
	
	//voir dans la BD la table : AGENDAS_TYPES
	public static function _getId_type_agenda()		//smallint(5) 	unsigned NOT NULL
	{		return 3;}
	
	private static $lib_type;					//varchar(64) 	NOT NULL
	
	public static function _setLib_type($lib_type){
		global $bdd;
		$query = "UPDATE agendas_types SET lib_type_agenda = '".$lib_type."'
							WHERE id_type_agenda = '".getId_type_agenda()."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())return false;
		AgendaReservationRessource::$lib_type = $lib_type;
	}
	
	public static function _getLib_type()
	{	if(AgendaReservationRessource::$lib_type == "")
		{		AgendaReservationRessource::_loadType_informations();}	
		return AgendaReservationRessource::$lib_type;
	}
	
	public static function _loadType_informations(){
		global $bdd;
		$query = "SELECT 	agt.id_type_agenda, agt.lib_type_agenda
							FROM 		agendas_types  agt
							WHERE 	agt.id_type_agenda = ".AgendaReservationRessource::_getId_type_agenda();
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		AgendaReservationRessource::$lib_type = 	stripslashes($r->lib_type_agenda);
	}
	
}

// *************************************************************************************************************
// CLASSE AgendaContact
// *************************************************************************************************************
class AgendaContact extends Agenda{

	private $contact; //obj contact
	
	// *************************************************************************************************************
	// CONSTRUCTEUR
	// *************************************************************************************************************
	
	public function __construct($ref_agenda){
		global $bdd;
		
		$query = "SELECT 		agc.ref_agenda, agc.ref_contact
							FROM 			agendas_contact agc
							WHERE 		agc.ref_agenda = '".$ref_agenda."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		$this->contact = new contact($r->ref_contact);
		
		if(AgendaContact::$lib_type == null || AgendaContact::$lib_type == "")
			AgendaContact::_loadType_informations();
		
		if(!parent::__construct($ref_agenda))
			return false;
	}
	
	public final static function &newAgendaContact($lib_agenda, $ref_contact, $id_agenda_style_rule){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || $ref_contact == null || $ref_contact == "" || !is_numeric($id_agenda_style_rule)) return false;
				
		$reference = new reference(AgendaContact::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$query_a = "
			INSERT INTO agendas
			(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_style_rule) VALUES
			('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaContact::_getId_type_agenda()."', ".$id_agenda_style_rule.")";
		$query_b = "INSERT INTO agendas_contact
			(		ref_agenda, 				ref_contact) VALUES
			('".$ref_agenda."', '".$ref_contact."')";
		
		$bdd->beginTransaction();{
			$bdd->exec ($query_a);
			$bdd->exec ($query_b);
		}$bdd->commit();
		$agenda = new AgendaContact($ref_agenda); 
		return $agenda;
	}
	
	public static function _delete($ref_agenda){
		global $bdd;
				
		if ($ref_agenda == null || $ref_agenda == "") return false;

		$query = "SELECT  ag.id_agenda_style_rule
							FROM 		agendas ag
							WHERE 	ag.ref_agenda = '".$ref_agenda."'";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		$id_agenda_style_rule = $r->id_agenda_style_rule;

		$query_a = "DELETE  FROM  agendas 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_b = "DELETE  FROM  agendas_contact 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_c = "DELETE  FROM  agenda_style_rules 
								WHERE id_agenda_style_rule = ".$id_agenda_style_rule;
		
		$bdd->beginTransaction();{
			$bdd->exec ($query_a);
			$bdd->exec ($query_b);
			$bdd->exec ($query_c);
		}$bdd->commit();
		return true;
	}
	
	// *************************************************************************************************************
	// Getters & Setters
	// *************************************************************************************************************
	//Cerataines fonctions sont redondante avec les fonctions "static" -> normales, c'est plus simple à utiliser
	
	public function getContact()
	{		return $this->contact;}
	
	public function getRef_contact()
	{		return $this->contact->getRef_contact();}
	
	public function setRef_contact($ref_contact)
	{		if($ref_contact == null || $ref_contact == "")return false;
			if($this->contact->getRef_contact() != $ref_contact){
				$contact = new contact($ref_contact);
				if($contact->getRef_contact() == "")return false;
				global $bdd;
				$query = "UPDATE agendas_contact SET ref_contact = '".$ref_contact."'
								WHERE ref_agenda = '".$this->getRef_agenda()."' ";
				$bdd->query ($query);
				$this->contact =$ $contact;
			}
			return true;
	}
	
	public function AGENDA_ID_REFERENCE_TAG()
	{		return AgendaContact::_AGENDA_ID_REFERENCE_TAG();}

	public function getId_type_agenda()
	{		return AgendaContact::_getId_type_agenda();}

	public function loadAgenda_style_rules()
	{		return AgendaLoacationMateriel::_loadAgenda_style_rules();}
		
	public function setLib_type($lib_type)
	{		return AgendaContact::_setLib_type();}
	
	public function loadType_informations()
	{		return AgendaContact::_loadType_informations();}
	
	public function getLib_type()
	{		return AgendaContact::_getLib_type();}
	
	// *************************************************************************************************************
	// ATTRIBUTS ET FONCTIONS "STATIC"
	// *************************************************************************************************************

	public static function _AGENDA_ID_REFERENCE_TAG()
	{		return 33;}
	
	// RENSEIGNEMENT SUR LE TYPE D'AGENDA **************************************************************************
	
	//voir dans la BD la table : AGENDAS_TYPES
	public static function _getId_type_agenda()		//smallint(5) 	unsigned NOT NULL
	{		return 2;}
	private static $lib_type;					//varchar(64) 	NOT NULL
	
	public static function _setLib_type($lib_type){
		global $bdd;
		$query = "UPDATE agendas_types SET lib_type_agenda = '".$lib_type."'
							WHERE id_type_agenda = '".getId_type_agenda()."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())return false;
		AgendaContact::$lib_type = $lib_type;
	}
	
	public static function _loadType_informations(){
		global $bdd;
		$query = "SELECT 	agt.id_type_agenda, agt.lib_type_agenda
							FROM 		agendas_types  agt
							WHERE 	agt.id_type_agenda = ".AgendaContact::_getId_type_agenda();
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		AgendaContact::$lib_type = 	stripslashes($r->lib_type_agenda);
	}
	
	public static function _getLib_type()
	{	if(AgendaContact::$lib_type == "")
		{		AgendaContact::_loadType_informations();}	
		return AgendaContact::$lib_type;
	}

}

// *************************************************************************************************************
// CLASSE AgendaLoacationMateriel
// *************************************************************************************************************
class AgendaLoacationMateriel extends Agenda{

	private $article; //obj article
	private $ref_article;
	
	// *************************************************************************************************************
	// CONSTRUCTEUR
	// *************************************************************************************************************
	
	public function __construct($ref_agenda){
		global $bdd;
		
		$query = "SELECT 		aglm.ref_agenda, aglm.ref_article
							FROM 			agendas_location_materiel aglm
							WHERE 		aglm.ref_agenda = '".$ref_agenda."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		$this->ref_article = $r->ref_article;
		//$this->article = new article($r->ref_article);
		
		if(AgendaLoacationMateriel::$lib_type == null || AgendaLoacationMateriel::$lib_type == "")
			AgendaLoacationMateriel::_loadType_informations();
		
		if(!parent::__construct($ref_agenda))
			return false;
	}
	
	public final static function &newAgendaLoacationMateriel($lib_agenda, $ref_article, $id_agenda_style_rule){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || $ref_article == null || $ref_article == "" || !is_numeric($id_agenda_style_rule)) return false;
				
		$reference = new reference(AgendaLoacationMateriel::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$query_a = "INSERT INTO agendas
			(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_style_rule) VALUES
			('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaLoacationMateriel::_getId_type_agenda()."', ".$id_agenda_style_rule.")";
		$query_b = "INSERT INTO agendas_location_materiel
			(		ref_agenda, 				ref_article) VALUES
			('".$ref_agenda."', '".$ref_article."')";
		
		$bdd->beginTransaction();{
			$bdd->exec ($query_a);
			$bdd->exec ($query_b);
		}$bdd->commit();
		$agenda = new AgendaLoacationMateriel($ref_agenda); 
		return $agenda;
	}
	
	public static function _delete($ref_agenda){
		global $bdd;
				
		if ($ref_agenda == null || $ref_agenda == "") return false;

		$query = "SELECT  ag.id_agenda_style_rule
							FROM 		agendas ag
							WHERE 	ag.ref_agenda = '".$ref_agenda."'";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		$id_agenda_style_rule = $r->id_agenda_style_rule;

		$query_a = "DELETE  FROM  agendas 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_b = "DELETE  FROM  agendas_location_materiel 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_c = "DELETE  FROM  agenda_style_rules 
								WHERE id_agenda_style_rule = ".$id_agenda_style_rule;
		
		$bdd->beginTransaction();{
			$bdd->exec ($query_a);
			$bdd->exec ($query_b);
			$bdd->exec ($query_c);
		}$bdd->commit();
		return true;
	}
	
	// *************************************************************************************************************
	// Getters & Setters
	// *************************************************************************************************************
	//Cerataines fonctions sont redondante avec les fonctions "static" -> normales, c'est plus simple à utiliser
	public function getArticle()
	{	if($this->article == null)
				$this->article = new article($this->ref_article);
		return $this->article;
	}
	
	public function getRef_article()
	{		return $this->ref_article;}
	
	public function setRef_article($ref_article){
		if($ref_article == null || $ref_article == "")return false;
		if($this->ref_article != $ref_article){
			$article = new article($ref_article);
			if($article->getRef_article() == "")return false;
			global $bdd;
			$query = "UPDATE agendas_location_materiel SET ref_article = '".$ref_article."'
							WHERE ref_agenda = '".$this->getRef_agenda()."' ";
			$bdd->query ($query);
			$this->article =& $article;
		}
		return true;
	}
	
	public function AGENDA_ID_REFERENCE_TAG()
	{		return AgendaLoacationMateriel::_AGENDA_ID_REFERENCE_TAG();}

	public function getId_type_agenda()
	{		return AgendaLoacationMateriel::_getId_type_agenda();}

	public function setLib_type($lib_type)
	{		return AgendaLoacationMateriel::_setLib_type();}
	
	public function loadType_informations()
	{		return AgendaLoacationMateriel::_loadType_informations();}
	
	public function getLib_type()
	{		return AgendaLoacationMateriel::_getLib_type();}


		
	// *************************************************************************************************************
	// ATTRIBUTS ET FONCTIONS "STATIC"
	// *************************************************************************************************************

	public static function _AGENDA_ID_REFERENCE_TAG()
	{		return 34;}
	
	// RENSEIGNEMENT SUR LE TYPE D'AGENDA **************************************************************************
	
	//voir dans la BD la table : AGENDAS_TYPES
	public static function _getId_type_agenda()		//smallint(5) 	unsigned NOT NULL
	{		return 1;}
	private static $lib_type;					//varchar(64) 	NOT NULL
	
	public static function _setLib_type($lib_type){
		global $bdd;
		$query = "UPDATE agendas_types SET lib_type_agenda = '".$lib_type."'
							WHERE id_type_agenda = '".getId_type_agenda()."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())return false;
		AgendaLoacationMateriel::$lib_type = $lib_type;
	}
	
	public static function _loadType_informations(){
		global $bdd;
		$query = "SELECT 	agt.id_type_agenda, agt.lib_type_agenda
							FROM 		agendas_types  agt
							WHERE 	agt.id_type_agenda = ".AgendaLoacationMateriel::_getId_type_agenda();
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject()) return false;
		AgendaLoacationMateriel::$lib_type = 	stripslashes($r->lib_type_agenda);
	}

	public static function _getLib_type()
	{	if(AgendaLoacationMateriel::$lib_type == "")
		{		AgendaLoacationMateriel::_loadType_informations();}	
		return AgendaLoacationMateriel::$lib_type;
	}
	
}
?>