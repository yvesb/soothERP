<?php
// *************************************************************************************************************
// Modification des évènements des véhicules
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//mise à jour des données transmises

if (!$_REQUEST['date_evenement_'.$_REQUEST['id_evenement']] || !$_REQUEST['lib_evenement_'.$_REQUEST['id_evenement']] || !$_REQUEST['cout_'.$_REQUEST['id_evenement']]) {	
								?>
								<SCRIPT type="text/javascript">
								alert('Veuillez remplir tous les champs'); 
								</SCRIPT>
								<?php
								}
								else {



	global $bdd;
	$id_evenement = $_REQUEST['id_evenement'];
	$query = "SELECT id_vehicule FROM mod_vehicules_evenements WHERE id_evenement = '".$id_evenement."' ";
	$resultat = $bdd->query ($query);
	$evenement = $resultat->fetchObject();
	$id_vehicule = $evenement->id_vehicule;
	
	$date_evenement = date_Fr_to_Us ($_REQUEST['date_evenement_'.$_REQUEST['id_evenement']]);
	$lib_evenement = addslashes($_REQUEST['lib_evenement_'.$_REQUEST['id_evenement']]);
	$cout = $_REQUEST['cout_'.$_REQUEST['id_evenement']];

	maj_evenement($_REQUEST['id_evenement'], $date_evenement, $lib_evenement, $cout);

								}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_evenements_maj.inc.php");
?>