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
tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
tableau_smenu[1] = Array('gestion_document_type','documents_gestion_type.php?id_type_groupe=<?php echo $infos_groupe[0]->id_type_groupe;?>',"true" ,"sub_content", "<?php echo $infos_groupe[0]->lib_type_groupe;?>");
update_menu_arbo();
</script>
<div class="emarge">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type_mini.inc.php" ?>

<p class="titre"><?php echo $infos_groupe[0]->lib_type_groupe;?></p>
<div style="height:50px">

<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="liste_documents type" style="padding-left:10px; padding-right:10px">
	
	<?php 
	foreach ($documents_type as $document_type) {
	?>
	<hr  />
	<span class="bolder"><?php echo ($document_type->lib_type_doc); ?></span><br />

	<div id="document_type_<?php echo $document_type->id_type_doc; ?>">

				<form action="documents_gestion_type_<?php echo $document_type->id_type_doc; ?>_mod.php" method="post" id="documents_gestion_type_mod_<?php echo $document_type->id_type_doc; ?>" name="documents_gestion_type_mod_<?php echo $document_type->id_type_doc; ?>" target="formFrame" >
					<table width="450px">
						<tr class="smallheight">
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<tr>
							<td>
							Libellé affiché
							<input name="id_type_doc" id="id_type_doc" type="hidden" value="<?php echo $document_type->id_type_doc; ?>" />
							<input name="id_type_groupe" id="id_type_groupe" type="hidden" value="<?php echo $document_type->id_type_groupe; ?>" />
							</td>
							<td>
								<input type="text" id="lib_type_printed_<?php echo $document_type->id_type_doc; ?>" name="lib_type_printed_<?php echo $document_type->id_type_doc; ?>" class="classinput_lsize" value="<?php echo htmlentities($document_type->lib_type_printed); ?>" />
							</td>
							<td>
							<input type="checkbox" id="actif_<?php echo $document_type->id_type_doc; ?>" name="actif_<?php echo $document_type->id_type_doc; ?>" <?php if ($document_type->actif || $document_type->id_type_doc <= 8) { echo 'checked="checked"';}?> disabled="disabled" />
							</td>
						</tr>
						<tr>
							
							<td >Période minimale d'archivage: 
							</td>
							<td>
								<input type="text" id="duree_avant_purge_annule_<?php echo $document_type->id_type_doc; ?>" name="duree_avant_purge_annule_<?php echo $document_type->id_type_doc; ?>" class="classinput_nsize" value="<?php echo (${"DUREE_AVANT_PURGE_ANNULE_".$document_type->code_doc}); ?>"  size="5"/> jours
								<input name="code_doc_<?php echo $document_type->id_type_doc; ?>" id="code_doc_<?php echo $document_type->id_type_doc; ?>" type="hidden" value="<?php echo $document_type->code_doc; ?>" />
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td colspan="3"><br />
							<?php include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type_".$document_type->code_doc.".inc.php"); ?>
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
				</form><br />

				Modèles disponibles pour l'impression de <?php echo ($document_type->lib_type_doc); ?>:
				<?php
				$pdf_inactif = 0;
				foreach ($document_type->doc_modeles_pdf as $modele_pdf) {
					if ($modele_pdf->usage == "inactif") {$pdf_inactif = 1; continue;}
					?>
					<table width="100%" border="0">
						<tr>
							<td style="width:5%">
							<input type="radio" name="def_pdf_<?php echo $document_type->code_doc; ?>" id="def_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" <?php if ($modele_pdf->usage == "defaut") {?> checked="checked" <?php } ?> />
							
								<form action="documents_gestion_type_def_pdf.php" method="post" id="documents_gestion_type_def_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" name="documents_gestion_type_def_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
									<input name="id_type_doc" type="hidden" value="<?php echo $document_type->id_type_doc; ?>" />
									<input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
									<input name="id_type_groupe" type="hidden" value="<?php echo $document_type->id_type_groupe; ?>" />
								</form>
								<?php if ($modele_pdf->usage != "defaut") {?>
								<script type="text/javascript">
							 Event.observe('def_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
							 	if ($('def_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>').checked == true) {
									$("documents_gestion_type_def_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
								}
							 } , false);
								</script>
								<?php } ?> 
							</td>
							<td><?php echo $modele_pdf->lib_modele;?>
							<div style="display:none; font-style:italic;" id="desc_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>"><?php echo $modele_pdf->desc_modele;?></div>
							</td>
							<td style="width:15%"><span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>">Plus d'informations</span></td>
							<td style="width:15%">
							<span id="param_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Paramétrer</span>
								<script type="text/javascript">
							 Event.observe('param_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
									ouvre_mini_moteur_doc_type();
									charger_param_pdf ("documents_gestion_type_param_pdf.php?id_pdf_modele=<?php echo $modele_pdf->id_pdf_modele;?>");
							 } , false);
								</script>
							</td>
							<td style="width:15%">
							<?php if ($modele_pdf->usage != "defaut") {?>
								<span id="unactive_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Désactiver</span>
								
								<form action="documents_gestion_type_des_pdf.php" method="post" id="documents_gestion_type_des_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" name="documents_gestion_type_des_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
									<input name="id_type_doc" type="hidden" value="<?php echo $document_type->id_type_doc; ?>" />
									<input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
									<input name="id_type_groupe" type="hidden" value="<?php echo $document_type->id_type_groupe; ?>" />
								</form>
								<script type="text/javascript">
							 Event.observe('unactive_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
									$("documents_gestion_type_des_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
							 } , false);
								</script>
							<?php } ?>
							</td>
						</tr>
					</table>
					<script type="text/javascript">
					
				 Event.observe('show_desc_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
				 	$("desc_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>").show();
				 } , false);
					</script>
					<?php
				}
				if ($pdf_inactif) {
				?>
				<span style="cursor:pointer; text-decoration:underline; display:" id="show_pdf_inactif_<?php echo $document_type->code_doc; ?>">Utiliser un nouveau modèle d'impression.</span><br />
				<div id="more_pdf_<?php echo $document_type->code_doc; ?>" style="display:none">
				<?php
				foreach ($document_type->doc_modeles_pdf as $modele_pdf) {
					if ($modele_pdf->usage != "inactif") {continue;}
					?>
					<table width="100%" border="0">
						<tr>
							<td style="width:5%">&nbsp;</td>
							<td><?php echo $modele_pdf->lib_modele;?>
							<div style="display:none; font-style:italic;" id="desc_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>"><?php echo $modele_pdf->desc_modele;?></div>
							</td>
							<td style="width:16%"><span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>">Plus d'informations</span></td>
							
							<td style="width:11%; color:#999999">Paramétrer</td>
							<td style="width:11%">
							
								<span id="active_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Activer</span>
								
								<form action="documents_gestion_type_act_pdf.php" method="post" id="documents_gestion_type_act_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" name="documents_gestion_type_act_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
									<input name="id_type_doc" type="hidden" value="<?php echo $document_type->id_type_doc; ?>" />
									<input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
									<input name="id_type_groupe" type="hidden" value="<?php echo $document_type->id_type_groupe; ?>" />
								</form>
								<script type="text/javascript">
							 Event.observe('active_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
							<?php 
							
							$config_files = file($PDF_MODELES_DIR."config/".$modele_pdf->code_pdf_modele.".config.php");
							
							if (substr_count($config_files[1],"\$CONFIGURATION=0;")) {
								?> 
								ouvre_mini_moteur_doc_type();
								charger_param_pdf ("documents_gestion_type_param_pdf.php?id_pdf_modele=<?php echo $modele_pdf->id_pdf_modele;?>&act=1&id_type_doc=<?php echo $document_type->id_type_doc;?>");
								<?php } else { ?>
								$("documents_gestion_type_act_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
							 	<?php
							}
							?>
							} , false);
								</script>
							</td>
							<td style="width:11%">
								<span id="supprime_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Supprimer</span>
								
								<form action="documents_gestion_type_sup_pdf.php" method="post" id="documents_gestion_type_sup_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" name="documents_gestion_type_sup_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
									<input name="id_type_doc" type="hidden" value="<?php echo $document_type->id_type_doc; ?>" />
									<input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
									<input name="id_type_groupe" type="hidden" value="<?php echo $document_type->id_type_groupe; ?>" />
								</form>
								<script type="text/javascript">
							Event.observe('supprime_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
									$("documents_gestion_type_sup_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
							 } , false);
								</script>
							</td>
						</tr>
					</table>
					<script type="text/javascript">
					
				 Event.observe('show_desc_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
				 	$("desc_pdf_<?php echo $document_type->code_doc; ?>_<?php echo $modele_pdf->id_pdf_modele;?>").show();
				 } , false);
					</script>

					<?php
				}
				?>
				</div>
				<script type="text/javascript">
				
				 Event.observe('show_pdf_inactif_<?php echo $document_type->code_doc; ?>', "click" , function(evt){
				 	$("more_pdf_<?php echo $document_type->code_doc; ?>").show();
				 	$("show_pdf_inactif_<?php echo $document_type->code_doc; ?>").hide();
				 } , false);
				</script>
				<?php
			}
			?>
	</div>
	<br />
	<?php
	
	}
	?>
</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">


<?php 
	foreach ($documents_type as $document_type) {
?>
new Form.EventObserver('documents_gestion_type_mod_<?php echo $document_type->id_type_doc; ?>', function(element, value){formChanged();});
 Event.observe('duree_avant_purge_annule_<?php echo $document_type->id_type_doc; ?>', "blur" , function(evt){
 Event.stop(evt);
 nummask(evt, "0", "X");
 } , false);

//on masque le chargement
H_loading();
<?php
	}
?>
</SCRIPT>
</div>
</div>