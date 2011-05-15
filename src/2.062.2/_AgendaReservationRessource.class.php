<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS SUR UN AGENDA
// *************************************************************************************************************
//  4 CLASSES
//	Agenda <: AgendaReservationRessource
//	Agenda <: AgendaContact
//	Agenda <: AgendaLoacationMateriel


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
	
	public final static function &newAgendaReservationRessource($lib_agenda, $tabRessources, $id_agenda_couleurs){
		//$tabRessources[] = ref_ressource
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || count($tabRessources)<=0 || !is_numeric($id_agenda_couleurs)) return false;
		
		$reference = new reference(AgendaReservationRessource::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$query_a = "INSERT INTO agendas
			(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_couleurs) VALUES
			('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaReservationRessource::_getId_type_agenda()."', ".$id_agenda_couleurs.")";
		
		$query_b = "INSERT INTO agendas_types_ressources(ref_agenda, ref_ressource) VALUES";
		foreach ($tabRessources as $ref_ressource){
			$query_b .= "('".$ref_agenda."', '".$ref_ressource."'),";
		}
		
		$query_b = substr($query_b, 0, -1);
		
		$bdd->beginTransaction();{
			$bdd->exec(($query_a));
			$bdd->exec(($query_b));
		}$bdd->commit();
		$ag = new AgendaReservationRessource($ref_agenda);
		return $ag;
	}
	
	public final static function &newAgendaWithColorsReservationRessource($lib_agenda, $tabRessources, $couleur_1, $couleur_2, $couleur_3 = ""){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || count($tabRessources) <= 0 || $couleur_1 == "" || $couleur_2 == "") return false;
		
		$reference = new reference(AgendaReservationRessource::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$bdd->beginTransaction();{
			$query_a = "INSERT INTO agendas_couleurs
									(id_agenda_couleurs, agenda_couleur_rule_1, agenda_couleur_rule_2, agenda_couleur_rule_3) VALUES
									(NULL, 				 			'".$couleur_1."', 			'".$couleur_2."', 		 '".$couleur_3."')";
			$bdd->exec($query_a);
			$id_agenda_couleurs = $bdd->lastInsertId();
			
			$query_b = "INSERT INTO agendas
				(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_couleurs) VALUES
				('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaReservationRessource::_getId_type_agenda()."', ".$id_agenda_couleurs.")";
			
			$query_c = "INSERT INTO agendas_types_ressources(ref_agenda, ref_ressource) VALUES";
			foreach ($tabRessources as $ref_ressource){
				$query_c .= "('".$ref_agenda."', '".$ref_ressource."'),";
			}
			
			$query_c = substr($query_c, 0, -1);

			$bdd->exec($query_b);
			$bdd->exec($query_c);
		}$bdd->commit();
		$ag = new AgendaReservationRessource($ref_agenda);
		return $ag;
	}
	
	public final static function _delete($ref_agenda){
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
		$query_b = "DELETE  FROM  agendas_types_ressources 
								WHERE 	ref_agenda = '".$ref_agenda."'";
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
	
	public function getRessources()
	{		return $this->ressources;}
	
	public function setRef_ressources($ref_ressources){
		if($ref_ressources == null || !is_array($ref_ressources))return false;
		global $bdd;
		$query = "";
		$bdd->beginTransaction();{
			for($i=0; $i<count($ref_ressources); $i++){
				$query = "UPDATE agendas_types_ressources SET ref_ressource  = '".$ref_ressources[$i]."'
									WHERE ref_agenda = '".$this->getRef_agenda()."';";
				$bdd->exec(($query));
			}
		}$bdd->commit();
		$this->loadRessources();
		return true;
	}

	public function loadRessources(){
		global $bdd;
		$this->ressources = array();
				
		$query = "SELECT 		agrr.ref_agenda, agrr.ref_ressource, ress.lib_ressource
							FROM 			agendas_types_ressources agrr
							LEFT JOIN ressources ress ON agrr.ref_ressource = ress.ref_ressource
							WHERE 		agrr.ref_agenda = '".$this->getRef_agenda()."' ";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false;
			$this->ressources[] = array("ref_agenda" => ($r->ref_agenda), "ref_ressource" => ($r->ref_ressource), "lib_ressource" => stripslashes($r->lib_ressource));
		while ($r = $resultat->fetchObject())
			$this->ressources[] = array("ref_agenda" => ($r->ref_agenda), "ref_ressource" => ($r->ref_ressource), "lib_ressource" => stripslashes($r->lib_ressource));
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
		$query = "UPDATE agendas_types SET lib_type_agenda = '".addslashes($lib_type)."'
							WHERE id_type_agenda = '".getId_type_agenda()."' ";
		$resultat = $bdd->query(($query));
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
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false;
		AgendaReservationRessource::$lib_type = 	stripslashes($r->lib_type_agenda);
	}
	
}

?>