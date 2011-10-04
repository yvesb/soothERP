<?php

// *************************************************************************************************************
//journal des ventes
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);


function nb_mois($date1, $date2) {
   list($year1,$month1,$day1) = explode("-",$date1);
   list($year2,$month2,$day2) = explode("-",$date2);
   return (($year2-$year1)*12 + ($month2-$month1));
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">	
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('compta_journal_veac_export','compta_journal_veac_export.php','true','sub_content', "Export des journaux des ventes et des achats");
update_menu_arbo();
</script>
<div id="dev_debug_compta_export"></div>
<form id="form_exportation" name="form_exportation" action="#" target="_blank">
<div id="div_export" class="emarge">
	<div id="div_export_titre" class="titre">
		Export des &eacute;critures des journaux des ventes et des achats
	</div>

	<div id="div_export_choix_step_1" class="contactview_corps" style="padding:8px">
		<table id="table_export" width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td colspan="4" class="titre_config" >Choix de la période à exporter :</td>
				<td style="text-align:center" width="20px" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="reset_all" style="cursor:pointer;"/></td>
			</tr>
			<tr>
				<td colspan="4" class="spacer">&nbsp;</td>
			</tr>
			<tr>
				<td style="width:85px">P&eacute;riode:&nbsp;&nbsp; </td>
				<td>
					<select id="date_exercice" name="date_exercice" class="classinput_nsize">
					<option value="--CHOISIR--">Choisissez la période</option>
					<?php
					for($i = 0; $i< count($liste_exercices); $i++) {
						//décompte du nombre de mois en deux exercices
						$date1 = date("Y-m-d",strtotime($liste_exercices[$i]->date_fin));
						if (isset($liste_exercices[$i+1])) {
							$date2 = date("Y-m-d", strtotime($liste_exercices[$i+1]->date_fin));
							$date1_debut = date("Y-m-d", mktime(0, 0, 0, date("m" ,strtotime($date2)) , date("d" ,strtotime($date2))+1 , date ("Y", strtotime($date2)) ));
						} else {
							$date2 = $ENTREPRISE_DATE_CREATION;				
							$date1_debut = $date2;
						}
						//affichage de l'exercice
						?>
						<option value="<?php echo $date1_debut.";".$date1; ?>" 
							style="font-weight:bolder;
							<?php if (!$liste_exercices[$i]->etat_exercice) { ?>
							color: #999999;
							<?php } else { if ($liste_exercices[$i]->date_fin >= date("Y-m-d")) { ?>
							color: #66CC33;
							<?php } else { ?>
							color: #CC3333;
							<?php } } ?>
							">
							<?php echo $liste_exercices[$i]->lib_exercice;?>
						</option>
						<?php 
						for ($j = 0; $j <= nb_mois($date2, $date1); $j++) {
							$mois = date("Y-m-d", mktime(0, 0, 0, round(date("m" ,strtotime($date1))-$j) , 1, date ("Y", strtotime($date1)) ) );
							$mois_fin = date("Y-m-d", mktime(0, 0, 0, round(date("m" ,strtotime($date1))-$j+1) , 0, date ("Y", strtotime($date1)) ) );
							
							?>
							<option 
								value="<?php if (date("Y-m", strtotime($mois)) == date("Y-m",  strtotime($date1_debut)) ) {echo $date1_debut;} else {echo $mois;}?>;<?php if ($j == 0) {echo $date1;} else {echo $mois_fin;}?>"><?php echo strftime("%B %Y",strtotime($mois))." " ;?>
							</option>
						<?php if (date("Y-m", strtotime($mois)) == date("Y-m",  strtotime($date1_debut)) ) {break;}
						}
					}?>
					</select>
				</td>
				<td>du <input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
				<td>au <input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr><td colspan="4"><div id="div_ajax_step_1"></div></td></tr>
		</table>
	</div>
	<div id="div_spacer" class="smallheight"><p>&nbsp;</p></div>
	<div id="div_export_choix_step_2" class="contactview_corps" style="padding:8px;display:none">
		<table id="table_export" style="height:100%; width:100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="4" class="titre_config"  >Choix des journaux à exporter :</td>
			<td style="text-align:center" width="20px" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="cancel_step_2" style="cursor:pointer;"/></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td><td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" ><div id="div_ajax_step_2"></div></td><td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%" style="padding:8px;"><span id="span_id_journaux[]" name="span_id_journaux[]" >Journaux disponibles :</span></td>
			<td width="30%" style="padding:8px;">
				<select id="id_journaux[]" name="id_journaux[]" multiple="multiple" class="affresult" size="5">
				</select>
			</td>
			<td width="20%" style="padding:8px;"><span id="span_id_logiciel" name="span_id_logiciel" >Logiciels cible :</span></td>
			<td width="30%" style="padding:8px;">
				<select id="id_logiciel" name="id_logiciel"  class="affresult" size="5">
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td><td>&nbsp;</td>
		</tr>
		</table>
	</div>
	<div id="div_spacer" class="smallheight"><p>&nbsp;</p></div>
	<div id="div_export_choix_step_3" class="contactview_corps" style="padding:8px;display:none"><div id="div_ajax_step_3"></div></div>
	<div id="div_export_choix_step_4" class="contactview_corps" style="padding:8px;display:none">
		<table id="table_export" style="height:100%; width:100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="2" class="titre_config" style="height:100%; width:100%" >Resume de l'exportation</td>
				<td style="text-align:center" width="20px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="cancel_step_4" style="cursor:pointer;"/>
				</td>
			</tr>
			<tr>
				<td colspan="2"><div id="div_ajax_step_4"></div></td><td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="compta_export_div_valid">
						<div id="progress_barre" class="progress_barre">
						<div id="export_progress" class="files_progress">&nbsp;</div>
						</div>
					</div>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
			<td colspan="2">&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td style="padding:8px;"><div id="export_etat"></div></td>
				<td style="text-align:right">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" id="continuer" style="cursor:pointer;display:none;"/>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"  id="lancer"  style="cursor:pointer;display:none;" />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif" id="cancel" style="cursor:pointer;display:none;"/>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
</div>

</form>
<script type="text/javascript">

//	SELECT OBSERVES
//	on change date_exercice
Event.observe("date_exercice", "change", function(evt){
	Event.stop(evt);
	// on est au step 0 > lance step 1
	if($("date_exercice").value != '--CHOISIR--'){
		compta_export_next_step (1);
	}else{
		compta_export_reset();
	}
}, false);
// on change select id_journaux
Event.observe("id_journaux[]", "change", function(evt){
	Event.stop(evt);
	//	si un journal && logiciel selectioné : step 2 > step 3
	if( compta_export_form_verif('id_journaux[]') && compta_export_form_verif('id_logiciel') ){
		compta_export_next_step (3);
	}
}, false);
// on change select id_logiciel
Event.observe("id_logiciel", "change", function(evt){
	Event.stop(evt);
	//	si un journal && logiciel selectioné : step 2 > step 3
	if( compta_export_form_verif('id_journaux[]') && compta_export_form_verif('id_logiciel') ){
		compta_export_next_step (3);
	}
}, false);


//	on click lancer
Event.observe("lancer", "click", function(evt){
	Event.stop(evt);
	//	on est au step 4 > lance l'export (step 4a)
	compta_export_valid_lock('form_exportation');
	compta_export_valid (4,'a');
}, false);
//	on click cancel
Event.observe("cancel", "click", function(evt){
	Event.stop(evt);
	//	on demande de reset l'export
	compta_export_reset();
}, false);
//	on click reset_all
Event.observe("reset_all", "click", function(evt){
	Event.stop(evt);
	compta_export_valid_unlock('form_exportation');
	compta_export_reset();
}, false);
//	on click continuer
Event.observe("continuer", "click", function(evt){
	Event.stop(evt);
	//	export finis > nouvel export (continue)
	compta_export_valid_unlock('form_exportation');
	compta_export_continue();
}, false);


//	INPUTS OBSERVES
//	on blur date_debut
Event.observe("date_debut", "blur", function(evt){
	//	re-ecrit la date pour compatibilité systeme
	datemask (evt);
	//	valide la date dans l'objet (step 0>step1)
	compta_export_next_step (1);
}, false);
//	on blur date_fin
Event.observe("date_fin", "blur", function(evt){
	//	re-ecrit la date pour compatibilité systeme
	datemask (evt);
	//	valide la date dans l'objet (step 0>step1)
	compta_export_next_step (1);
}, false);


</script>
<span id="spacer" >&nbsp;</span>
