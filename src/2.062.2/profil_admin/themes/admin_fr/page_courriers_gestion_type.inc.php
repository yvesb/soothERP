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
<!-- Fil rouge dans la barre d'outils en haut de l'application -->
<script type="text/javascript">
tableau_smenu[0] = Array('smenu_communication', 'smenu_communication.php' ,'true' , 'sub_content', 'Communication');
tableau_smenu[1] = Array('gestion_courrier_type','courriers_gestion_type.php',"true" ,"sub_content", "Gérer les modèles de courrier");
update_menu_arbo();
</script>
<div class="emarge">
	<!-- pop up qui apparait quand on clic sur "paramètres" --> 
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_courriers_gestion_type_mini.inc.php" ?>

	<p class="titre">Courriers</p>
	<div style="height:50px">

		<table class="minimizetable">
			<tr>
				<td class="contactview_corps">
					<div id="liste_courrier_type" style="padding-left:10px; padding-right:10px">
						<?php
						$i = 0;
						while($i < count($infos_tc_et_mp)) {//*******************  while
						?>
							<hr  />
							<span class="bolder">
								<?php echo ($infos_tc_et_mp[$i]->lib_type_courrier); ?>
							</span>
							<br />
							<div id="courrier_type_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>">
								<form action="courriers_gestion_types_mod.php" method="post" id="courriers_gestion_type_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" name="courriers_gestion_type_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" target="formFrame" >
									<table width="450px">
										<tr class="smallheight">
											<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										</tr>
										<tr>
											<td>
											Libellé affiché
											<input name="id_type_courrier" id="id_type_courrier" type="hidden" value="<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" />
											</td>
											<td>
												<input type="text" id="lib_type_courrier" name="lib_type_courrier" class="classinput_lsize" value="<?php echo $infos_tc_et_mp[$i]->lib_type_courrier; ?>" />
											</td>
											<td>
											<?php /*<input type="checkbox" id="actif_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" name="actif_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" <?php if ($infos_tc_et_mp[$i]->actif) { echo 'checked="checked"';}?> disabled="disabled" />*/ ?>
											</td>
										</tr>
										<tr>
											<td style="text-align:center">
											</td>
											<td style="text-align:center">
												<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
											</td>
											<td>
											</td>
										</tr>
									</table>
								</form>
								<br />
								Modèles disponibles pour l'impression de <?php echo ($infos_tc_et_mp[$i]->lib_type_courrier); ?>:
								<br/>
								<?php
								$id_courrier_type_tmp = $infos_tc_et_mp[$i]->id_type_courrier;
								while	($i < count($infos_tc_et_mp) && $id_courrier_type_tmp == $infos_tc_et_mp[$i]->id_type_courrier){
									?>
									<table width="100%" border="0">
										<tr>
											<td style="width:5%">
												<input type="radio" name="def_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier."_".$infos_tc_et_mp[$i]->id_pdf_modele; ?>" id="def_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier."_".$infos_tc_et_mp[$i]->id_pdf_modele; ?>" <?php if ($infos_tc_et_mp[$i]->usage == "defaut") {?> checked="checked" <?php } ?> />
												<form action="courriers_gestion_type_set_defaut_pdf.php" method="post" 
													id = "model_par_default_def_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier."_".$infos_tc_et_mp[$i]->id_pdf_modele; ?>" 
													name="model_par_default_def_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier."_".$infos_tc_et_mp[$i]->id_pdf_modele; ?>" target="formFrame" >
													<input name="id_type_courrier" type="hidden" value="<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" />
													<input name="id_pdf_modele" type="hidden" value="<?php echo $infos_tc_et_mp[$i]->id_pdf_modele; ?>" />
												</form>
												<script type="text/javascript">
													Event.observe('def_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier."_".$infos_tc_et_mp[$i]->id_pdf_modele; ?>', "click" , function(evt){
														$("model_par_default_def_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier."_".$infos_tc_et_mp[$i]->id_pdf_modele; ?>").submit();
													} , false);
												</script>
											</td>
											<td>
												<?php echo $infos_tc_et_mp[$i]->lib_modele;?>
												<div style="display:none; font-style:italic;" id="desc_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>">
													<?php echo $infos_tc_et_mp[$i]->desc_modele;?> 
												</div>
											</td>
											<td style="width:15%">
												<span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $infos_tc_et_mp[$i]->id_type_courrier;?>">Plus d'informations</span>
												<script type="text/javascript">
													Event.observe('show_desc_<?php echo $infos_tc_et_mp[$i]->id_type_courrier;?>', "click" , function(evt){
													$("desc_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>").show();
													} , false);
												</script>
											</td>
											<td style="width:15%">
												<a href="configuration_pdf_preview.php?type=courrier&id_type_courrier=<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>&id_pdf_modele=<?php echo $infos_tc_et_mp[$i]->id_pdf_modele;?>" target="_blank" style="color:#000000">Visualiser</a>
											</td>
											<td style="width:15%">
												<span id="param_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" style="cursor:pointer; text-decoration:underline">Paramétrer</span>
												<script type="text/javascript">
													Event.observe("param_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>", "click" , function(evt){
													ouvre_mini_moteur_courrier_type();
													page.verify('aff_pop_up_mini_moteur_courrier_type','courriers_gestion_type_param_pdf.php?id_pdf_modele=<?php echo $infos_tc_et_mp[$i]->id_pdf_modele;?>','true','aff_pop_up_mini_moteur_courrier_type');
													 } , false);
														<?php
																/* charger_param_pdf("courriers_gestion_type_param_pdf.php?id_pdf_modele=<?php echo $infos_tc_et_mp[$i]->id_pdf_modele;); ?>" */
														?>
												</script>
											</td>
											<td style="width:15%">
												<span id="activer_desactiver_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" style="cursor:pointer; text-decoration:underline">
													<?php if($infos_tc_et_mp[$i]->actif) {
														echo "Désactiver";
													} else {
														echo "Activer";
													} ?>
												</span>
												<form action="courriers_gestion_type_<?php if($infos_tc_et_mp[$i]->actif) {echo "des";} ?>active_pdf.php" method="post" 
													id = "courriers_gestion_type_activer_desactiver_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" 
													name="courriers_gestion_type_activer_desactiver_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" target="formFrame" >
													<input name="id_type_courrier" type="hidden" value="<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>" />
												</form>
												<script type="text/javascript">
													Event.observe('activer_desactiver_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>', "click" , function(evt){
														$("courriers_gestion_type_activer_desactiver_pdf_<?php echo $infos_tc_et_mp[$i]->id_type_courrier; ?>").submit();
													} , false);
												</script>
											</td>
										</tr>
									</table>
									<?php
										$i++;
								}
								?>
							</div>
						<?php
						} // *********************************************************************************
						?>
						<br />
					</div>
				</td>	
			</tr>
		</table>
	</div>
	<SCRIPT type="text/javascript">
	<?php 
	/*
		foreach ($courriers_type as $courrier_type) {
	?>
	new Form.EventObserver('documents_gestion_type_mod_<?php echo $courrier_type->id_type_doc; ?>', function(element, value){formChanged();});
	 Event.observe('duree_avant_purge_annule_<?php echo $courrier_type->id_type_doc; ?>', "blur" , function(evt){
	 Event.stop(evt);
	 nummask(evt, "0", "X");
	 } , false);
	
	//on masque le chargement
	H_loading();
	<?php
		}
		*/
	?>
	</SCRIPT>
</div>
