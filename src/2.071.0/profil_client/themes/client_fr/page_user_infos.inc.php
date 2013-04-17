<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("contact", "adresse_facturation", "adresse_livraison", "civilites", "listepays", "user", "coordonnee", "editable");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<?php include("header.php"); ?>

<?php include("top.php"); ?>

<?php include("menu.php"); ?>

<?php include("content_before.php"); ?>

<br />
<br />
<div  class="para">

	<br />

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr style="">
			<td style="height:150px; width:380px; padding-left:25px; padding-right:25px;">
				<table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF">
					<tr>
						<td class="lightbg_liste1">&nbsp;</td>
						<td class="lightbg_liste"></td>
						<td class="lightbg_liste2">&nbsp;</td>
					</tr>
					<tr>
						<td class="lightbg_liste">&nbsp;</td>
						<td class="lightbg_liste">
							<div class="title_content">
								<img  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_contact.gif" style="vertical-align:text-bottom"/>
								MES DONNEES PERSONNELLES
							</div>
					
							<div  style="width:100%;	margin:0px auto;">
								<table class="conteneir">
									<tr>
										<td class="top_log" colspan="4">
											<div id="block_contact">
												<div style="width:100%; display:" id="view_infos_contact">
													<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="infos_contact_affichage">
														<tr style=" line-height:20px; height:20px;" class="panier_head_list">
															<td style=" padding-left:3px;" class="doc_bold" >
																<input type="hidden" name="ref_contact"  id="ref_contact" value="<?php echo $contact->getRef_contact();?>"/>
															</td>
															<td></td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<td class="main_info_user" >
																D&eacute;nomination: 
															</td>
															<td class="text_variable_user">
																<?php echo nl2br($contact->getNom());?>
															</td>
														</tr>
														<tr>
															<td class="text_variable" >
																Civilité: 
															</td>
															<td class="text_variable_user">
																<?php echo nl2br($contact->getLib_civ_court());?>
															</td>
															<td>
														</tr>
														<tr>
															<td  class="text_variable" >
																Type: 
															</td>
															<td   class="text_variable_user">
																<?php echo nl2br($contact->getLib_Categorie());?>
															</td>
															<td>
														</tr>
														<?php if ($contact->getSiret()) { ?>
														<tr>
															<td class="text_variable" >
																Siret: 
															</td>
															<td class="text_variable_user">
																<?php echo nl2br($contact->getSiret());?>
															</td>
														</tr>
														<?php }
														if ($contact->getTva_intra()) { ?>
														<tr>
															<td class="text_variable" >
																T.V.A. intra: 
															</td>
															<td class="text_variable_user">
																<?php echo nl2br($contact->getTva_intra());?>
															</td>
														</tr>
														<?php } ?>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<td colspan="2" class="main_info_user" >
																Adresse de Facturation:
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Adresse:
															</td>
															<td class="text_variable_user">
																<?php echo nl2br($adresse_facturation->getText_adresse());?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
															Code Postal:
															</td>
															<td class="text_variable_user">
															<?php echo $adresse_facturation->getCode_postal(); ?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
															Ville:
															</td>
															<td class="text_variable_user">
															<?php echo $adresse_facturation->getVille();?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Pays:
															</td>
															<td class="text_variable_user">
																<?php $separe_listepays = 0;
																foreach ($listepays as $payslist){
																	if((!$separe_listepays) && (!$payslist->affichage)){ 
																		$separe_listepays = 1; ?>
																		<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
																	<?php }
																	if($adresse_facturation->getId_pays() == $payslist->id_pays)
																	{		echo htmlentities($payslist->pays);}
																	if(!$adresse_facturation->getId_pays() && $DEFAUT_ID_PAYS == $payslist->id_pays)
																	{		echo htmlentities($payslist->pays);}
																} ?>
															</td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<td colspan="2" class="main_info_user">
																Adresse de Livraison: 
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Adresse:
															</td>
															<td class="text_variable_user">
																<?php echo nl2br($adresse_livraison->getText_adresse());?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Code Postal:
															</td>
															<td class="text_variable_user">
																<?php echo $adresse_livraison->getCode_postal();?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Ville:
															</td>
															<td class="text_variable_user">
																<?php echo $adresse_livraison->getVille();?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Pays:
															</td>
															<td class="text_variable_user">
																<?php $separe_listepays = 0;
																foreach ($listepays as $payslist){
																	if ((!$separe_listepays) && (!$payslist->affichage)) { 
																		$separe_listepays = 1; ?>
																		<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
																	<?php }
																	if($adresse_livraison->getId_pays() == $payslist->id_pays)
																	{		echo htmlentities($payslist->pays);}
																	if(!$adresse_livraison->getId_pays() && $DEFAUT_ID_PAYS == $payslist->id_pays)
																	{		echo htmlentities($payslist->pays);}
																} ?>
															</td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<td colspan="2" class="main_info_user" >
																Coordonnées:
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Tél:
															</td>
															<td  class="text_variable_user">
																<?php echo $coordonnee->getTel1();?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Tél 2:
															</td>
															<td  class="text_variable_user">
																<?php echo $coordonnee->getTel2();?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Fax:
															</td>
															<td  class="text_variable_user">
																<?php echo $coordonnee->getFax();?>
															</td>
														</tr>
														<tr>
															<td class="text_variable">
																Email:
															</td>
															<td  class="text_variable_user">
																<?php echo $coordonnee->getEmail();?>
															</td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
													</table>
												</div>
												<?php if($editable){?>
												<div style="width:100%; display:none;" id="infos_contact_modifier">
													<form action="_user_infos_modifier.php" method="post" name="formulaire_maj_client" id="formulaire_maj_client">
														<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="infos_contact_entete">
															<tr style=" line-height:20px; height:20px;" class="panier_head_list">
																<td style=" padding-left:3px;" class="doc_bold" >
																	<input type="hidden" name="ref_contact"  value="<?php echo $contact->getRef_contact();?>"/>
																</td>
																<td></td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td class="main_info_user" >
																	D&eacute;nomination: 
																</td>
																<td class="text_variable_user">
																	<textarea id="nom" name="nom" class="classinput_xsize" ><?php 
																		echo ($contact->getNom());
																	?></textarea>
																</td>
															</tr>
															<tr>
																<td  class="text_variable" >
																	Civilité: 
																</td>
																<td class="text_variable_user">
																	<select name="id_civilite" id="id_civilite" class="classinput_xsize">
																	<?php foreach ($civilites as $civ) { ?>
																		<option <?php echo 'value="'.urlencode($civ->id_civilite).'" ';
																						if($civ->id_civilite == $contact->getId_civilite())
																						{		echo 'selected="selected"';}?>>
																			<?php echo ($civ->lib_civ_court)?>
																		</option>
																	<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td  class="text_variable" >
																	Type: 
																</td>
																<td class="text_variable_user">
																	<select id="id_categorie" name="id_categorie" class="classinput_xsize">
																		<?php foreach ($ANNUAIRE_CATEGORIES as $categorie) { ?>
																		<option <?php echo 'value="'.$categorie->id_categorie.'" ';
																						if($categorie->id_categorie == $contact->getId_Categorie())
																						{		echo 'selected="selected" '; }?>>
																			<?php echo ($categorie->lib_categorie)?>
																		</option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr id="line_siret" <?php if(!$contact->getSiret()) {echo 'style="display:none;"';} ?>>
																<td class="text_variable" >
																	Siret: 
																</td>
																<td class="text_variable_user">
																	<input type="text" id="siret" name="siret" rows="2" value="<?php echo $contact->getSiret();?>"  class="classinput_xsize"/>
																</td>
															</tr>
															<tr id="line_tva_intra" <?php if(!$contact->getTva_intra()) {echo 'style="display:none;"';} ?>>
																<td class="text_variable" >
																	T.V.A. intra: 
																</td>
																<td class="text_variable_user">
																	<input type="text" id="tva_intra" name="tva_intra" rows="2" value="<?php echo $contact->getTva_intra();?>"  class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2" class="main_info_user" >
																	Adresse de Facturation:
																	<input name="facturation_ref_adresse" id="facturation_ref_adresse" type="hidden" value="<?php echo htmlentities($profil_client->getRef_adr_facturation ()); ?>" />
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Adresse:
																</td>
																<td class="text_variable_user">
																	<textarea name="facturation_adresse" id="facturation_adresse" rows="2" class="classinput_xsize" ><?php
																	echo $adresse_facturation->getText_adresse();
																	?></textarea>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Code Postal:
																</td>
																<td class="text_variable_user">
																	<input name="facturation_code_postal" id="facturation_code_postal" type="text" class="classinput_xsize" value="<?php echo $adresse_facturation->getCode_postal(); ?>" />
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Ville:
																</td>
																<td class="text_variable_user">
																	<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
																		<iframe id="iframe_facturation_choix_ville" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
																		<div id="facturation_choix_ville"  class="choix_complete_ville">
																			<?php echo $adresse_facturation->getVille();?>
																		</div>
																	</div>
																	<input name="facturation_ville" id="facturation_ville" value="<?php echo  ($adresse_facturation->getVille());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Pays:
																</td>
																<td class="text_variable_user">
																	<select id="facturation_id_pays"  name="facturation_id_pays" class="classinput_xsize" title="Pays">
																	<?php $separe_listepays = 0;
																	foreach ($listepays as $payslist){
																		if ((!$separe_listepays) && (!$payslist->affichage)) { 
																			$separe_listepays = 1; ?>
																			<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
																		<?php } ?>
																		<option <?php echo 'value="'.$payslist->id_pays.'" ';
																						if((!$adresse_facturation->getId_pays() && $DEFAUT_ID_PAYS == $payslist->id_pays) || $adresse_facturation->getId_pays() == $payslist->id_pays)
																						{		echo 'selected="selected"';}?>>
																			<?php echo htmlentities($payslist->pays)?>
																		</option>
																	<?php } ?>
																	</select>
																	<script type="text/javascript">
																		Event.observe('facturation_ville', 'focus',  function(){
																			start_commune("facturation_code_postal", "facturation_ville", "facturation_choix_ville", "iframe_facturation_choix_ville", "liste_ville.php?cp=");
																		}, false);
																			
																		Event.observe('facturation_id_pays', 'focus',  function(){
																			delay_close("facturation_choix_ville", "iframe_facturation_choix_ville");
																		}, false);
																	</script>
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;
																</td>
															</tr>
															<tr>
																<td colspan="2" class="main_info_user">
																	Adresse de Livraison: 
																	<input name="livraison_ref_adresse" id="livraison_ref_adresse" type="hidden" class="classinput_xsize" value="<?php echo htmlentities($profil_client->getRef_adr_livraison ()); ?>" />
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Adresse:
																</td>
																<td class="text_variable_user">
																	<textarea id="livraison_adresse" name="livraison_adresse" rows="2" class="classinput_xsize"/><?php
																	echo  ($adresse_livraison->getText_adresse());
																	?></textarea>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Code Postal:
																</td>
																<td class="text_variable_user">
																	<input id="livraison_code_postal" name="livraison_code_postal" value="<?php echo  ($adresse_livraison->getCode_postal());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Ville:
																</td>
																<td class="text_variable_user">
																	<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
																		<iframe id="iframe_livraison_choix_ville" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
																		<div id="livraison_choix_ville"  class="choix_complete_ville">
																			<?php echo  ($adresse_livraison->getVille());?>
																		</div>
																	</div>
																	<input name="livraison_ville" id="livraison_ville" value="<?php echo  ($adresse_livraison->getVille());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																Pays:
																</td>
																<td class="text_variable_user">
																	<select id="livraison_id_pays"  name="livraison_id_pays" class="classinput_xsize" title="Pays">
																		<?php $separe_listepays = 0;
																		foreach ($listepays as $payslist){
																			if ((!$separe_listepays) && (!$payslist->affichage)) { 
																				$separe_listepays = 1; ?>
																				<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
																				<?php } ?>
																			<option <?php echo 'value="'.$payslist->id_pays.'" ';
																							if((!$adresse_facturation->getId_pays() && $DEFAUT_ID_PAYS == $payslist->id_pays) || $adresse_facturation->getId_pays() == $payslist->id_pays)
																							{		echo 'selected="selected"';}?>>
																				<?php echo htmlentities($payslist->pays)?>
																			</option>
																			<?php } ?>
																	</select>
																	<script type="text/javascript">
																		Event.observe('livraison_ville', 'focus',  function(){
																			start_commune("livraison_code_postal", "livraison_ville", "livraison_choix_ville", "iframe_livraison_choix_ville", "liste_ville.php?cp=");
																		}, false);
																			
																		Event.observe('livraison_id_pays', 'focus',  function(){
																			delay_close("livraison_choix_ville", "iframe_livraison_choix_ville");
																		}, false);
																	</script>
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2" class="main_info_user" >
																	Coordonnées:
																	<input name="ref_coordonnee" id="ref_coordonnee" type="hidden" class="classinput_xsize" value="<?php echo $coordonnee->getRef_coord(); ?>" />
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Tél:
																</td>
																<td class="text_variable_user">
																	<input id="coordonnee_tel1" name="coordonnee_tel1" value="<?php echo  ($coordonnee->getTel1());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Tél 2:
																</td>
																<td class="text_variable_user">
																<input id="coordonnee_tel2" name="coordonnee_tel2" value="<?php echo  ($coordonnee->getTel2());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Fax:
																</td>
																<td class="text_variable_user">
																	<input id="coordonnee_fax" name="coordonnee_fax" value="<?php echo  ($coordonnee->getFax());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																Email:
																</td>
																<td class="text_variable_user">
																<input type="text" 		id="emaila" name="emaila" value="<?php echo  ($coordonnee->getEmail());?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2" class="main_info_user" >
																	Identifiants:
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Pseudo:
																</td>
																<td  class="text_variable_user">
																	<input type="text" 		id="pseudo"    name="pseudo"    value="<?php echo  $user->getPseudo();?>" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2" class="main_info_user" >
																	Mot de passe:
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Ancien :
																</td>
																<td  class="text_variable_user">
																	<input type="password" id="passwordold" name="passwordold" value="" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Nouveau :
																</td>
																<td  class="text_variable_user">
																	<input type="password" id="passworda" name="passworda" value="" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td class="text_variable">
																	Confirmation :
																</td>
																<td  class="text_variable_user">
																	<input type="password" id="passwordb" name="passwordb" value="" class="classinput_xsize"/>
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
														</table>
														
														<div style="text-align:right">
															<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_valider.gif" />
														</div>
													</form>
												</div>
												
												<script type="text/javascript">
													Event.observe("formulaire_maj_client", "submit",  function(evt){
														Event.stop(evt);
														check_majinfos_contact();
													}, false);
													
													start_civilite("id_categorie", "id_civilite", "civilite.php?cat=");
													
													Event.observe("id_categorie", "change",  function(evt){
														if ($("id_categorie").value == "2") {
															$("line_siret").show(); 
															$("line_tva_intra").show(); 
														} else {
															$("line_siret").hide(); 
															$("line_tva_intra").hide(); 
														}
													}, false);
												</script>
														
												<div style="text-align:right" >
													<img  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_modifier.gif" id="view_edit_infos" style="cursor:pointer"/>
													<script type="text/javascript">		
														Event.observe('view_edit_infos', 'click',  function(evt){
															$("view_edit_infos").hide();
															$("view_infos_contact").hide();
															$("infos_contact_modifier").show();
														}, false);
													</script>
												</div>
												<?php } ?>
											</div>
										</td>
									</tr>
								</table>
								
							</div>
						</td>
							<td class="lightbg_liste">&nbsp;</td>
						</tr>
						<tr>
							<td class="lightbg_liste4"></td>
							<td class="lightbg_liste">&nbsp;</td>
							<td class="lightbg_liste3">&nbsp;</td>
						</tr>
					</table>
				</div>
			</td>
			<td>
				<div style="padding-right:15px">
					<table border="0" cellspacing="0" cellpadding="0" style="  width:100%;">
						<tr>
							<td class="doc_titre_img_cadre1"></td>
							<td  style="background-color:#ffffff;"></td>
							<td class="doc_titre_img_cadre2"></td>
						</tr>
						<tr>
							<td  style="background-color:#ffffff; width:5px"></td>
							<td class="lightbg_liste" style="font-weight:bolder; font-size:12px" >
								MES DEVIS
							</td>
							<td  style="background-color:#ffffff; width:5px"></td>
						</tr>
						<tr>
							<td class="doc_titre_img_cadre3" style="background-color:#FFFFFF" ></td>
							<td style="background-color:#ffffff; line-height:5px; height:5px"></td>
							<td class="doc_titre_img_cadre4" style="background-color:#FFFFFF" ></td>
						</tr>
					</table>
					
					<br />
			
					<?php $liste_devis = get_liste_doc($DEVIS_CLIENT_ID_TYPE_DOC, "3", $_SESSION['user']->getRef_contact()); ?>
					
					<?php if (count($liste_devis)) { ?>
					<table border="0" cellspacing="0" cellpadding="0" style="  width:100%; height:18px">
						<tr>
							<td class="doc_img_cadre1"></td>
							<td style="background-color:#636363;"></td>
							<td class="doc_img_cadre2"></td>
						</tr>
						<tr>
							<td style="background-color:#636363;"></td>
							<td style="background-color:#636363; padding:5px" >
							
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="doc_intit_colors" >Date</td>
										<td class="doc_intit_colors">Référence</td>
										<td class="doc_intit_colors" style="text-align:right; padding-right:15px">Montant</td>
										<td class="doc_intit_colors">&nbsp;</td>
										<td class="doc_intit_colors">&nbsp;</td>
									</tr>
									<?php foreach ($liste_devis as $doc_dev) { ?>
									<tr>
										<td class="doc_infos_colors" >
											<?php echo date_Us_to_Fr($doc_dev->getDate_creation());?>
										</td>
										<td class="doc_infos_colors">
											<?php echo $doc_dev->getRef_doc();?>
										</td>
										<td class="doc_infos_colors" style="text-align:right; padding-right:15px">
											<?php echo number_format($doc_dev->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; ?>
										</td>
										<td class="doc_infos_colors">
											&nbsp;
										</td>
										<td class="doc_infos_colors">
											<a href="documents_editing_print.php?ref_doc=<?php echo $doc_dev->getRef_doc();?>&code_pdf_modele=<?php echo $CODE_PDF_MODELE_DEV;?>" target="_blank" >
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/>
											</a>
										</td>
									</tr>
									<?php } ?>
								</table>
							
							</td>
							<td style="background-color:#636363;"></td>
						</tr>
						<tr>
							<td class="doc_img_cadre3"></td>
							<td style="background-color:#636363;"></td>
							<td class="doc_img_cadre4"></td>
						</tr>
					</table>
					
					<div id="aff_archives_devis" style="display: none;"></div>
					
			    <span id="archives_devis" style="margin:10px;color:white;cursor: pointer; text-decoration: underline;">Consulter les archives</span>
			    
	        <script type="text/javascript">
	          Event.observe("archives_devis", "click", function (evt) {
	        	  loadArchives("aff_archives_devis", <?php echo $DEVIS_CLIENT_ID_TYPE_DOC; ?>, 4, "<?php echo $_SESSION['user']->getRef_contact(); ?>");
	          }, false);
	        </script>
	        
					<br />
					<br />
			
					<?php } ?>
			
					<table border="0" cellspacing="0" cellpadding="0" style="  width:100%;">
						<tr>
							<td class="doc_titre_img_cadre1"></td>
							<td  style="background-color:#ffffff;"></td>
							<td class="doc_titre_img_cadre2"></td>
						</tr>
						<tr>
							<td  style="background-color:#ffffff; width:5px"></td>
							<td class="lightbg_liste" style="font-weight:bolder; font-size:12px" >
								MES COMMANDES EN COURS
							</td>
							<td  style="background-color:#ffffff; width:5px"></td>
						</tr>
						<tr>
							<td class="doc_titre_img_cadre3" style="background-color:#FFFFFF" ></td>
							<td style="background-color:#ffffff; line-height:5px; height:5px"></td>
							<td class="doc_titre_img_cadre4" style="background-color:#FFFFFF" ></td>
						</tr>
					</table>
					
					<br />
			
					<?php $liste_comm = get_liste_doc($COMMANDE_CLIENT_ID_TYPE_DOC, "9", $_SESSION['user']->getRef_contact()); ?>
					
					<?php if (count($liste_comm)) { ?>
					<table border="0" cellspacing="0" cellpadding="0" style="  width:100%; height:18px">
						<tr>
							<td class="doc_img_cadre1"></td>
							<td style="background-color:#636363;"></td>
							<td class="doc_img_cadre2"></td>
						</tr>
						<tr>
							<td style="background-color:#636363;"></td>
							<td style="background-color:#636363; padding:5px" >
							
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="doc_intit_colors" >Date</td>
									<td class="doc_intit_colors">Référence</td>
									<td class="doc_intit_colors" style="text-align:right; padding-right:15px">Montant</td>
									<td class="doc_intit_colors">&nbsp;</td>
									<td class="doc_intit_colors">&nbsp;</td>
								</tr>
								<?php foreach ($liste_comm as $doc_cmm) { ?>
								<tr>
									<td class="doc_infos_colors" >
										<?php echo date_Us_to_Fr($doc_cmm->getDate_creation()); ?>
										</td>
									<td class="doc_infos_colors">
										<?php echo $doc_cmm->getRef_doc();?>
									</td>
									<td class="doc_infos_colors" style="text-align:right; padding-right:15px">
										<?php echo number_format($doc_cmm->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; ?>
									</td>
									<td class="doc_infos_colors">&nbsp;</td>
									<td class="doc_infos_colors">
										<a href="documents_editing_print.php?ref_doc=<?php echo $doc_cmm->getRef_doc();?>&code_pdf_modele=<?php echo $CODE_PDF_MODELE_DEV;?>" target="_blank" >
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/>
										</a>
									</td>
								</tr>
								<?php } ?>
							</table>
						
						</td>
						<td style="background-color:#636363;"></td>
					</tr>
					<tr>
						<td class="doc_img_cadre3"></td>
						<td style="background-color:#636363;"></td>
						<td class="doc_img_cadre4"></td>
					</tr>
				</table>
				
        <div id="aff_archives_commandes" style="display: none;"></div>
        
        <span id="archives_commandes" style="margin:10px;color:white;cursor: pointer; text-decoration: underline;">Consulter les archives</span>
        
        <script type="text/javascript">
          Event.observe("archives_commandes", "click", function (evt) {
            loadArchives("aff_archives_commandes", <?php echo $COMMANDE_CLIENT_ID_TYPE_DOC; ?>, 10, "<?php echo $_SESSION['user']->getRef_contact(); ?>");
          }, false);
				</script>
				
				<br />
				<br />
				
				<?php } ?>
					
				<table border="0" cellspacing="0" cellpadding="0" style="  width:100%;">
					<tr>
						<td class="doc_titre_img_cadre1"></td>
						<td  style="background-color:#ffffff;"></td>
						<td class="doc_titre_img_cadre2"></td>
					</tr>
					<tr>
						<td  style="background-color:#ffffff; width:5px"></td>
						<td class="lightbg_liste" style="font-weight:bolder; font-size:12px" >
						MES FACTURES A REGLER
						</td>
						<td  style="background-color:#ffffff; width:5px"></td>
					</tr>
					<tr>
						<td class="doc_titre_img_cadre3" style="background-color:#FFFFFF" ></td>
						<td style="background-color:#ffffff; line-height:5px; height:5px"></td>
						<td class="doc_titre_img_cadre4" style="background-color:#FFFFFF" ></td>
					</tr>
				</table>
				
				<br />
			
				<?php $liste_fac = get_liste_doc($FACTURE_CLIENT_ID_TYPE_DOC, "18", $_SESSION['user']->getRef_contact()); ?>
					
				<?php if (count($liste_fac)) { ?>
				<table border="0" cellspacing="0" cellpadding="0" style="  width:100%; height:18px">
					<tr>
						<td class="doc_img_cadre1"></td>
						<td style="background-color:#636363;"></td>
						<td class="doc_img_cadre2"></td>
					</tr>
					<tr>
						<td style="background-color:#636363;"></td>
						<td style="background-color:#636363; padding:5px" >
						
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="doc_intit_colors" >Date</td>
									<td class="doc_intit_colors">Référence</td>
									<td class="doc_intit_colors" style="text-align:right; padding-right:15px">Montant</td>
									<td class="doc_intit_colors">&nbsp;</td>
									<td class="doc_intit_colors">&nbsp;</td>
								</tr>
								<?php foreach ($liste_fac as $liste_fac) { ?>
								<tr>
									<td class="doc_infos_colors" >
										<?php echo date_Us_to_Fr($liste_fac->getDate_creation());?>
									</td>
									<td class="doc_infos_colors">
										<?php echo $liste_fac->getRef_doc();?>
									</td>
									<td class="doc_infos_colors" style="text-align:right; padding-right:15px">
										<?php echo number_format($liste_fac->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; ?>
									</td>
									<td class="doc_infos_colors">&nbsp;</td>
									<td class="doc_infos_colors">
										<a href="documents_editing_print.php?ref_doc=<?php echo $liste_fac->getRef_doc();?>&code_pdf_modele=<?php echo $CODE_PDF_MODELE_DEV;?>" target="_blank" >
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/>
										</a>
									</td>
								</tr>
								<?php  }
								unset($liste_fac ); ?>
							</table>
							
						</td>
						<td style="background-color:#636363;"></td>
					</tr>
					<tr>
						<td class="doc_img_cadre3"></td>
						<td style="background-color:#636363;"></td>
						<td class="doc_img_cadre4"></td>
					</tr>
				</table>
		     
		     <div id="aff_archives_factures" style="display: none;"></div>
		     
		     <span id="archives_factures" style="margin:10px;color:white;cursor: pointer; text-decoration: underline;">Consulter les archives</span>
		     <script type="text/javascript">
	          Event.observe("archives_factures", "click", function (evt) {
	            loadArchives("aff_archives_factures", <?php echo $FACTURE_CLIENT_ID_TYPE_DOC; ?>, 19, "<?php echo $_SESSION['user']->getRef_contact(); ?>");
	          }, false);
	        </script>
						
					<?php } ?>
					
					<br />
					<br />
					
				</div>
			</td>
		</tr>
	</table>
	
	<br />

</div>
<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>