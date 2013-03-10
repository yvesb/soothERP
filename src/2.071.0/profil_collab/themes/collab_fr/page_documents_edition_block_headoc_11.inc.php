<?php

// *************************************************************************************************************
// ENTETE INVENTAIRE
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
							<td style="width:150px; padding-left:3px;">
								&Eacute;tat:					</td>
							<td style="width:250px; font-weight:bolder;">
								<?php echo ($document->getLib_etat_doc());?>					</td>
							<td>					</td>
						</tr>
					<?php
					if (count($stocks_liste)>1) {
						?>
						<tr style=" line-height:24px; height:24px;">
							<td style="width:150px; padding-left:3px;">
								Lieu de stockage:					</td>
							<td style="width:250px;">
								<select id="id_stock" name="id_stock" class="classinput_lsize" <?php 
				if ($document->getId_etat_doc () == 46) {
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
						?>
								<select id="id_stock" name="id_stock" style="display:none" <?php 
				if ($document->getId_etat_doc () == 46) {
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
											if ($document->getId_etat_doc () == 44 && $_SESSION['user']->check_permission ("35")) {
												?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_inv_valider.gif" id="inventaire_valider" style="cursor:pointer"/>
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
			if (count($stocks_liste)>1) {
				?>
				Event.observe("id_stock", "change", function(evt){ maj_entete_id_stock ("id_stock"); }, false);
				<?php
			}
			?>

			
			<?php 
			if ($document->getId_etat_doc () == 44 && $_SESSION['user']->check_permission ("21")) {
				?>
				// pret
				Event.observe("inventaire_valider", "click", function(evt){Event.stop(evt);
				 
	
		$("titre_alert").innerHTML = 'Confirmer';
		$("texte_alert").innerHTML = 'Confirmer la validation de l\'inventaire';
		$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
		
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		maj_etat_doc (46);
		$("inventaire_valider").hide();
		}
		
		$("bouton1").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
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
		
		<table cellpadding="0" cellspacing="0" border="0" style="width:550px" id="document_reglement_entete" class="document_box">
			<tr style=" line-height:20px; height:20px;" class="document_head_list">
				<td  style=" padding-left:3px;" class="doc_bold" >
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_extend.gif" border="0" id="extend_click" style="float:right; cursor:pointer" title="Agrandir">
					Liste des catégories
				<script type="text/javascript">
				Event.observe("extend_click", "click", function(evt){Event.stop(evt);
					if ($("extend_liste").style.height == "135px") {
					$("extend_click").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_reduire.gif";
					$("extend_click").title = "Réduire";
					$("extend_liste").style.width = "550px";
					$("extend_liste").style.height = "450px";
					} else {
					$("extend_click").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_extend.gif";
					$("extend_click").title = "Agrandir";
					$("extend_liste").style.width = "100%";
					$("extend_liste").style.height = "135px";
					}
				}, false);
				 
				</script>
					
				</td>
			</tr>
			<tr>
				<td style=" height:135px">
				<div style="position:relative">
				<div style="position:absolute;OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:block; height:135px; left:-1px; top:-1px; z-index:120" id="extend_liste" class="document_box"  >
				<div id="liste_art_categ_inventaire" style=" padding:3px;">
				<?php
				$art_categs = $document->getArt_categs();
				if (isset($art_categs[0]) && $art_categs[0] == "") {unset($art_categs[0]);}
				if (count($art_categs)) {
					$liste_art_categ = get_articles_categories();
					foreach ($art_categs as $art_categ) {
						if (isset($liste_art_categ[$art_categ])) {
							?>
							<span id="edit_stock_art_categ_<?php echo $liste_art_categ[$art_categ]->ref_art_categ;?>" style="cursor:pointer; float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="Etat du stock" title="Etat du stock"/></span>
							<span id="supp_art_categ_<?php echo $liste_art_categ[$art_categ]->ref_art_categ;?>" style="cursor:pointer; float:right <?php if ($document->getId_etat_doc () == 46) { echo ';display: none';}	?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" title="supprimer"></span>
							<?php echo $liste_art_categ[$art_categ]->lib_art_categ;?><br />
					<SCRIPT type="text/javascript">
					
					Event.observe('edit_stock_art_categ_<?php echo $liste_art_categ[$art_categ]->ref_art_categ;?>', "click", function(evt){  
						Event.stop(evt);
						
						page.verify('stocks_etat_imprimer','stocks_etat_imprimer.php?ref_art_categ=<?php echo $liste_art_categ[$art_categ]->ref_art_categ;?>&ref_constructeur=&aff_pa=0&orderby=ASC&orderorder=lib_article&in_stock=0&id_stocks='+$("id_stock").options[$("id_stock").selectedIndex].value,'true','_blank');
					});
					Event.observe('supp_art_categ_<?php echo $liste_art_categ[$art_categ]->ref_art_categ;?>', "click", function(evt){  
						Event.stop(evt);
						alerte.confirm_supprimer_art_categ_inv ("inventaire_art_categ_supprime", "<?php echo $liste_art_categ[$art_categ]->ref_art_categ;?>");
						
					});
					</SCRIPT>
							<?php
						}
					}
					?>
					</div>
					<div style=" border-top:1px solid #999999<?php if ($document->getId_etat_doc () == 46) { echo ';display: none';}	?>">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="width:235px">
								<span style="position:relative; width:100%;" class="simule_champs" id="liste_de_categorie_pour_article_inv">
									<a href="#" id="lib_art_categ_link_select_inv" style="display:block; width:100%; cursor: default;">
									<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
									<tr>
									<td>
									<span id="lib_art_categ_inv" style=" float:left; height:18px; margin-left:3px; line-height:18px;">Ajouter une catégorie</span>	
									</td>
									<td>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="lib_art_categ_bt_select_inv">
									</td>
									</tr>
									</table>
									</a>
									<iframe id="iframe_liste_de_categorie_selectable_inv" frameborder="0" scrolling="no" src="about:_blank" style="display: none; z-index:249; position:absolute;  top: 1.65em; left: -1px; width:300px; height:300px;  filter:alpha(opacity=0); -moz-opacity:.0; opacity:.0; "></iframe>
									<div id="liste_de_categorie_selectable_inv" style="display:none; z-index:250; position:absolute;  top: 1.65em; left: -1px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90);-moz-opacity:.90; opacity:.90; width:270px; height:300px; overflow:auto;"></div>
								</span>
								<script type="text/javascript">
							//effet de survol sur le faux select
								Event.observe('lib_art_categ_link_select_inv', 'mouseover',  function(){$("lib_art_categ_bt_select_inv").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
								Event.observe('lib_art_categ_link_select_inv', 'mousedown',  function(){$("lib_art_categ_bt_select_inv").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
								Event.observe('lib_art_categ_link_select_inv', 'mouseup',  function(){$("lib_art_categ_bt_select_inv").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
								Event.observe('lib_art_categ_link_select_inv', 'mouseout',  function(){$("lib_art_categ_bt_select_inv").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
								Event.observe('lib_art_categ_link_select_inv', 'click',  function(evt){Event.stop(evt); Element.toggle('liste_de_categorie_selectable_inv'); Element.toggle('iframe_liste_de_categorie_selectable_inv');	
									if ($("liste_de_categorie_selectable_inv").innerHTML == "") {
									load_liste_categ ("documents_inventaire_liste_categ.php", "liste_de_categorie_selectable_inv");
									}
									$("extend_click").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_reduire.gif";
									$("extend_click").title = "Réduire";
									$("extend_liste").style.width = "550px";
									$("extend_liste").style.height = "450px";
								//$("liste_de_categorie_selectable_s").style.width=	return_width_element("lib_art_categ_link_select_s")+"px";
								//$("iframe_liste_de_categorie_selectable_s").style.width=	return_width_element("lib_art_categ_link_select_s")+"px";
								}, false);
							
									</script>	</td>
							<td>
								<input type="hidden" name="new_inv_ref_art_categ_inv" id="new_inv_ref_art_categ_inv" value=""/>
								<input type="checkbox" name="add_art_categ_pre_remplir" id="add_art_categ_pre_remplir" value="1"/> pré-remplir</td>
							<td>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" name="add_new_art_categ_inv" id="add_new_art_categ_inv"/>
								<SCRIPT type="text/javascript">
								
								Event.observe('add_new_art_categ_inv', "click", function(evt){
									if ($("new_inv_ref_art_categ_inv").value != "") {
										if ($("add_art_categ_pre_remplir").checked) {
											add_inv_content_art_categ ($("new_inv_ref_art_categ_inv").value, "1", $("ref_constructeur_insert").value);  
										} else {
											add_inv_content_art_categ($("new_inv_ref_art_categ_inv").value, "0", $("ref_constructeur_insert").value);
										}
									}
									Event.stop(evt);
								});
								</SCRIPT>
							</td>
						</tr>
						<tr>
							<td style="width:235px">Constructeur:<br />
							
				<select name="ref_constructeur_insert" id="ref_constructeur_insert" class="classinput_xsize"><option value="">Tous</option></select>
				<script type="text/javascript">
				
				Event.observe('ref_constructeur_insert', "click", function(evt){
					if ($("ref_constructeur_insert").innerHTML == "<option value=\"\">Tous</option>") {
						var constructeurUpdater = new SelectUpdater("ref_constructeur_insert", "constructeurs_liste.php?ref_art_categ="+$("new_inv_ref_art_categ_inv").value);
						constructeurUpdater.run("");
					}
				});
				</script>
							</td>
							<td>
							<td>
							</td>
						</tr>
					</table>

					<?php
				} else {
					?>
					<span id="define_art_categ" style="cursor:pointer<?php if ($document->getId_etat_doc () == 46) { echo ';display: none';}	?>"> Définir les catégories d'articles inventoriées </span>
					<SCRIPT type="text/javascript">
					
					Event.observe('define_art_categ', "click", function(evt){load_content_inv_list_art_categ ();  
						Event.stop(evt);});
					</SCRIPT>
					<?php
				}
				?>
				</div>
				</div>
				</div>
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