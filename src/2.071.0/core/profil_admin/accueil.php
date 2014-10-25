<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//fonction de supprimer
function supprimer_repertoire($dir)  { 
	if (is_dir($dir)) {
		$current_dir = opendir($dir); 
		while($entryname = readdir($current_dir))  { 
			if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!=".."))  { 
				supprimer_repertoire("${dir}/${entryname}"); 
			}  
			elseif($entryname != "." and $entryname!="..") { 
				unlink("${dir}/${entryname}"); 
			} 
		} //Fin tant que 
		
		closedir($current_dir); 
		rmdir(${dir}); 
	}
} 


//charger liste des taches admin
$taches_todo = tache_admin::charger_taches_todo ();
$taches_last_done = tache_admin::charger_taches_done ();

$profils_allowed = $_SESSION['user']->getProfils_allowed();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_accueil.inc.php");

?>