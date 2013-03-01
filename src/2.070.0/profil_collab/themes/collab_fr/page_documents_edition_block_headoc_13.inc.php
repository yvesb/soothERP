<?php

// *************************************************************************************************************
// ENTETE BON DE DESASSEMBLAGE
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
							<td>
							</td>
						</tr>
						<tr style=" line-height:24px; height:24px;">
							<td style="width:150px; padding-left:3px;">&Eacute;tat:</td>
							<td style="width:250px; font-weight:bolder;"><?php echo ($document->getLib_etat_doc());?></td>
							<td></td>
						</tr>
						<tr style=" line-height:24px; height:24px;">
							<td style="width:150px; padding-left:3px;">Code affaire:</td>
								<td style="width:250px;">
									<a id="head_code_affaire" class="modif_input2"><?php 
											echo $document->getCode_affaire();
									?>&nbsp;</a>
									<input type="text" value="<?php echo $document->getCode_affaire();?>" 
										id="code_affaire" name="code_affaire" class="classinput_xsize" style="display:none" />
									<input type="hidden" value="<?php echo $document->getCode_affaire();?>" 
										id="code_affaire_old" name="code_affaire_old"/>
								</td>
								<td style="width:20%; text-align:center;">
									<a href="#documents_recherche.php?code_affaire=<?php echo $document->getCode_affaire();?>" target="_blank" 
										id="lien_recherche_avancee_code_affaire"
										<?php if($document->getCode_affaire () == ""){ ?>style="display: none;"<?php } ?>>
										VOIR
									</a>	
								</td>
						</tr>
					<?php
					if (count($stocks_liste)>1) {
						?>
						<tr style=" line-height:24px; height:24px;">
							<td style="width:150px; padding-left:3px;">Lieu de stockage:</td>
							<td style="width:250px;">
								<select id="id_stock" name="id_stock" class="classinput_lsize" <?php 
				if ($document->getId_etat_doc () == 56) {
					?> disabled="disabled" <?php }?>>
									<?php 
									foreach ($stocks_liste as $stock_liste) {
										?>
										<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if ($stock_liste->getId_stock () == $document->getId_Stock ()){echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?>
										</option>
										<?php 
									}
									?>
									<?php 
									//ajout pour les stocks inactifs qui auraient été utilisés par le document
									$stocks_supp	= fetch_all_stocks();
									foreach ($stocks_supp as $stock_supp) {
										if (!$stock_supp->actif && $stock_supp->id_stock == $document->getId_stock ()) {
											?>
											<option value="<?php echo $stock_supp->id_stock; ?>" style="color:#FF0000" selected="selected" ><?php echo ($stock_supp->lib_stock); ?>
											</option>
											<?php 
										}
									}
									?>
									</select>					
								</td>
							<td style="width:18px">
							</td>
						</tr>
						<?php
					} else {
						?><select id="id_stock" name="id_stock" style="display:none" <?php 
				if ($document->getId_etat_doc () == 56) {
					?> disabled="disabled" <?php }?>>
									<?php 
									foreach ($stocks_liste as $stock_liste) {
										?>
										<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if ($stock_liste->getId_stock () == $document->getId_Stock ()){echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?>
										</option>
										<?php 
									}
									?>
									<?php 
									//ajout pour les stocks inactifs qui auraient été utilisés par le document
									$stocks_supp	= fetch_all_stocks();
									foreach ($stocks_supp as $stock_supp) {
										if (!$stock_supp->actif && $stock_supp->id_stock == $document->getId_stock ()) {
											?>
											<option value="<?php echo $stock_supp->id_stock; ?>" style="color:#FF0000" selected="selected" ><?php echo ($stock_supp->lib_stock); ?>
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
							<td style="width:50%;">
						
							<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
								<tr>
									
									<td>
							
									<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
										<tr>
											<td style="text-align:right; padding-right:3px">
											<div style="height:5px;line-height:5px;" ></div>
											<?php 
											if ($document->getId_etat_doc () == 52) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_des_adesassembler.gif" id="des_adesassembler" style="cursor:pointer"/>
											<div style="height:3px;line-height:3px;" ></div>
											<?php 
											}
											?>
											<?php 
											if ($document->getId_etat_doc () == 54) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_des_encours.gif" id="des_encours" style="cursor:pointer"/>
											<div style="height:3px;line-height:3px;" ></div>
											<?php 
											}
											?>
											<?php 
											if ($document->getId_etat_doc () == 55) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_des_terminee.gif" id="des_terminee" style="cursor:pointer"/>
											<div style="height:3px;line-height:3px;" ></div>
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
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
				
		// observateur de changement de texte dans l'entete du doc pour mise à jour des infos
		Event.observe("code_affaire", "blur", function(evt){
			if ($("code_affaire").value != $("code_affaire_old").value) {
				$("code_affaire_old").value = $("code_affaire").value;
				$("head_code_affaire").innerHTML = $("code_affaire").value + "&nbsp;";
				maj_code_affaire ("code_affaire");
				$("lien_recherche_avancee_code_affaire").href = "#documents_recherche.php?code_affaire=" + $("code_affaire").value;
			}
			$("code_affaire").hide();
			$("head_code_affaire").show();
			if($("code_affaire").value != ""){
				$("lien_recherche_avancee_code_affaire").show();
			}else{
				$("lien_recherche_avancee_code_affaire").hide();
			}
		}, false);
		Event.observe("head_code_affaire", "click", function(evt){
			Event.stop(evt);
			$("head_code_affaire").hide();
			$("code_affaire").show();
			$("code_affaire").focus();
		}, false);
		Event.observe("code_affaire", "dblclick", function(evt){
			Event.stop(evt);
			generer_code_affaire ("code_affaire");
		}, false);
		
		Event.observe("head_date_creation", "click", function(evt){
			Event.stop(evt);
			$("head_date_creation").hide();
			$("date_creation").show();
			$("date_creation").focus();
		}, false);
		Event.observe("date_creation", "blur", function(evt){
			if ($("date_creation").value != $("date_creation_old").value) { 
				datemask (evt); 
				$("date_creation_old").value = $("date_creation").value; 
				maj_date_creation ("date_creation");
				$("head_date_creation").innerHTML = $("date_creation").value + "&nbsp;";
			}
			$("date_creation").hide();
			$("head_date_creation").show();
		}, false);

			<?php
			if (count($stocks_liste)>1) {
				?>
				Event.observe("id_stock", "change", function(evt){ maj_entete_id_stock ("id_stock"); }, false);
				<?php
			}
			?>

			<?php 
			if ($document->getId_etat_doc () == 52) {
				?>
				// à fabriquer
				Event.observe("des_adesassembler", "click", function(evt){Event.stop(evt);
						maj_etat_doc (54);
				}, false);
				<?php
			}
			?>
			<?php 
			if ($document->getId_etat_doc () == 54) {
				?>
				// à fabriquer
				Event.observe("des_encours", "click", function(evt){Event.stop(evt);
						maj_etat_doc (55);
				}, false);
				<?php
			}
			?>
			
			<?php 
			if ($document->getId_etat_doc () == 55) {
				?>
				// pret
				Event.observe("des_terminee", "click", function(evt){Event.stop(evt);
				 if (is_des_sn_filled ()) {
					
						$("titre_alert").innerHTML = 'Confirmer';
						$("texte_alert").innerHTML = 'Confirmer la validation du bon de désassemblage';
						$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
						
						$("alert_pop_up_tab").style.display = "block";
						$("framealert").style.display = "block";
						$("alert_pop_up").style.display = "block";
						
						$("bouton0").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
						maj_etat_doc (56);
						$("des_terminee").hide();
						}
						
						$("bouton1").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
						} 
					} else {
					
						$("titre_alert").innerHTML = 'Confirmer';
						$("texte_alert").innerHTML = 'Les numéros de série de l\'article à désassembler ne sont pas tous indiqués<br />Confirmer la validation du bon de désassemblage ?<br /> ';
						$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
						
						$("alert_pop_up_tab").style.display = "block";
						$("framealert").style.display = "block";
						$("alert_pop_up").style.display = "block";
						
						$("bouton0").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
						maj_etat_doc (56);
						$("des_terminee").hide();
						}
						
						$("bouton1").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
						} 
						
					}
			}, false);
			is_sn_filled ();
			<?php 
			}
			?>
		
		
		
		//on masque le chargement
		H_loading();
		
		</script>
		</div>
		</div>
		</td>
	</tr>
	<tr>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
		<td style="width:4%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
	</tr>
	<tr>
		<td>
		<div id="block_contact">

		
		</div>
		
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="document_reglement_entete" class="document_box">
			<tr style=" line-height:20px; height:20px;" class="document_head_list">
				<td  style=" padding-left:3px;" class="doc_bold" >
					Article désassemblé
					
				</td>
			</tr>
			<tr>
				<td style=" height:135px">
				
				<div style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:99%; display:block; height:135px; padding:3px;" id="liste_article_des">
				<?php
				if ($document->getRef_article() != "" ) {
					$article_to_des = new article ($document->getRef_article());
					
					?>
					
					<table width="99%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="width:235px">
								<div id="go_view_art_des" style="cursor:pointer"><?php echo $document->getRef_article();?>  <?php echo $article_to_des->getLib_article();?>
								</div>
								
								<script type="text/javascript">
								Event.observe("go_view_art_des", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo $document->getRef_article()?>'),'true','_blank');}, false);
								</script>
							</td>
						</tr>
						<tr>
							<td style="width:235px; text-align:right">
							<?php 
							if ($document->getId_etat_doc () != 56) {
								?>
								<div id="modifier_art_to_des" style="cursor:pointer">
								Changer l'article à désassembler
								</div>
								<SCRIPT type="text/javascript">
								
								Event.observe('modifier_art_to_des', "click", function(evt){  
									$('id_stock_cata_m').value = $("id_stock").value;
									show_mini_moteur_articles ('set_ref_article_to_des', '\''+$("ref_doc").value+'\'');
								Event.stop(evt);});
								</SCRIPT>
								<?php
							}
							?>
							</td>
						</tr>
						<tr>
							<td style="width:235px">
								Quantité à désassembler: <span id="aff_qte_des"><?php echo $document->getQte_des();?></span>
								<span id="edi_qte_des" style="display: none;">
								<input value="<?php echo $document->getQte_des();?>" type="text" id="qte_des" name="qte_des" size="4"/>
								&nbsp;&nbsp;&nbsp;&nbsp; initialiser le contenu <input type="radio" id="raz_doc_1" name="maj_raz_qte_des" value="1" checked="checked"/> oui <input type="radio" id="raz_doc_0" name="maj_raz_qte_des" value="0"/> non 
								</span>
							</td>
						</tr>
						<tr>
							<td style="width:235px; text-align:right">
							<?php 
							if ($document->getId_etat_doc () != 56) {
								?>
								<div id="modifier_qte_art_to_des" style="cursor:pointer">
								Modifier la quantité à désassembler
								</div>
								<span id="set_qte_art_to_des" style="cursor:pointer; display:none" >
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" border="0">		
								</span>
								<SCRIPT type="text/javascript">
								Event.observe('modifier_qte_art_to_des', "click", function(evt){  
									$("aff_qte_des").hide();
									$("modifier_qte_art_to_des").hide();
									$("edi_qte_des").show();
									$("set_qte_art_to_des").show();
									Event.stop(evt);
								});
								Event.observe('qte_des', "blur", function(evt){  
									Event.stop(evt);
									nummask(evt,"0", "X");
								});
								
								Event.observe('set_qte_art_to_des', "click", function(evt){  
									if ($("raz_doc_1").checked) {
										set_qte_to_des ("<?php echo $document->getRef_doc();?>", $("qte_des").value, 1);
									} else {
										set_qte_to_des ("<?php echo $document->getRef_doc();?>", $("qte_des").value, 0);
									}
									Event.stop(evt);
								});
								</SCRIPT>
								<?php
							}
							?>
							</td>
						</tr>
					</table><br />
						<?php
					if ($article_to_des->getGestion_sn () == 1) {
						$liste_des_sn = $document->getDes_sn();
						?><div id="des_liste_sn">
						<?php
						
						
						for ($i=0; $i<$document->getQte_des(); $i++) {
							?>
							<div id="num_des_sn_<?php echo $i;?>">
							<span id="more_sn_<?php echo $i;?>" class="more_sn_class" >sn:</span> <input value="<?php if (isset($liste_des_sn[$i])) {echo $liste_des_sn[$i];}?>" type="text" id="art_sn_<?php echo $i;?>" name="art_sn_<?php echo $i;?>" /> 
							<input value="<?php if (isset($liste_des_sn[$i])) {echo $liste_des_sn[$i];}?>" type="hidden" id="old_art_sn_<?php echo $i;?>" name="old_art_sn_<?php echo $i;?>"/>
							<a href="#" id="sup_sn_<?php echo $i;?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">		
							</a>
						<div class="sn_block_choix" id="block_choix_sn_<?php echo $i;?>">
						<iframe id="iframe_liste_choix_sn_<?php echo $i;?>" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_sn" style="display:none"></iframe>
						<div id="choix_liste_choix_sn_<?php echo $i;?>"  class="choix_liste_choix_sn" style="display:none"></div>
						</div>
							<script type="text/javascript">
							pre_start_observer_des_sn ( "<?php echo $i;?>", "<?php echo $document->getRef_doc();?>", "art_sn_<?php echo $i;?>" ,"old_art_sn_<?php echo $i;?>", "sup_sn_<?php echo $i;?>", "more_sn_<?php echo $i;?>", "<?php echo $document->getRef_article();?>", "choix_liste_choix_sn_<?php echo $i;?>", "iframe_liste_choix_sn_<?php echo $i;?>" );
							</script>
							</div>
							<?php
						}
						?>
						<input type="hidden" id="art_gest_sn_finliste" name="art_gest_sn_finliste" value="" /></div>
						<?php
					}
					if ($article_to_des->getGestion_sn () == 2) {
						$liste_des_sn = $document->getDes_nl();
						?><div id="des_liste_sn">
						<?php
						
						$nb_nl = array();
						foreach ($liste_des_sn as $diff_nl) {
							if (isset($nb_nl[$diff_nl->numero_serie])) {$nb_nl[$diff_nl->numero_serie] = $nb_nl[$diff_nl->numero_serie] + $diff_nl->sn_qte; }
							if (!isset($nb_nl[$diff_nl->numero_serie])) {$nb_nl[$diff_nl->numero_serie] = $diff_nl->sn_qte; }
							
						}
						$nb_nl_aff = count($nb_nl);
						$i=0;
						if (!$nb_nl_aff) {$nb_nl[] = "";}
						
						foreach ($nb_nl as $nl_key=>$nl_val) {
							?>
							<div id="num_des_nl_<?php echo $i;?>">
							<span id="more_nl_<?php echo $i;?>" class="more_sn_class" >Lot:</span> <input value="<?php if (isset($nl_key)) {echo $nl_key;}?>" type="text" id="art_nl_<?php echo $i;?>" name="art_nl_<?php echo $i;?>" size="10" /> 
							<input value="<?php if (isset($nl_key)) {echo $nl_key;}?>" type="hidden" id="old_art_nl_<?php echo $i;?>" name="old_art_nl_<?php echo $i;?>"/> <input value="<?php if (isset($nl_val)) {echo $nl_val;}?>" type="text" id="qte_nl_<?php echo $i;?>" name="qte_nl_<?php echo $i;?>" size="3" /> 
							<input value="<?php if (isset($nl_val)) {echo $nl_val;}?>" type="hidden" id="old_qte_nl_<?php echo $i;?>" name="old_qte_nl_<?php echo $i;?>"/>
							<a href="#" id="sup_nl_<?php echo $i;?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">		
							</a>
							<div class="sn_block_choix" id="block_choix_nl_<?php echo $i;?>">
							<iframe id="iframe_liste_choix_nl_<?php echo $i;?>" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_nl" style="display:none"></iframe>
							<div id="choix_liste_choix_nl_<?php echo $i;?>"  class="choix_liste_choix_sn" style="display:none"></div>
							</div>
							<script type="text/javascript">
							pre_start_observer_des_nl ( "<?php echo $i;?>", "<?php echo $document->getRef_doc();?>", "art_nl_<?php echo $i;?>" ,"old_art_nl_<?php echo $i;?>", "sup_nl_<?php echo $i;?>", "qte_nl_<?php echo $i;?>" ,"old_qte_nl_<?php echo $i;?>", "more_nl_<?php echo $i;?>", "<?php echo $document->getRef_article();?>", "choix_liste_choix_nl_<?php echo $i;?>", "iframe_liste_choix_nl_<?php echo $i;?>" );
							</script>
							</div>
							<?php
						$i++;
						}
						?>
						<input type="hidden" id="art_gest_nl_finliste" name="art_gest_nl_finliste" value="" />
						</div>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" width="15px" style="cursor:pointer" id="add_line_nl_content" />
							<script type="text/javascript">
							
								Event.observe("add_line_nl_content", "click", function(evt){
								insert_line_des_nl ( $("art_gest_nl_finliste").value, "<?php echo $document->getRef_article();?>", "<?php echo $document->getRef_doc();?>");
								},  false );
							</script>
						<?php
					}
					?></div>
					<div>
					</div>
					</div>
					<?php
					
				} else {
					?>
					<span id="define_ref_article" style="cursor:pointer"> Définir l'article à désassembler </span>
					<SCRIPT type="text/javascript">
					
					Event.observe('define_ref_article', "click", function(evt){  
					
									$('id_stock_cata_m').value = $("id_stock").value;
									show_mini_moteur_articles ('set_ref_article_to_des', '\''+$("ref_doc").value+'\'');
						Event.stop(evt);});
					</SCRIPT>
				</div>
					<?php
				}
				?>
				</td>
			</tr>
		</table>
	
		</td>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
			<tr style=" line-height:20px; height:20px;" class="">
				<td colspan="3">&nbsp;
				
				</td>
			</tr>
		</table>
		</td>
		<td>
		<div id="block_reglement">
		<div style="width:100%;">
		<?php
		if ($document->getACCEPT_REGMT() == 1) { 
			?>
			<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements_entete.inc.php" ?>
			<?php
		}
		?>
		</div>
		</div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

<script type="text/javascript">
	quantite_locked = <?php if ($document->getQuantite_locked ()) {echo "true";} else {echo "false";} ?>;

<?php if (!isset($load) && $document->getACCEPT_REGMT() != 1) {?>
document_calcul_tarif ();
//on masque le chargement
H_loading();
<?php } ?>
</script>