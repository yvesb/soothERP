<?php
// *************************************************************************************************************
// Ajout d'un évènement
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//traitement des données transmises


if (!$_REQUEST['date_evenement'] || !$_REQUEST['lib_evenement'] || !$_REQUEST['cout']) {	
								?>
								<SCRIPT type="text/javascript">
								alert('Veuillez remplir tous les champs'); 
								</SCRIPT>
								<?php
								}
								else {
	$id_vehicule = $_REQUEST['id_vehicule'];
	$date_evenement = date_Fr_to_Us ($_REQUEST['date_evenement']);
	$lib_evenement = addslashes($_REQUEST['lib_evenement']);
	$cout = $_REQUEST['cout'];
	add_evenement($id_vehicule, $date_evenement, $lib_evenement, $cout);
			}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_evenement_add.inc.php");
?>