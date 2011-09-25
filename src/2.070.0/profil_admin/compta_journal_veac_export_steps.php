<?php
// *************************************************************************************************************
// 
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//	get obj compta_export from session
// 	use static method
$compta_export = compta_export::obj_getfromsession( 'compta_export' );
//$compta_export->debug_debugMe_all(2);//	require DebugMe class
$compta_export->debug_get_infostring();
//	traitements
//	from posted steps 
switch ( $_REQUEST['step'] ){
	//	step 1 :
	//	verif & set dates
	//	next step automatique
	case "1":
		$script ="";
		$compta_export->set_etat(1);
		$form['date_debut'] = "" ;
		if (isset($_REQUEST['date_debut'])) {
			$form['date_debut'] = $_REQUEST['date_debut'];
			$search['date_debut'] = $_REQUEST['date_debut'];
		}
		$form['date_fin'] = "" ;
		if (isset($_REQUEST['date_fin'])) {
			$form['date_fin'] = $_REQUEST['date_fin'];
			$search['date_fin'] = $_REQUEST['date_fin'];
		}
		$form['date_exercice"'] = "" ;
		if (isset($_REQUEST['date_exercice'])) {
			$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
			$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
			$search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
			$search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
		}
		$compta_export->set_datedebut($search['date_debut']);
		$compta_export->set_datefin($search['date_fin']);
		// *************************************************************************************************************
		// Script to Eval
		?>
		<script type="text/javascript">
			compta_export_next_step (2);
			$("div_export_choix_step_2").show();
			<?php print $script;?>							
		</script>
		<?php 	
		// *************************************************************************************************************
		break;
	//	step 2
	//	load: liste journaux & liste logiciels
	//	next step : wait action
	case "2":
		$compta_export->set_etat(2);
		$script = "";		
		if( $options = $compta_export->getListe_journaux_selectformated() ){
			foreach($options as $option) {
					$script .= "\r\n compta_export_add_option ('".$option->id."','".$option->value."','".$option->selected."','id_journaux[]' );"; 
			}//end foreach
		} else {
			$script .= "\r\n compta_export_no_options('id_journaux[]');";
		}
		if( $options = $compta_export->getListe_logiciels_selectformated() ){
			foreach($options as $option) {
				$script .= "\r\n compta_export_add_option ('".$option->id."','".$option->value."','".$option->selected."','id_logiciel' );"; 
			}//end foreach
		} else {
			$script .= "\r\n compta_export_no_options('id_logiciel');";
		}//end if
		// *************************************************************************************************************
		// JScript to Eval
		?>
		<script type="text/javascript">
			compta_export_reset_select('id_journaux[]');
			compta_export_reset_select('id_logiciel');
			<?php print $script;?>							
		</script>
		<?php 	
		// *************************************************************************************************************
		break;
	//	step 3:
	//	set : journaux selectionés, logiciel selectionés
	//	set : liste des modeles dispo. en fonction
	//	nex step : wait action
	case "3": 
		$compta_export->set_etat(3);
		$compta_export->set_idjournaux ($_REQUEST['id_journaux']) ;
		$compta_export->set_idlogiciel ($_REQUEST['id_logiciel']) ;
		$step = $compta_export->process_valid('4');
		$script = "";
		if ( $step == false ) { 
		?>
			<script type="text/javascript">
			$('progress_barre').hide();
			$('export_progress').style.width = '0%';
			$('export_etat').innerHTML = "Pas de modèle disponibles pour cette selection (contactez nous) ";
			$("lancer").hide();
			$("continuer").hide();
			$("cancel").show();	
			$("div_export_choix_step_4").show();				
			</script>
		<?php 
			break; }
		
		/*
		$script .= "\r\n compta_export_reset_select('id_modeles');";
		if( $options = $compta_export->getListe_modeles_selectformated() ){
			foreach($options as $option) {
			$script .= "\r\n compta_export_add_option ('".$option->id."','".$option->value."','".$option->selected."','id_modeles' );";
			}
		}else{
			$script .= "\r\n compta_export_no_options('id_modeles');";
		}
		//$script .= "\r\n compta_export_add_option('0','Nouveau','id_modeles');";		
		 *
		 */			
		// *************************************************************************************************************
		// JScript to Eval
		?>
		<script type="text/javascript">
			$('progress_barre').show();
			$('export_progress').style.width = '0%';
			$('export_etat').innerHTML = "Lancer l'exportation ... ";
			$("lancer").show();
			$("continuer").hide();
			$("cancel").show();
			$("div_export_choix_step_4").show();
			<?php print $script;?>							
		</script>
		<?php 	
		// *************************************************************************************************************
		break;
	//	step 4 :
	//	selon modele selectioné
	//		* nouveau : formulaire de creation d'un nouveau modele
	//		* affect sinon
	//	next step : wait action
	case "4":
		//	checklist
		$compta_export->set_etat(4);
		$script ="";
		// affichage
		// *************************************************************************************************************
		// JScript to Eval
		?>
		<script type="text/javascript">
			$('progress_barre').show();
			$('export_progress').style.width = '0%';
			$('export_etat').innerHTML = "Lancer l'exportation ... ";
			$("lancer").show();
			$("continuer").hide();
			$("cancel").show();
			<?php print $script;?>							
		</script>
		<?php
		// *************************************************************************************************************
		break;
	//	step 4 : path 1
	//	verification des valeurs
	//	nex step : path 2 : automatique
	case "4a":
		//	clean l'instance des recherches précédentes
		$compta_export->obj_cleanup();
		$compta_export->set_etat(4);
		//	checklist
		$step = $compta_export->process_valid('4a');
		if ( $step == false ) { print " Erreur : ".$compta_export->debug_get_infostring(); break; }
		$script ="";
		// affichage
		// *************************************************************************************************************
		// JScript to Eval
		?>
		<script type="text/javascript">
			$('progress_barre').show();
			$('export_progress').style.width = '0%';
			$('export_etat').innerHTML = "Verifications des informations ...";
			$("lancer").hide();
			$("continuer").hide();
			$("cancel").hide();
			compta_export_valid(4,'b');
			<?php print $script;?>	
		</script>
		<?php
		// *************************************************************************************************************
		break;
	// 	step 4 : path 2
	//	lancement de l'exportation
	//	next step : automatique		
	case "4b":
		$script ="";
		// affichage
		//	si le traitement n'est pas validé , break
		$step = $compta_export->process_valid('4b');
		if ( $step == false ) { print " Erreur : ".$compta_export->debug_get_infostring(); break; }
		$type_process = $compta_export->get_process_type();
		//	progress bar
		if ($effectue_pcent = $compta_export->get_process_pourcentage()){
			$export_etat_string = "Recherche des écritures - "
				.$compta_export->get_process_type()
				." "
				.$compta_export->get_process_cheminement()
				." - ".$effectue_pcent."%";
		} else {
			//	no process
			$export_etat_string = "Attente de réponse du serveur.";
		}
		// *************************************************************************************************************
		// JScript to Eval
		?>
		<script type="text/javascript">
			$('progress_barre').show();
			$("export_progress").style.width = "<?php print $effectue_pcent; ?>%";
			$("export_etat").innerHTML = "<?php print $export_etat_string; ?>";
			$("lancer").hide();
			$("continuer").hide();
			$("cancel").hide();
			compta_export_valid(4,'<?php print $step; ?>');
			<?php print $script;?>							
		</script>
		<?php
		// *************************************************************************************************************
		break;
	// 	step 4 : path 3
	//	export terminé, reset form
	//	next step : disable step 2,3 & 4, wait action
	case "4c":
		$script =""; 
		if ($effectue_pcent = $compta_export->get_process_pourcentage() && $nb_export = $compta_export->get_process_nbexports ()){
			$links = $compta_export->get_fic_urlformated();
			$export_etat_string = "Exportation termin&eacute;e :<br>";
			foreach ($links as $link){
				$export_etat_string .= "<a href=\'".$link->href."\' target=\'_blank\'>".$link->href."</a><br>";
			}
		} else {
			//	no process
			$export_etat_string = "Aucune informations à exporter.";
		}
		// affichage
		// *************************************************************************************************************
		// JScript to Eval
		?>
		<script type="text/javascript">
			$("continuer").show();
			$("export_etat").innerHTML = "<?php print $export_etat_string;?>";
			$('progress_barre').hide();
			$("cancel").hide();
			$("lancer").hide();
			compta_export_end();
			<?php print $script;?>							
		</script>
		<?php
		// *************************************************************************************************************
		break;		
	case "cancel":
		//	on overwrite l'instance de l'objet
		$compta_export = new compta_export();
		break;	
	}
	compta_export::obj_setinsession($compta_export, 'compta_export');	
?>