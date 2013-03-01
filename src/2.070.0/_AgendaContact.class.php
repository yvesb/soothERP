<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS SUR UN AGENDA
// *************************************************************************************************************
//  4 CLASSES
//	Agenda <: AgendaReservationRessource
//	Agenda <: AgendaContact
//	Agenda <: AgendaLoacationMateriel


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
							FROM 			agendas_types_contacts agc
							WHERE 		agc.ref_agenda = '".$ref_agenda."' ";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false;
		$this->contact = new contact(($r->ref_contact));
		
		if(AgendaContact::$lib_type == null || AgendaContact::$lib_type == "")
			AgendaContact::_loadType_informations();
		
		if(!parent::__construct($ref_agenda))
			return false;
	}
	
	public final static function &newAgendaContact($lib_agenda, $ref_contact, $id_agenda_couleurs){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || $ref_contact == null || $ref_contact == "" || !is_numeric($id_agenda_couleurs)) return false;
				
		$reference = new reference(AgendaContact::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$query_a = "
			INSERT INTO agendas
			(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_couleurs) VALUES
			('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaContact::_getId_type_agenda()."', ".$id_agenda_couleurs.")";
		$query_b = "INSERT INTO agendas_types_contacts
			(		ref_agenda, 				ref_contact) VALUES
			('".$ref_agenda."', '".$ref_contact."')";
		
		$bdd->beginTransaction();{
			$bdd->exec(($query_a));
			$bdd->exec(($query_b));
		}$bdd->commit();
		$agenda = new AgendaContact($ref_agenda); 
		return $agenda;
	}
	
	public final static function &newAgendaWithColorsContact($lib_agenda, $ref_contact, $couleur_1, $couleur_2, $couleur_3 = ""){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || $ref_contact == null || $ref_contact == "" || $couleur_1 == "" || $couleur_2 == "") return false;
				
		$reference = new reference(AgendaContact::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$bdd->beginTransaction();{
			$query_a = "INSERT INTO agendas_couleurs
									(id_agenda_couleurs, agenda_couleur_rule_1, agenda_couleur_rule_2, agenda_couleur_rule_3) VALUES
									(NULL, 				 			'".$couleur_1."', 			'".$couleur_2."', 		 '".$couleur_3."')";
			$bdd->exec($query_a);
			$id_agenda_couleurs = $bdd->lastInsertId();
			
			$query_b = "INSERT INTO agendas
									(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_couleurs) VALUES
									('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaContact::_getId_type_agenda()."', ".$id_agenda_couleurs.")";
			$query_c = "INSERT INTO agendas_types_contacts
									(		ref_agenda, 				ref_contact) VALUES
									('".$ref_agenda."', '".$ref_contact."')";

			$bdd->exec($query_b);
			$bdd->exec($query_c);
		}$bdd->commit();
		$agenda = new AgendaContact($ref_agenda); 
		return $agenda;
	}
	
	public static function _delete($ref_agenda){
		global $bdd;
				
		if ($ref_agenda == null || $ref_agenda == "") return false;

		$query = "SELECT  ag.id_agenda_couleurs
							FROM 		agendas ag
							WHERE 	ag.ref_agenda = '".$ref_agenda."'";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false;
		$id_agenda_couleurs = $r->id_agenda_couleurs;

		$query_a = "DELETE  FROM  agendas 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_b = "DELETE  FROM  agendas_types_contacts 
								WHERE ref_agenda = '".$ref_agenda."'";
		$query_c = "DELETE  FROM  agendas_couleurs 
								WHERE id_agenda_couleurs = ".$id_agenda_couleurs;
		
		$bdd->beginTransaction();{
			$bdd->exec(($query_a));
			$bdd->exec(($query_b));
			$bdd->exec(($query_c));
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
				$query = "UPDATE agendas_types_contacts SET ref_contact = '".$ref_contact."'
								WHERE ref_agenda = '".$this->getRef_agenda()."' ";
				$bdd->query(($query));
				$this->contact = $contact;
			}
			return true;
	}
	
	public function AGENDA_ID_REFERENCE_TAG()
	{		return AgendaContact::_AGENDA_ID_REFERENCE_TAG();}

	public function getId_type_agenda()
	{		return AgendaContact::_getId_type_agenda();}

	public function loadagendas_couleurs()
	{		return AgendaLoacationMateriel::_loadagendas_couleurs();}
		
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
		$query = "UPDATE agendas_types SET lib_type_agenda = '".addslashes($lib_type)."'
							WHERE id_type_agenda = '".getId_type_agenda()."' ";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject())return false;
		AgendaContact::$lib_type = $lib_type;
	}
	
	public static function _loadType_informations(){
		global $bdd;
		$query = "SELECT 	agt.id_type_agenda, agt.lib_type_agenda
							FROM 		agendas_types  agt
							WHERE 	agt.id_type_agenda = ".AgendaContact::_getId_type_agenda();
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false;
		AgendaContact::$lib_type = 	stripslashes($r->lib_type_agenda);
	}
	
	public static function _getLib_type()
	{	if(AgendaContact::$lib_type == "")
		{		AgendaContact::_loadType_informations();}	
		return AgendaContact::$lib_type;
	}

}

?>