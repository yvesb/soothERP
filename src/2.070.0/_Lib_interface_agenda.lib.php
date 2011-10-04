<?php

  // ******************************* //
 // 						LMB
// ******************************* //

abstract /*static*/ class Lib_interface_agenda extends Lib_interface_agendaStd{

	public static function afficher_bt_SelectionDesAgendasAffiches(){
		return false;
	}
	

	public static function Integrite_agendas_users_events_type_affiche_permissions(){
		global $bdd;
		$query = "
		INSERT IGNORE INTO agendas_users_events_type_affiche_permissions
		(ref_user, id_type_event, affiche, id_permission)
		SELECT	u.ref_user, et.id_type_event, 1 as affiche, 0 as id_permission
		FROM 		users u
		JOIN		agendas_events_types et";
		
		return $bdd->exec($query) > 0;
	}

	

	
}

?>