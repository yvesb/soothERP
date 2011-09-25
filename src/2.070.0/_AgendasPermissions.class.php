<?php

// *************************************************************************************************************
// CLASSE AgendasPermissions 
// *************************************************************************************************************
class AgendasPermissions{
	private $ref_agenda;
	private $agenda_permission; //int
	//$events_types_permission[ID_EVENT_TYPE] = int permission
	private $events_types_permission;
	
	public function __construct($ref_agenda, $agenda_permission, $events_types_permission){
		$this->ref_agenda = $ref_agenda;
		$this->agenda_permission = $agenda_permission;
		$this->events_types_permission = $events_types_permission;
	}
	
	public function getRef_agenda(){return $this->ref_agenda;}
	
	public function getAgenda_permission(){return $this->agenda_permission;}
	
	public function GetEvents_types_permission(){return $this->events_types_permission;}
	
	public function GetEvent_type_permission($id_type_event){
		if(isset($this->events_types_permission[$id_type_event]))
		{			return $this->events_types_permission[$id_type_event];}
		else{	return null;}
	}
	
// *************************************************************************************************************
}// FIN DE LA CLASSE GestionnaireAgendas 
// *************************************************************************************************************


?>