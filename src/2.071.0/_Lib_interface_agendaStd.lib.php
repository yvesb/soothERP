<?php

  // ******************************* //
 // 						LMB
// ******************************* //
abstract /*static*/ class Lib_interface_agendaStd {
//	//public static __callStatic (string,  array $arguments  )
//	 public static function __callStatic($nameMethode, $arguments){
//	 		
//	 }

	
	public static function RESSOURCE_ID_REFERENCE_TAG()
	{		return 36;}
	
	public static function &getAgendas($types_agenda = array()){
		
		$agendas = array();
		
		global $bdd;
		$query = 'SELECT 	ag.ref_agenda, ag.id_type_agenda
							FROM agendas ag ';
		if(count($types_agenda) > 0)
		$query.= 'WHERE ag.ag.id_type_agenda IN {"'.implode('", "', $types_agenda).'"} ';
		$query.= 'ORDER BY ag.id_type_agenda ASC';
		
		
		$resultat = $bdd->query ($query);
		while($r = $resultat->fetchObject()){
			switch ($r->id_type_agenda) {
				case AgendaReservationRessource::_getId_type_agenda() :{
						$agendas[$r->ref_agenda] = new AgendaReservationRessource($r->ref_agenda);
						break;}
				case AgendaContact::_getId_type_agenda() :{
						$agendas[$r->ref_agenda] = new AgendaContact($r->ref_agenda);
						break;}
				case AgendaLoacationMateriel::_getId_type_agenda() :{
						$agendas[$r->ref_agenda] = new AgendaLoacationMateriel($r->ref_agenda);
						break;}
			}
		}
		return $agendas;
	}
	
	
	public static function getAllRessources_AgendaReservationRessource(){
		$ressources = array();
		
		global $bdd;
		$query = "SELECT 	r.ref_ressource, r.lib_ressource 
							FROM 		ressources r 
							ORDER BY r.lib_ressource ASC";
			
		$resultat = $bdd->query ($query);
		while($r = $resultat->fetchObject()){
			$ressources[$r->ref_ressource] = $r->lib_ressource; 
		}
		return $ressources;
	}
	
	//STRUCTURE :
	//resultat[id_type][lib_type]
	public static function getAllAgendaTypes(){
		$types = array();
		
		global $bdd;
		$query = "SELECT 	at.id_type_agenda, at.lib_type_agenda
							FROM 		agendas_types at
							ORDER BY at.lib_type_agenda ASC";
			
		$resultat = $bdd->query ($query);
		while($r = $resultat->fetchObject()){
			$types[intval($r->id_type_agenda)] = array("lib_type"=>stripslashes($r->lib_type_agenda)); 
		}
		return $types;
	}
	
	public static function &openAgenda($ref_agenda){
		$agenda = null;
		global $bdd;
	
		if($ref_agenda == null || $ref_agenda == "")return $agenda; // null
		
		$query = "SELECT 	ag.ref_agenda, ag.id_type_agenda
							FROM agendas ag
							WHERE ag.ref_agenda = '".$ref_agenda."'";
		
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())
			return $agenda; // = null
			
		switch (intval($r->id_type_agenda)) {
					case AgendaReservationRessource::_getId_type_agenda() :{
						$agenda = new AgendaReservationRessource($r->ref_agenda);
						break;}
				case AgendaContact::_getId_type_agenda() :{
						$agenda = new AgendaContact($r->ref_agenda);
						break;}
				case AgendaLoacationMateriel::_getId_type_agenda() :{
						$agenda = new AgendaLoacationMateriel($r->ref_agenda);
						break;}
				default: return $agenda; // = null
			}
			return $agenda;
	}
	
	
	public static function supprAgenda($ref_agenda){
		global $bdd;
	
		if($ref_agenda == null || $ref_agenda == "")return false;
		
		$query = "SELECT 	ag.ref_agenda, ag.id_type_agenda
							FROM agendas ag
							WHERE ag.ref_agenda = '".$ref_agenda."'";
		
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())
			return false;
			
		switch (intval($r->id_type_agenda)) {
			case AgendaReservationRessource::_getId_type_agenda() :{ return AgendaReservationRessource::_delete($r->ref_agenda);}
			case AgendaContact::_getId_type_agenda() 							:{ return AgendaContact::_delete($r->ref_agenda);}
			case AgendaLoacationMateriel::_getId_type_agenda() 		:{ return AgendaLoacationMateriel::_delete($r->ref_agenda);}
			default: return false;
		}
	}
	

	public static function grilleMoisFenetreAllEvent_getY($semaine, $nbSemaineMax, $nbLignes){
		if($semaine == $nbSemaineMax){
			//Nous sommes à la dernière ligne 
			//=> positionner la fenetre des événements vers le haut
			return "bottom: ".(60)."px;";
		}
		elseif($semaine == ($nbSemaineMax - 1)){
			//Nous sommes à l'avant dernière ligne 
			//=> positionner la fenetre des événements vers le haut
			return "bottom: ".(30)."px;";
		}else{
			//=> positionner la fenetre des événements vers le bas
			return "top:35px;";
		}
	}
	
	public static function grilleMoisFenetreAllEvent_getX($jour){
		switch ($jour){
			case 0 : case 1 : case 2 : case 3 : case 4 : {
				return "left:35px;"; 
			}
			case 5 : case 6 : {
				return "right:35px;";
			}
		}
	}
	
	
	//$agendasAvecDroits[REF_AGENDA] = array();
	//$agendasAvecDroits[REF_AGENDA]["libAgenda"] = string;
	//$agendasAvecDroits[REF_AGENDA]["affiche"] = bool;
	//$agendasAvecDroits[REF_AGENDA]["droits"] = int[];
	//$agendasAvecDroits[REF_AGENDA]["couleur1"] = string;
	//$agendasAvecDroits[REF_AGENDA]["couleur2"] = string;
	//$agendasAvecDroits[REF_AGENDA]["couleur3"] = string;
	//$agendasAvecDroits[REF_AGENDA]["id_type_agenda"] = int;
	//$agendasAvecDroits[REF_AGENDA]["lib_type_agenda"] = string;
	public static function buildSelectOptionsAgenda(&$agendasAvecDroits, $droitsUserAgendas){
		$res = "";
		$last_id = -1;
		$count = 0;
		reset($agendasAvecDroits);
		$agenda_selected = $_REQUEST["cook_agenda_selected"];
		for ($i = 0; $i< count($agendasAvecDroits); $i++){
			$index = key($agendasAvecDroits);
			$eventsTypesAvecDroitFirstAg = $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsTypesAvecDroits($agendasAvecDroits[$index]["id_type_agenda"]/*, $droitsCibles*/);
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT] = array();
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["libEvent"] = string;
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["affiche"] = bool;
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["droits"] = int[];
			if(count($eventsTypesAvecDroitFirstAg) > 0){
				if ($agendasAvecDroits[$index]["id_type_agenda"] != $last_id ) {
					$last_id = $agendasAvecDroits[$index]["id_type_agenda"];
					$res .= '<optgroup disabled="disabled" label="'.$agendasAvecDroits[$index]["lib_type_agenda"].'" ></optgroup>';
				}
				if(isset($droitsUserAgendas[$index][3])){
					if($droitsUserAgendas[$index][3]==0){
						$count++;
						if($i==$agenda_selected){
							$res .= '<option value="'.$index.'" selected="selected" >';
						}
						else{
							$res .= '<option value="'.$index.'" >';
						}
						$res .= $agendasAvecDroits[$index]["libAgenda"];
						$res .= '</option>';
					}					
				}else{
					if($i==0){
						$res .= '<option value="'.$index.'" selected="selected" >';
					}
					else{
						$res .= '<option value="'.$index.'" >';
					}
					$res .= $agendasAvecDroits[$index]["libAgenda"];
					$res .= '</option>';
				}
			}
			next($agendasAvecDroits);
		}
		if($count < 1){
			$res .= '<option value=0 >Aucun agenda disponible</option>';
		}
		return $res;
	}

		//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT] = array();
	//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["libEvent"] = string;
	//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["affiche"] = bool;
	//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["droits"] = int[];
	public static function buildSelectOptionsEventType(&$eventsTypesAvecDroitOfAg){
		$res = "";
		reset($eventsTypesAvecDroitOfAg);
		$agenda_selected = $_REQUEST["cook_agenda_selected"];
		for ($i = 0; $i< count($eventsTypesAvecDroitOfAg); $i++){
			$index = key($eventsTypesAvecDroitOfAg); 
			if($i==$agenda_selected)
			{			$res .= '<option value="'.$index.'" selected="selected" >';}
			else{	$res .= '<option value="'.$index.'" >';}
			$res .= $eventsTypesAvecDroitOfAg[$index]["libEvent"];
			$res .= '</option>';
			next($eventsTypesAvecDroitOfAg);
		}
		return $res;
	}
}
?>