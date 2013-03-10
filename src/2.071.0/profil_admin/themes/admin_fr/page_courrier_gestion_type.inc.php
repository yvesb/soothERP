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

<div class="emarge">
	<?php /*include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type_mini.inc.php" */?>

	<p class="titre">Courriers</p>
	<div style="height:50px">

		<table class="minimizetable">
			<tr>
				<td class="contactview_corps">
					<div id="liste_documents_type" style="padding-left:10px; padding-right:10px">
						<?php 
						foreach ($courrier_infos_types as $courrier_type) {//*******************************
						?>
							<hr  />
							<span class="bolder">
								<?php echo ($courrier_type->lib_type_courrier); ?>
							</span>
							<br />
							<div id="courrier_type_<?php echo $courrier_type->id_type_courrier; ?>">
								<form action="courriers_gestion_type_<?php echo $courrier_type->id_type_courrier; ?>_mod.php" method="post" id="courriers_gestion_type_<?php echo $courrier_type->id_type_courrier; ?>" name="courriers_gestion_type_<?php echo $courrier_type->id_type_courrier; ?>" target="formFrame" >
									<table width="450px">
										<tr class="smallheight">
											<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										</tr>
										<tr>
											<td>
											Libellé affiché
											<input name="id_type_courrier" id="id_type_courrier" type="hidden" value="<?php echo $courrier_type->id_type_courrier; ?>" />
											</td>
											<td>
												<input type="text" id="lib_type_printed_<?php echo $courrier_type->id_type_courrier; ?>" name="lib_type_printed_<?php echo $courrier_type->id_type_courrier; ?>" class="classinput_lsize" value="<?php echo $courrier_type->lib_modele; ?>" />
											</td>
											<td>
											<input type="checkbox" id="actif_<?php echo $courrier_type->id_type_courrier; ?>" name="actif_<?php echo $courrier_type->id_type_courrier; ?>" <?php if ($courrier_type->actif) { echo 'checked="checked"';}?> disabled="disabled" />
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
								Modèles disponibles pour l'impression de <?php echo ($courrier_type->lib_type_courrier); ?>:
								<br/>
								<table width="100%" border="1">
									<tr>
										<td style="width:5%">
											a
										</td>
										<td>
											<?php echo $courrier_type->lib_type_courrier;?>
											<div style="font-style:italic;" id="desc_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>">
											</div>
										</td>
										<td style="width:15%">
											<span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>">Plus d'informations</span>
										</td>
										<td style="width:15%">
											<a href="configuration_pdf_preview.php?type=courrier&id_type_courrier=<?php echo $courrier_type->id_type_courrier; ?>&code_pdf_modele=<?php echo $courrier_type->code_pdf_modele;?>" target="_blank" style="color:#000000">Visualiser</a>
										</td>
										<td style="width:15%">
											<span id="param_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Paramétrer</span>
											<script type="text/javascript">
												Event.observe("param_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>", "click" , function(evt){
												ouvre_mini_moteur_doc_type();
												<?php //@FIXME 
												/*ouvre_mini_moteur_courrier_type();*/ ?>
												charger_param_pdf ("documents_gestion_type_param_pdf.php?id_pdf_modele=<?php echo $courrier_type->id_pdf_modele;?>");
												 } , false);
											</script>
										</td>
										<td style="width:15%">
											<span id="unactive_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Désactiver</span>
											<form action="documents_gestion_type_des_pdf.php" method="post" id="documents_gestion_type_des_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>" name="documents_gestion_type_des_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>" target="formFrame" >
												<input name="id_pdf_modele" type="hidden" value="<?php echo $courrier_type->id_pdf_modele; ?>" />
											</form>
											<script type="text/javascript">
												Event.observe('unactive_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>', "click" , function(evt){
													$("documents_gestion_type_des_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>").submit();
												} , false);
											</script>
										</td>
									</tr>
								</table>
								<script type="text/javascript">
									Event.observe('show_desc_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>', "click" , function(evt){
										$("desc_pdf_<?php echo $courrier_type->code_courrier; ?>_<?php echo $courrier_type->id_pdf_modele;?>").show();
									} , false);
								</script>
								<span style="cursor:pointer; text-decoration:underline; display:" id="show_pdf_inactif_<?php echo $courrier_type->code_courrier; ?>">Utiliser un nouveau modèle d'impression.</span><br />
								<script type="text/javascript">
								Event.observe('show_pdf_inactif_<?php echo $courrier_type->code_courrier; ?>', "click" , function(evt){
									$("more_pdf_<?php echo $courrier_type->code_courrier; ?>").show();
									$("show_pdf_inactif_<?php echo $courrier_type->code_courrier; ?>").hide();
								} , false);
								</script>
							</div>
						<?php
						}// *********************************************************************************
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
