<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS SUR UN AGENDA
// *************************************************************************************************************
//  4 CLASSES
//	Agenda <: AgendaReservationRessource
//	Agenda <: AgendaContact
//	Agenda <: AgendaLoacationMateriel


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
							FROM 			agendas_types_location aglm
							WHERE 		aglm.ref_agenda = '".$ref_agenda."' ";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject()) return false;
		$this->ref_article = ($r->ref_article);
		//$this->article = new article($r->ref_article);
		
		if(AgendaLoacationMateriel::$lib_type == null || AgendaLoacationMateriel::$lib_type == "")
			AgendaLoacationMateriel::_loadType_informations();
		
		if(!parent::__construct($ref_agenda))
			return false;
	}
	
	public final static function &newAgendaLoacationMateriel($lib_agenda, $ref_article, $id_agenda_couleurs){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || $ref_article == null || $ref_article == "" || !is_numeric($id_agenda_couleurs)) return false;
				
		$reference = new reference(AgendaLoacationMateriel::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$query_a = "INSERT INTO agendas
			(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_couleurs) VALUES
			('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaLoacationMateriel::_getId_type_agenda()."', ".$id_agenda_couleurs.")";
		$query_b = "INSERT INTO agendas_types_location
			(		ref_agenda, 				ref_article) VALUES
			('".$ref_agenda."', '".$ref_article."')";
		
		$bdd->beginTransaction();{
			$bdd->exec(($query_a));
			$bdd->exec(($query_b));
		}$bdd->commit();
		$agenda = new AgendaLoacationMateriel($ref_agenda); 
		return $agenda;
	}
	
	public final static function &newAgendaWithColorsLoacationMateriel($lib_agenda, $ref_article, $couleur_1, $couleur_2, $couleur_3 = ""){
		global $bdd;
		
		if ( $lib_agenda == null || $lib_agenda == "" || $ref_article == null || $ref_article == "" || $couleur_1 == "" || $couleur_2 == "") return false;
				
		$reference = new reference(AgendaLoacationMateriel::_AGENDA_ID_REFERENCE_TAG());
		$ref_agenda = $reference->generer_ref();

		$bdd->beginTransaction();{
			$query_a = "INSERT INTO agendas_couleurs
									(id_agenda_couleurs, agenda_couleur_rule_1, agenda_couleur_rule_2, agenda_couleur_rule_3) VALUES
									(NULL, 				 			'".$couleur_1."', 			'".$couleur_2."', 		 '".$couleur_3."')";
			$bdd->exec($query_a);
			$id_agenda_couleurs = $bdd->lastInsertId();
			
			$query_b = "INSERT INTO agendas
									(		ref_agenda, 				lib_agenda, 		 id_type_agenda, 			id_agenda_couleurs) VALUES
									('".$ref_agenda."', '".addslashes($lib_agenda)."', '".AgendaLoacationMateriel::_getId_type_agenda()."', ".$id_agenda_couleurs.")";
			$query_c = "INSERT INTO agendas_types_location
									(		ref_agenda, 				ref_article) VALUES
									('".$ref_agenda."', '".$ref_article."')";
			
			$bdd->exec($query_b);
			$bdd->exec($query_c);
		}$bdd->commit();
		$agenda = new AgendaLoacationMateriel($ref_agenda); 
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
		$query_b = "DELETE  FROM  agendas_types_location 
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
			$query = "UPDATE agendas_types_location SET ref_article = '".$ref_article."'
							WHERE ref_agenda = '".$this->getRef_agenda()."' ";
			$bdd->query(($query));
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
		$query = "UPDATE agendas_types SET lib_type_agenda = '".addslashes($lib_type)."'
							WHERE id_type_agenda = '".getId_type_agenda()."' ";
		$resultat = $bdd->query(($query));
		if (!$r = $resultat->fetchObject())return false;
		AgendaLoacationMateriel::$lib_type = $lib_type;
	}
	
	public static function _loadType_informations(){
		global $bdd;
		$query = "SELECT 	agt.id_type_agenda, agt.lib_type_agenda
							FROM 		agendas_types  agt
							WHERE 	agt.id_type_agenda = ".AgendaLoacationMateriel::_getId_type_agenda();
		$resultat = $bdd->query(($query));
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