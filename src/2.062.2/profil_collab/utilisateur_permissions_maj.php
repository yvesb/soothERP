<?php
// *************************************************************************************************************
// AJOUT OU SUPPRESSION DE PERMISSION D'UTILISATEURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

if (!$_SESSION['user']->check_permission ("1")){
	exit;
}


if (isset($_REQUEST["ref_user"]) && isset($_REQUEST["id_permission"]) && isset($_REQUEST["id_profil"])) {
	if (isset($_REQUEST["add_or_del"]) && $_REQUEST["add_or_del"] == 1) {
		//maj des permissions users
		$permissions_dependantes_inactives = charger_permissions_dependantes_inactives ($_REQUEST["id_permission"], $_REQUEST["ref_user"],true);
		 	if(count($permissions_dependantes_inactives) > 0){
		foreach($permissions_dependantes_inactives as $depends_id=>$depends_lib){
			fonctions::add_user_permission ($_REQUEST["ref_user"], $depends_id);
		}
	}
		fonctions::add_user_permission ($_REQUEST["ref_user"], $_REQUEST["id_permission"]);
	}
	if (isset($_REQUEST["add_or_del"]) && $_REQUEST["add_or_del"] == 0) {
		//maj des permissions users
		$permissions_dependantes = charger_permissions_dependantes_actives($_REQUEST["id_permission"], $_REQUEST["ref_user"],true);
		foreach($permissions_dependantes as $key=>$value){
			fonctions::del_user_permission ($_REQUEST["ref_user"], $key);
		}
		fonctions::del_user_permission ($_REQUEST["ref_user"], $_REQUEST["id_permission"]);
	}
	if (isset($_REQUEST["param_permissions"])) {
		echo "Maj permission!";
			fonctions::del_user_permission ($_REQUEST["ref_user"], $_REQUEST["id_permission"]);
			fonctions::add_user_permission ($_REQUEST["ref_user"], $_REQUEST["id_permission"],$_REQUEST["param_permissions"]);

		$liste_permissions_dependantes = charger_permissions_dependantes_meme_type ($_REQUEST["id_permission"],true);
		$liste_permissions_parentes = charger_permissions_parentes_meme_type ($_REQUEST["id_permission"],true);
		$utilisateur_permissions = charger_user_permissions($_REQUEST["ref_user"]);
		
		
		if(count($liste_permissions_dependantes) > 0 && isset($_REQUEST["param_permissions"])){
			echo "Maj permissions dependantes!<BR>";
			foreach($liste_permissions_dependantes as $depends_id=>$depends_lib){
						if(isset($utilisateur_permissions[$depends_id])){
							echo "Maj!:".$depends_id."<br>";
							$perms_maj = explode(',',$_REQUEST["param_permissions"]);
							echo "Droits concernés :<pre>".print_r($perms_maj)."</pre><BR>";
							$perms_dependante = explode(',',$utilisateur_permissions[$depends_id]->value);
							echo "Droits actuels :<pre>".print_r($perms_dependante)."</pre><BR>";
							foreach ($perms_dependante as $key=>$perm_dependante){
								if(!in_array($perm_dependante,$perms_maj)){
										unset($perms_dependante[$key]);
								}
							}
							fonctions::del_user_permission ($_REQUEST["ref_user"], $depends_id);
							echo "Maj du droit :".$depends_id." en :".implode(',',$perms_dependante)."<br>";
							if (count($perms_dependante) >0){
								fonctions::add_user_permission ($_REQUEST["ref_user"], $depends_id,implode(',',$perms_dependante));
							}						
				}
			}
		}
			if(count($liste_permissions_parentes) > 0 && isset($_REQUEST["param_permissions"])){
			echo "Maj permissions parentes!";
			foreach($liste_permissions_parentes as $depends_id=>$depends_lib){

						echo "Maj!:".$depends_id."<br>";
						$perms_maj = explode(',',$_REQUEST["param_permissions"]);
						if(isset($utilisateur_permissions[$depends_id])){
						$perms_parente = explode(',',$utilisateur_permissions[$depends_id]->value);
						}else{$perms_parente = array();}
						foreach ($perms_maj as $key=>$perm_maj){
							if(!in_array($perm_maj,$perms_parente)){
									$perms_parente[]=$perm_maj;
							}
						}
						fonctions::del_user_permission ($_REQUEST["ref_user"], $depends_id);
						echo "Maj du droit :".$depends_id." en :".implode(',',$perms_parente)."<br>";
						if (count($perms_parente) >0){
						fonctions::add_user_permission ($_REQUEST["ref_user"], $depends_id,implode(',',$perms_parente));
						}				
			}
		}
		
		$permissions_dependantes_inactives = charger_permissions_dependantes_inactives ($_REQUEST["id_permission"], $_REQUEST["ref_user"],true);
		
		if(count($permissions_dependantes_inactives) > 0){
			 	echo "Maj permissions encore inacives!";
			foreach($permissions_dependantes_inactives as $depends_id=>$depends_lib){
				fonctions::add_user_permission ($_REQUEST["ref_user"], $depends_id);
			}
		}
		
	}
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_utilisateur_permissions_maj.inc.php");

?>