<?php
// *************************************************************************************************************
// Ajout d'un type de pièce jointe
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//traitement des données transmises


if (!$_REQUEST['lib_type_add'] || !$_REQUEST['abrev_type_add'] ) {	
								?>
								<SCRIPT type="text/javascript">
								alert('Veuillez remplir tous les champs'); 
								</SCRIPT>
								<?php
								}
								else {
	$abrev_type = $_REQUEST['abrev_type_add'];
	$lib_type = $_REQUEST['lib_type_add'];
	add_types_ged($lib_type, $abrev_type);
			}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_entreprise_ged_add.inc.php");
?>