<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('annuaire_gestion_factures','annuaire_gestion_factures.php','true','sub_content', "Règles de relance des factures");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Règles de relance des factures</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">
<?php 
if ($liste_relance_modele) {
	?>
	<p>Choix de la  cat&eacute;gorie mod&egrave;le </p>

	<select id="choix_modele_relance" name="choix_modele_relance" >
	<option value="0">Mod&egrave;le par d&eacute;faut</option>
	<?php 
	foreach ($liste_relance_modele as $modele) {
		?>
		<option value="<?php echo $modele->id_relance_modele; ?>" <?php if ($modele->id_relance_modele == $id_relance_modele) {echo 'selected="selected"'; $choix_select = true; }?>><?php echo htmlentities($modele->lib_relance_modele); ?></option>
		<?php 
	}
	?>
	</select>
	<br />
	<br />
	<?php 
	if (isset($id_relance_modele)) {
		?>
		</div>
		<?php 
		if ($niveaux_relances) {
			?>
			<p>&nbsp;&nbsp;Niveaux de relance </p>
				<table>
				<tr>
					<td style="width:95%">
							<table>
							<tr class="smallheight">
								<td style="width:26%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:14%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:22%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>								
								<td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>								
							</tr>
							<tr>
								<td style="vertical-align:middle"><span class="labelled" >Libell&eacute;:</span>
								</td>
								<td style="vertical-align:middle"><span class="labelled">D&eacute;lai:</span>
								</td>
								<td style="vertical-align:middle"><span class="labelled">Mode d'&eacute;dition:</span>
								</td>
								<td style="vertical-align:middle"><span class="labelled">Montant&nbsp;minimum:</span>
								</td>
								<td ><div class="labelled" style="text-align:center">Imprimer&nbsp;sur<br/>la&nbsp;facture</div>
								</td>
								<td style="vertical-align:middle"><div class="labelled" style="text-align:center">Actif</div>
								</td>
								<td><div class="labelled" style="text-align:center">Suite&nbsp;avant&nbsp;<br/>&eacute;ch&eacute;ance</div>
								</td>		
							</tr>
				<?php
				
				$fleches_ascenseur=0;
				$first_niveau_relance = false;
				foreach ($niveaux_relances as $niveau_relance) {
				//premier niveau de relance partiellement editable
					//if ($niveau_relance->id_relance_modele == NULL ) {
					if(empty($niveau_relance->id_relance_modele)){$niveau_relance->id_relance_modele = 0;}
					?>
							
			

									<tr>
										<td>
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:2px;padding-left:2px;padding-right:3px;border-right:hidden;">
										<input name="id_niveau_relance" id="id_niveau_relance" type="hidden" value="<?php echo $niveau_relance->id_niveau_relance;?>"/>
										<input name="id_client_categ_<?php echo $niveau_relance->id_niveau_relance;?>" id="id_client_categ_<?php echo $niveau_relance->id_niveau_relance;?>" type="hidden" value="<?php echo $id_relance_modele ;?>" />
										<input name="lib_niveau_relance_<?php echo $niveau_relance->id_niveau_relance;?>" id="lib_niveau_relance_<?php echo $niveau_relance->id_niveau_relance;?>" type="text" value="<?php echo htmlentities($niveau_relance->lib_niveau_relance);?>"  class="classinput_lsize" readonly="readonly" style="background-color: #DDDEEE" />
										</div>
										</td>
										<td>
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:3px;padding-right:3px;border-left:hidden;border-right:hidden;">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td style="width:70px">
												<input name="delai_before_next_<?php echo $niveau_relance->id_niveau_relance;?>" id="delai_before_next_<?php echo $niveau_relance->id_niveau_relance;?>" type="text" value="<?php echo htmlentities($niveau_relance->delai_before_next);?>"  class="classinput_nsize" size="5" />
												<script type="text/javascript">
												Event.observe("delai_before_next_<?php echo $niveau_relance->id_niveau_relance;?>" , "change", function(evt){
															maj_delai_before_next ($("delai_before_next_<?php echo $niveau_relance->id_niveau_relance;?>").value, <?php echo $niveau_relance->id_niveau_relance;?>, <?php echo $niveau_relance->id_relance_modele;?>);
													}, false);
												</script>
												</td>
												<td> jour(s)
												</td>
											</tr>
										</table>
										</div>
										</td>
										<td>
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:3px;padding-right:3px;border-left:hidden;border-right:hidden;">
											<select id="id_edition_mode_<?php echo $niveau_relance->id_niveau_relance;?>" name="id_edition_mode_<?php echo $niveau_relance->id_niveau_relance;?>" class="classinput_lsize">
											<option value=""></option>
											<?php 
											 foreach ($editions_modes as $edition_mode) {
												?>
												<option value="<?php echo $edition_mode->id_edition_mode;?>" <?php if ($edition_mode->id_edition_mode == $niveau_relance->id_edition_mode) {echo 'selected="selected"';}?>><?php echo  htmlentities($edition_mode->lib_edition_mode);?></option>
												<?php
												}
											?>
											</select>
												<script type="text/javascript">
												Event.observe("id_edition_mode_<?php echo $niveau_relance->id_niveau_relance;?>" , "change", function(evt){
														maj_edition_mode ($("id_edition_mode_<?php echo $niveau_relance->id_niveau_relance;?>").value, <?php echo $niveau_relance->id_niveau_relance;?>, <?php echo $niveau_relance->id_relance_modele;?> );
													}, false);
												</script>
										</div>											
										</td>
										<td style="text-align:center">
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:3px;padding-right:3px;border-left:hidden;border-right:hidden;">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td style="width:50px">
												<input name="montant_min_<?php echo $niveau_relance->id_niveau_relance;?>" id="montant_min_<?php echo $niveau_relance->id_niveau_relance;?>" type="text" value="<?php echo htmlentities($niveau_relance->montant_mini);?>"  class="classinput_nsize" size="3" />
												&nbsp;&euro;
												</td>
												<script type="text/javascript">
												Event.observe("montant_min_<?php echo $niveau_relance->id_niveau_relance;?>" , "change", function(evt){
													maj_montant_min ($("montant_min_<?php echo $niveau_relance->id_niveau_relance;?>").value, <?php echo $niveau_relance->id_niveau_relance;?>, <?php echo $niveau_relance->id_relance_modele;?> );
													}, false);
												</script>
											</tr>
										</table>
										</div>
										</td>
										<td style="text-align:center">
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:3px;padding-right:3px;border-left:hidden;border-right:hidden;">
											<input name="impression_<?php echo $niveau_relance->id_niveau_relance;?>" id="impression_<?php echo $niveau_relance->id_niveau_relance;?>" type="checkbox" value="1" <?php if ($niveau_relance->impression) {?> checked="checked"<?php } ?>/>
											<script type="text/javascript">
											Event.observe("impression_<?php echo $niveau_relance->id_niveau_relance;?>" , "click", function(evt){
												maj_impression ($("impression_<?php echo $niveau_relance->id_niveau_relance;?>").checked, <?php echo $niveau_relance->id_niveau_relance;?>, <?php echo $niveau_relance->id_relance_modele;?> );
												}, false);
											</script>
										</div>
										</td>
										<td style="text-align:center">
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:3px;padding-right:3px;border-left:hidden;border-right:hidden;">
											<input name="actif_<?php echo $niveau_relance->id_niveau_relance;?>" id="actif_<?php echo $niveau_relance->id_niveau_relance;?>" type="checkbox" <?php if ($niveau_relance->actif) {?> checked="checked"<?php } ?>/>
											<script type="text/javascript">
											Event.observe("actif_<?php echo $niveau_relance->id_niveau_relance;?>" , "click", function(evt){
												maj_actif ($("actif_<?php echo $niveau_relance->id_niveau_relance;?>").checked, <?php echo $niveau_relance->id_niveau_relance;?>, <?php echo $niveau_relance->id_relance_modele;?> );
												}, false);
											</script>
										</div>
										</td>
										<td style="text-align:center">
										<div class="caract_table" style="padding-bottom:6px;padding-top:6px;padding-left:3px;padding-right:2px;border-left:hidden;">
											<input name="suite_avant_echeance_<?php echo $niveau_relance->id_niveau_relance;?>" id="suite_avant_echeance_<?php echo $niveau_relance->id_niveau_relance;?>" type="checkbox" <?php if ($niveau_relance->suite_avant_echeance) {?> checked="checked"<?php } ?>/>										
											<script type="text/javascript">
											Event.observe("suite_avant_echeance_<?php echo $niveau_relance->id_niveau_relance;?>" , "click", function(evt){
												maj_suite_avant_echeance ($("suite_avant_echeance_<?php echo $niveau_relance->id_niveau_relance;?>").checked, <?php echo $niveau_relance->id_niveau_relance;?>, <?php echo $niveau_relance->id_relance_modele;?> );
												}, false);
											</script>
										</div>
										</td>
									</tr>
				<?php
				}
				?>
			<?php 
			}
		?>
		<?php 
		}
	?>
	<?php
}
?>
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
Event.observe("choix_modele_relance", "change", function(evt){ if ($("choix_modele_relance").value != "") { page.traitecontent('annuaire_gestion_factures','annuaire_gestion_factures.php?id_relance_modele='+$("choix_modele_relance").value,'true','sub_content');} }, false);	

<?php 
if (isset($id_client_categ)) {
	?>
Event.observe("delai_before_next", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
new Form.EventObserver('annuaire_gestion_factures_n_relances_add', function(){formChanged();});
	<?php
	foreach ($niveaux_relances as $niveau_relance) {
		if ($niveau_relance->niveau_relance != 10 && $niveau_relance->niveau_relance != 11 ) {
		?>
		new Form.EventObserver('annuaire_gestion_factures_n_relances_mod_<?php echo $niveau_relance->id_niveau_relance;?>', function(){formChanged();});
		Event.observe("delai_before_next_<?php echo $niveau_relance->id_niveau_relance;?>", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
		<?php 
		}
	}
	?>
	<?php
} 
?>
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>