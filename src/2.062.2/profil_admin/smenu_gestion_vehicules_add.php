<?php
// *************************************************************************************************************
// Ajout d'un véhicule
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//traitement des données transmises


if (!$_REQUEST['lib_vehicule'] || !$_REQUEST['marque'] || !$_REQUEST['attribution']) {	
								?>
								<SCRIPT type="text/javascript">
								alert('Veuillez remplir tous les champs'); 
								</SCRIPT>
								<?php
								}
								else {
	$lib_vehicule = addslashes($_REQUEST['lib_vehicule']);
	$marque = addslashes($_REQUEST['marque']);
	$attribution = addslashes($_REQUEST['attribution']);
	add_vehicules($lib_vehicule, $marque, $attribution);
			}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_add.inc.php");
?>