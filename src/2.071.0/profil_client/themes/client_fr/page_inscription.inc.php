<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<?php include("header.php"); ?>

<?php include("top.php"); ?>

<?php include("menu.php"); ?>

<?php include("content_before.php"); ?>
<div>
	<br />
	<br />
	
	<div class="para" style="text-align:center; margin:20px 0px;">
	
		<br />
		<br />
	
		<div style="width:880px;	margin:0px auto;">
			<form action="_inscription_envoi.php" method="post" id="formulaire_nouveau_client">
				<table class="minimizetable" border="0">
					<tr>
						<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td style="width:48%">
							<table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF; height:600px;">
								<tr>
									<td class="lightbg_liste1">&nbsp;</td>
									<td class="lightbg_liste"></td>
									<td class="lightbg_liste2">&nbsp;</td>
								</tr>
								<tr>
									<td class="lightbg_liste">&nbsp;</td>
									<td class="lightbg_liste">
										<input type="hidden" id="inscription" name="inscription"  value=""/>
										<input type="hidden" id="profils_inscription" name="profils_inscription"  value="<?php echo $_INTERFACE['ID_PROFIL'];?>"/>
						
										<div class="title_content" style="text-align:right">
											INFORMATIONS PERSONNELLES <img  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_contact.gif" style="vertical-align:text-bottom"/>
										</div>
										
										<br />
										<br />
										<br />
										<br />
										<br />
										
										<div class="sous_titre1">
											Identité
										</div>
										
										<table class="minimizetable">
											<tr>
												<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
												<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											</tr>	
											<tr>
												<td  class="size_strict">
													<span class="labelled_court">Cat&eacute;gorie:</span>
												</td>
												<td>
													<select id="id_categorie" name="id_categorie" class="classinput_xsize">
														<option value="1" selected="selected">Particulier</option>
														<!-- Modification éffectuée par Yves Bourvon -->
														<!-- catégorie "Société" remplacée par "Entreprise" pour cohérence juridique, table annuaire_catégories de BDD modifiée également dans le même commit -->
														<option value="2">Entreprise</option> 
														<!-- Fin de modification -->
														<option value="3">Administration</option>
														<option value="4">Association</option>
														<option value="5">Autre</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">Civilit&eacute;:</span>
												</td>
												<td>
													<select name="id_civilite" id="id_civilite" class="classinput_xsize">
													<?php foreach ($civilites as $civ) { ?>
														<option value="<?php echo urlencode($civ->id_civilite);?>">
															<?php echo ($civ->lib_civ_court)?>
														</option>
													<?php } ?>
													</select>
													
													<script type="text/javascript">
														start_civilite("id_categorie", "id_civilite", "civilite.php?cat=");
														
														Event.observe("id_categorie", "change",  function(evt){
															if ($("id_categorie").value == "2"){
																$("line_siret").show(); 
																$("line_tva_intra").show(); 
															}else{
																$("line_siret").hide(); 
																$("line_tva_intra").hide(); 
															}
														}, false);
													</script>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">Nom: *</span>
												</td>
												<td>
												<textarea id="nom" name="nom" rows="2"  class="classinput_xsize"></textarea>
												</td>
											</tr>
											<tr id="line_siret" style="display:none">
												<td>
													<span class="labelled_court" title="Numéro de Siret">Siret:</span>
												</td>
												<td>
												<input type="text" id="siret" name="siret" maxlength="20" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr id="line_tva_intra" style="display:none">
												<td>
													<span class="labelled_court" title="Numéro de T.V.A. intracommunautaire">T.V.A. intra:</span>
												</td>
												<td>
												<input type="text" id="tva_intra" name="tva_intra" maxlength="20" value="" class="classinput_xsize"/>
												</td>
											</tr>
										</table>
										<br/>
										
										<div class="sous_titre1">
											Vos identifiants de connexion
										</div>
										
										<br />
					
										<table class="minimizetable">
											<tr>
												<td class="size_strict"><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
												<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											</tr>
											<tr>
												<td  class="size_strict">
												<span class="labelled_ralonger">Pseudonyme: *</span>
												</td>
												<td>
												<input id="pseudo" name="pseudo" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_ralonger">Email: *</span>
												</td>
												<td>
												<input id="emaila" name="emaila" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
												<span class="labelled_ralonger">Confirmer l'adresse Email: *</span>
												</td>
												<td>
												<input id="emailb" name="emailb" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
												<span class="labelled_ralonger">Mot de passe: *</span>
												</td>
												<td>
												<input type="password" id="passworda" name="passworda" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
												<span class="labelled_ralonger">Confirmer le mot de passe: *</span>
												</td>
												<td>
												<input type="password" id="passwordb" name="passwordb" value="" class="classinput_xsize"/>
												</td>
											</tr>
										</table>
										
										<br />
										<br />
										<br />
			
									</td>
									<td class="lightbg_liste">&nbsp;</td>
								</tr>
								<tr>
									<td class="lightbg_liste4"></td>
									<td class="lightbg_liste">&nbsp;</td>
									<td class="lightbg_liste3">&nbsp;</td>
								</tr>
							</table>
						</td>
						<td style="width:25px;"></td>
						<td>
							<table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF; height:600px;">
								<tr>
									<td class="lightbg_liste1">&nbsp;</td>
									<td class="lightbg_liste"></td>
									<td class="lightbg_liste2">&nbsp;</td>
								</tr>
								<tr>
									<td class="lightbg_liste">&nbsp;</td>
									<td class="lightbg_liste">
										<div id="adresse_livraison_block" >
											
											<div class="sous_titre1">
												Adresse de Livraison
											</div>
											
											<table class="minimizetable">
												<tr class="smallheight">
													<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
													<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
												</tr>
												<tr>
													<td  class="size_strict">
														<span class="labelled_court">Adresse:</span>
													</td>
													<td>
														<textarea id="livraison_adresse" name="livraison_adresse" rows="2" class="classinput_xsize"/></textarea>
													</td>
												</tr>
												<tr>
													<td>
														<span class="labelled_court">Code Postal: </span>
													</td>
													<td>
														<input id="livraison_code_postal" name="livraison_code_postal" value="" class="classinput_xsize"/>
													</td>
												</tr>
												<tr>
													<td>
														<span class="labelled_court">Ville: </span>
													</td>
													<td>
														<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
															<iframe id="iframe_livraison_choix_ville" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville">
															</iframe>
															<div id="livraison_choix_ville"  class="choix_complete_ville"></div>
														</div>
														<input name="livraison_ville" id="livraison_ville" value="" class="classinput_xsize"/>
													</td>
												</tr>
												<tr>
													<td>
														<span class="labelled_court">Pays: </span>
													</td>
													<td>
														<?php $listepays = getPays_select_list (); ?>
														
														<select id="livraison_id_pays"  name="livraison_id_pays" class="classinput_xsize" title="Pays">
														<?php $separe_listepays = 0;
														foreach ($listepays as $payslist){
															if ((!$separe_listepays) && (!$payslist->affichage)) { 
																$separe_listepays = 1; ?>
																<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
															<?php } ?>
																<option value="<?php echo $payslist->id_pays?>" <?php if ( $DEFAUT_ID_PAYS == $payslist->id_pays) {echo 'selected="selected"';}?>>
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
													<td></td>
													<td></td>
												</tr>
											</table>
											
											<span id="adresse_livraison_identique" style="display:">
												Adresse de facturation identique à l'adresse de livraison <input id="same_adresse_livraison" name="same_adresse_livraison" type="checkbox" value="1" />
											</span>
											<br />
									
											<script type="text/javascript">
												Event.observe('same_adresse_livraison', 'click',  function(evt){
													if ($("same_adresse_livraison").checked){
														$("facturation_adresse").value			 		= $("livraison_adresse").value;
														$("facturation_code_postal").value 			= $("livraison_code_postal").value;
														$("facturation_ville").value 						= $("livraison_ville").value;
														$("facturation_id_pays").selectedIndex	= $("livraison_id_pays").selectedIndex;
													}
												}, false);
											</script>
										</div>
										
										<br/>
										
										<div class="sous_titre1">
											Adresse de facturation
										</div>
										
										<table class="minimizetable">
											<tr class="smallheight">
												<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
												<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											</tr>
											<tr>
												<td  class="size_strict">
													<span class="labelled_court">Adresse: *</span>
												</td>
												<td>
													<textarea id="facturation_adresse" name="facturation_adresse" rows="2" class="classinput_xsize"/></textarea>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">Code Postal: *</span>
												</td>
												<td>
													<input id="facturation_code_postal" name="facturation_code_postal" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">Ville: *</span>
												</td>
												<td>
													<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
														<iframe id="iframe_facturation_choix_ville" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville">
														</iframe>
														<div id=facturation_choix_ville  class="choix_complete_ville"></div>
													</div>
													<input name="facturation_ville" id="facturation_ville" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">Pays: *</span>
												</td>
												<td>
													<?php $listepays = getPays_select_list (); ?>
													<select id="facturation_id_pays"  name="facturation_id_pays" class="classinput_xsize" title="Pays">
														<?php $separe_listepays = 0;
														foreach ($listepays as $payslist){
															if ((!$separe_listepays) && (!$payslist->affichage)) { 
																$separe_listepays = 1; ?>
																<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
															<?php } ?>
															<option value="<?php echo $payslist->id_pays?>" <?php if ( $DEFAUT_ID_PAYS == $payslist->id_pays) {echo 'selected="selected"';}?>>
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
												<td></td>
												<td></td>
											</tr>
										</table>
										
										<br />
										
										<div class="sous_titre1">
											Coordonnées
										</div>
										
										<table class="minimizetable">
											<tr>
												<td class="size_strict"><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
												<td><img src="'.$distant_install_images.'blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											</tr>
											<tr>
												<td class="size_strict">
													<span class="labelled_court">T&eacute;l&eacute;phone 1:</span>
												</td>
												<td>
													<input id="coordonnee_tel1" name="coordonnee_tel1" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">T&eacute;l&eacute;phone 2:</span>
												</td>
												<td>
													<input id="coordonnee_tel2" name="coordonnee_tel2" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court">Fax:</span>
												</td>
												<td>
													<input id="coordonnee_fax" name="coordonnee_fax" value="" class="classinput_xsize"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="labelled_court" style="width:121px;">Recevoir la newsletter</span>
												</td>
												<td>
													<input type="checkbox" name="newsletter" id="newsletter">
												</td>
											</tr>
										</table>
										<div style="text-align:right">
											<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_valider.gif" />
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
						</td>
					</tr>
				</table>
			</form>
	
			<script type="text/javascript">
				Event.observe("formulaire_nouveau_client", "submit",  function(evt){
					Event.stop(evt);
					check_infos_nouveau_client();
				}, false);
				
			</script>
		</div>
	</div>
	<br />
</div>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
