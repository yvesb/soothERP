<?php
// *************************************************************************************************************
// SCRIPT DE MISE A JOUR DE LA SOLUTION LUNDI MATIN BUSINESS
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
$_SERVER['MAJ_EN_COURS'] = 1;

require ("_dir.inc.php");
require ($DIR."_session.inc.php");
require ($DIR."_maj.class.php");

set_time_limit(600);	// Fixe la durée d'execution du script à 10 minutes.


// *************************************************************************************************************
// Controle de la nécessité de mettre à jour
$version_file[0] = "0";
if($ACTIVE_MAJ)
	$version_file = file ($MAJ_SERVEUR['url']."check_version.php?version_actuelle=".$_SERVER['VERSION']);

if ($version_file[0] == "0") { 
	echo "Aucune mise à jour nécessaire";
	exit; 
}
$last_version =  str_replace("\n", "", $version_file[0]);
$new_version =  str_replace("\n", "",$version_file[1]);


// Réception de paramètres communiqués par le serveur et à utiliser dans le script (Nouvelle version + Parametres FTP)
for ($i=2; $i<count($version_file); $i++) {
	if (!eval($version_file[$i])) {
		$GLOBALS['_ALERTES']['bad_eval_params'] = nl2br($version_file[$i]);
	}
}



// *************************************************************************************************************
// Initialisation de la mise à jour
$maj = new maj_serveur($new_version);

// Téléchargement des fichiers de mise à jour
if ($maj->last_break_point <= 1) {
	$maj->get_maj_files (1);		// Tous les fichiers de MAJ 
}
else {
	$maj->get_maj_files (0);		// Juste les fichiers de MAJ standard
}
$maj->set_break_point(1);

$maj->stop_serveur();
// Remplacement des fichiers de LMB par leur nouvelle version
if ($maj->last_break_point <= 2) {
	$maj->synchronise_files ();
}
$maj->set_break_point(2);


// *************************************************************************************************************
// Action spécifiques à la mise à jour
if ($maj->last_break_point <= 101) {
	$GLOBALS['_INFOS']['maj_actions'][] = "-----------------------------------------------------------------------";
	if (is_file ($DIR."echange_lmb/maj_lmb_".$new_version."/maj.php")) { 
	$maj->make_download_state (95, "Mise &agrave; jour vers version ".$new_version." en cours", "Execution des requ&ecirc;tes SQL", "");
		$GLOBALS['_INFOS']['maj_actions'][] = "<i>Actions spécifiques à effectuer</i>";
		require_once($DIR."echange_lmb/maj_lmb_".$new_version."/maj.php"); 
	}
	else {
		$GLOBALS['_INFOS']['maj_actions'][] = "<i>Aucune action spécifique à effectuer</i>";
	}
	$GLOBALS['_INFOS']['maj_actions'][] = "-----------------------------------------------------------------------";
}
if ($maj->last_break_point <= 101) {
	$maj->set_break_point(101);
}


// *************************************************************************************************************
// Fin de la mise à jour

if ($maj->last_break_point <= 103) {
	$maj->maj_version();
}
$maj->set_break_point(103);


$maj->unset_break_point();
$maj->start_serveur();
$maj->flush_tmp_files();
$GLOBALS['_INFOS']['maj_actions'][] = "<b>DEBUT DE LA MISE A JOUR VERS LMB v".$new_version."</b>";



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$maj->show_maj_procedure ();
?>
<SCRIPT type="text/javascript">
<?php 
if ($last_version != $new_version) {
	?>
	var AppelAjax = new Ajax.Updater(
									"maj_viewer", 
									"maj_serveur.php", 
									{
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									evalScripts:true, 
									onLoading:S_loading, 
									onComplete: function(requester) {
																H_loading ();
																if (requester.responseText!="") {
																//	requester.responseText.evalScripts();
																}
															} 
									}
									);
	<?php } else { 
	?>
	stp_prog_file = true;
	$("files_progress").style.width = "100%";
	$("maj_etat").innerHTML = "Mise à jour effectuée avec succès";
	setTimeout('	window.open("<?php echo $_ENV['CHEMIN_ABSOLU']."site/__user_login.php?page_from=profil_admin/#import_maj_serveur.php";?>", "_self")', 5000);
	<?php
	if (isset($_SESSION['NEW_MAJ_DISPO'])) {
		if ($_SESSION['NEW_MAJ_DISPO'] != $new_version) {
			?>
	$("maj_etat").innerHTML = "Mise à jour effectuée avec succès<br/> D'autres mises à jours sont disponibles.<br/> Veuillez revenir sur cette page après ré identification";
			<?php
		}
		unset($_SESSION['NEW_MAJ_DISPO']);
	}
}
?>
</SCRIPT>