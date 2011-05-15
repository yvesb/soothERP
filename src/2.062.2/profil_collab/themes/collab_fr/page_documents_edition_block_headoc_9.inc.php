<?php

// *************************************************************************************************************
// CONTROLE DU THEME TRM
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
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr class="">
		<td colspan="3">
			<div id="block_entete">
			<div style="width:100%;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr class="">
					<td valign="top" style="width:48%">
						<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
							<tr style=" line-height:24px; height:24px;">
								<td style="width:150px; padding-left:3px;">
									<input type="hidden" value="<?php echo $document->getRef_doc();?>" id="ref_doc" name="ref_doc"/>
									<input type="hidden" value="<?php echo $document->getID_TYPE_DOC();?>" id="id_type_doc" name="id_type_doc"/>
									<input type="hidden" value="<?php echo $document->getApp_tarifs();?>" id="app_tarifs" name="app_tarifs"/>			
									Date de cr&eacute;ation:					</td>
								<td style="width:250px; font-weight:bolder;">
									<a id="head_date_creation" class="modif_input2"><?php 
									if ($document->getDate_creation ()!= 0000-00-00) {
										echo  ( date_Us_to_Fr ($document->getDate_creation()));
									}
									?>&nbsp;</a>
												<input type="text" value="<?php 
													if ($document->getDate_creation()!=0000-00-00) {
														echo date_Us_to_Fr ($document->getDate_creation ());
													}?>" id="date_creation" name="date_creation" style="display:none" />
												<input type="hidden" value="<?php 
													if ($document->getDate_creation ()!=0000-00-00) {
														echo date_Us_to_Fr ($document->getDate_creation ());
													}?>" id="date_creation_old" name="date_creation_old"/>
								</td>
								<td>					</td>
							</tr>
							<tr style=" line-height:24px; height:24px;">
								<td style="width:150px; padding-left:3px;">
									&Eacute;tat:					</td>
								<td style="width:250px; font-weight:bolder;">
									<?php echo ($document->getLib_etat_doc());?>					</td>
								<td style="width:18px">					</td>
							</tr>
						<?php
						if (count($stocks_liste)>1) {
							?>
							<tr style=" line-height:24px; height:24px;">
								<td style="width:150px;">
									Stock source: 
								</td>
								<td style="width:250px;">
									<select id="id_stock_source" name="id_stock_source" class="classinput_xsize" <?php 
				if ($document->getId_etat_doc () == 40) {
					?> disabled="disabled" <?php }?>>
									<?php 
									foreach ($stocks_liste as $stock_liste) {
										?>
										<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if ($stock_liste->getId_stock () == $document->getId_stock_source ()){echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?>
										</option>
										<?php 
									}
									?>
									<?php 
									//ajout pour les stocks supprimés
									
									$stocks_supp	= fetch_all_stocks();
									foreach ($stocks_supp as $stock_supp) {
										if (!$stock_supp->actif && $stock_supp->id_stock == $document->getId_stock_source ()) {
											?>
											<option value="<?php echo $stock_supp->id_stock; ?>" style="color:#FF0000" ><?php echo ($stock_supp->lib_stock); ?>
											</option>
											<?php 
										}
									}
									?>
									</select>
									
								</td>
								<td style="width:18px">					</td>
							</tr>
							<tr style=" line-height:24px; height:24px;">
								<td style="width:150px;">
									Stock destination: 
								</td>
								<td style="width:250px;">
									<select id="id_stock_cible" name="id_stock_cible" class="classinput_xsize" <?php 
				if ($document->getId_etat_doc () == 40) {
					?> disabled="disabled" <?php }?>>
									<option value="">non d&eacute;fini</option>
									<?php 
									foreach ($stocks_liste as $stock_liste) {
										?>
										<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if ($stock_liste->getId_stock () == $document->getId_stock_cible ()){echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?>
										</option>
										<?php 
									}
									?>
									<?php 
									//ajout pour les stocks supprimés
									
									foreach ($stocks_supp as $stock_supp) {
										if (!$stock_supp->actif && $stock_supp->id_stock == $document->getId_stock_cible ()) {
											?>
											<option value="<?php echo $stock_supp->id_stock; ?>" selected="selected"  ><?php echo ($stock_supp->lib_stock); ?>
											</option>
											<?php 
										}
									}
									?>
									</select>
									
								</td>
								<td style="width:18px">					</td>
							</tr>
							<?php
						} else {
							?>
									<select id="id_stock_source" name="id_stock_source" style="display:none"<?php 
				if ($document->getId_etat_doc () == 40) {
					?> disabled="disabled" <?php }?>>
									<?php 
									foreach ($stocks_liste as $stock_liste) {
										?>
										<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if ($stock_liste->getId_stock () == $document->getId_stock_source ()){echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?>
										</option>
										<?php 
									}
									?>
									<?php 
									//ajout pour les stocks supprimés
									
									$stocks_supp	= fetch_all_stocks();
									foreach ($stocks_supp as $stock_supp) {
										if (!$stock_supp->actif && $stock_supp->id_stock == $document->getId_stock_source ()) {
											?>
											<option value="<?php echo $stock_supp->id_stock; ?>" style="color:#FF0000" ><?php echo ($stock_supp->lib_stock); ?>
											</option>
											<?php 
										}
									}
									?>
									</select>
									<select id="id_stock_cible" name="id_stock_cible" style="display:none" <?php 
				if ($document->getId_etat_doc () == 40) {
					?> disabled="disabled" <?php }?>>
									<option value="">non d&eacute;fini</option>
									<?php 
									foreach ($stocks_liste as $stock_liste) {
										?>
										<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if ($stock_liste->getId_stock () == $document->getId_stock_cible ()){echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?>
										</option>
										<?php 
									}
									?>
									<?php 
									//ajout pour les stocks supprimés
									
									foreach ($stocks_supp as $stock_supp) {
										if (!$stock_supp->actif && $stock_supp->id_stock == $document->getId_stock_cible ()) {
											?>
											<option value="<?php echo $stock_supp->id_stock; ?>" selected="selected"  ><?php echo ($stock_supp->lib_stock); ?>
											</option>
											<?php 
										}
									}
									?>
									</select>
							<?php
						}
						?>
						</table>
					</td>
					<td style="width:4%">&nbsp;
						
					</td>
					<td valign="top" style="width:48%">
									<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
										<tr>
											<td style="text-align:right; padding-right:3px;">
											<div style="height:5px; line-height:5px;"></div>
											<?php 
											if ($document->getId_etat_doc () == 36) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_trm_pret.gif" id="trm_pret" style="cursor:pointer"/>
											<div style="height:3px; line-height:3px;"></div>
											<?php 
											}
											?>
											<?php 
											if ($document->getId_etat_doc () == 38) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_trm_en_cours.gif" id="trm_en_cours" style="cursor:pointer"/>
											<div style="height:3px; line-height:3px;"></div>
											<?php 
											}
											?>
											<?php 
											if ($document->getId_etat_doc () == 39 ) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_trm_effectue.gif" id="trm_effectue" style="cursor:pointer"/>
											<div style="height:3px; line-height:3px;"></div>
											<?php 
											}
											?>
											<div style="height:3px; line-height:3px;"></div>
											<div id="doc_message_info"  style="text-decoration:none; color:#FF0000; font-weight:bolder"></div>
											<div id="doc_alerte_stock"  style="text-decoration:none; color:#FF0000; font-weight:bolder"></div>
											</td>
										</tr>
									</table>
					</td>
				</tr>
			</table>
			
			
			<script type="text/javascript">
					
			// observateur de changement de texte dans l'entete du doc pour mise à jour des infos						
			<?php
			if (count($stocks_liste)>1) {
				?>
				Event.observe("id_stock_source", "change", function(evt){ 
					if($("id_stock_cible").selectedIndex-1 != $("id_stock_source").selectedIndex) {
						maj_entete_id_stock_source ("id_stock_source"); 
						maj_entete_id_stock_cible ("id_stock_cible");
						$("id_stock_cible").className="classinput_xsize";
						$("id_stock_source").className="classinput_xsize";
					} else {
						$("id_stock_cible").className="alerteform_xsize";
						$("id_stock_source").className="alerteform_xsize";
					}
				}, false);
				
				Event.observe("id_stock_cible", "change", function(evt){ 
					if ($("id_stock_cible").selectedIndex != 0) {
						$("id_stock_cible").className="classinput_xsize";
						if($("id_stock_cible").selectedIndex-1 != $("id_stock_source").selectedIndex) {
							maj_entete_id_stock_source ("id_stock_source"); 
							maj_entete_id_stock_cible ("id_stock_cible");
							$("id_stock_cible").className="classinput_xsize";
							$("id_stock_source").className="classinput_xsize";
						} else {
							$("id_stock_cible").className="alerteform_xsize";
							$("id_stock_source").className="alerteform_xsize";
						}
					} else {
						$("id_stock_cible").className="alerteform_xsize";
					}
				
				}, false);
				<?php
			}
			?>


				Event.observe("head_date_creation", "click", function(evt){
					Event.stop(evt);
					$("head_date_creation").hide();
					$("date_creation").show();
					$("date_creation").focus();
				}, false);
				Event.observe("date_creation", "blur", function(evt){
					if ($("date_creation").value != $("date_creation_old").value) { datemask (evt); $("date_creation_old").value = $("date_creation").value; maj_date_creation ("date_creation");
					$("date_creation").hide();
					$("head_date_creation").innerHTML = $("date_creation").value;
					$("head_date_creation").show();
				} }, false);

				<?php 
				if ($document->getId_etat_doc () == 36) {
					?>
					//
					Event.observe("trm_pret", "click", function(evt){
						Event.stop(evt); 
						if ($("id_stock_cible").selectedIndex != 0) {
							maj_etat_doc (38); 
							$("trm_pret").hide(); 
							$("id_stock_cible").className="classinput_xsize";
						} else {
							$("id_stock_cible").className="alerteform_xsize";
						}
					}, false);
				<?php 
				}
				?>
				<?php 
				if ($document->getId_etat_doc () == 38) {
					?>
					//
					Event.observe("trm_en_cours", "click", function(evt){
						Event.stop(evt); 
						if ($("id_stock_cible").selectedIndex != 0) {
							maj_etat_doc (39); 
							$("trm_en_cours").hide();
							$("id_stock_cible").className="classinput_xsize";
						} else {
							$("id_stock_cible").className="alerteform_xsize";
						}
					}, false);
				<?php 
				}
				?>
				<?php 
				if ($document->getId_etat_doc () == 39) {
					?>
					//
					Event.observe("trm_effectue", "click", function(evt){
						Event.stop(evt); 
						if ($("id_stock_cible").selectedIndex != 0) {
							maj_etat_doc (40); 
							$("trm_effectue").hide(); 
							$("id_stock_cible").className="classinput_xsize";
						} else {
							$("id_stock_cible").className="alerteform_xsize";
						}
					}, false);
				<?php 
				}
				?>
			
			
			
			//on masque le chargement
			H_loading();
			
			</script>
					<input type="hidden" name="ref_contact"  id="ref_contact" value="<?php echo $document->getRef_contact();?>"/>
					
			
			<?php if(method_exists($document,'getId_livraison_mode') && $document->getId_livraison_mode()) { ?>
			<table>
			<tr>
				<td style=" padding-left:3px; width:150px;">
					Mode de Livraison:
				</td>
				<td colspan="2">
					<table style="width:268px;" >
						<tr>
							<td style="width:250px; text-align: left; font-weight:bolder;">
							<?php 
								$aff_livraison_mode = new livraison_modes($document->getId_livraison_mode());
								$article_livraison_mode = $aff_livraison_mode->getArticle();
								echo $article_livraison_mode->getLib_article();
							?>
							</td>
							<td>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
								<div style="height:3px;"></div>
				</td>
			</tr>
			</table>
			<?php } ?>
			</div>
			</div>
		</td>
	</tr>
	<tr>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
		<td style="width:4%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
	</tr>

</table>
<script type="text/javascript">
	quantite_locked = <?php if ($document->getQuantite_locked ()) {echo "true";} else {echo "false";} ?>;

</script>