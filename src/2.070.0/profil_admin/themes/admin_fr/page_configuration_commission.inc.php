<?php

// *************************************************************************************************************
// CONFIG DES DONNEES tarifs
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
tableau_smenu[1] = Array('configuration_commission','configuration_commission.php','true','sub_content', "Commissionnement des commerciaux");
update_menu_arbo();
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_commission_assistant.inc.php" ?>
<div class="emarge">
<p class="titre">Commissionnement des commerciaux</p>

<div class="contactview_corps">

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:17%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	
	<tr>
		<td class="lib_config">Gérer le commissionnement des commerciaux?</td>
		<td>
		<form action="configuration_commission_maj.php" enctype="multipart/form-data" method="POST"  id="form_gestion_comm_commerciaux" name="form_gestion_comm_commerciaux" target="formFrame" >
		<input id="gestion_comm_commerciaux" name="gestion_comm_commerciaux" value="<?php echo  $GESTION_COMM_COMMERCIAUX; ?>" <?php if ($GESTION_COMM_COMMERCIAUX) {?>checked="checked"<?php } ?> type="checkbox" />
		</form>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<?php if ($GESTION_COMM_COMMERCIAUX) {?>
	<tr>
		<td class="titre_config" colspan="3">Grilles de commissionnement des commerciaux</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3">
		<table class="minimizetable">
			<tr>
			<td>
			<div id="liste_comm" >
				<?php 
				if ($liste_commissions_regles) {
				?>
				<table>
					<tr class="smallheight">
						<td>
							<table>
								<tr class="smallheight">
									<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td ><span class="labelled">Libell&eacute;:</span>
									</td>
									<td ><span class="labelled">Commission:</span>
									</td>
									<td >
									</td>
									<td></td>
								</tr>
							</table>
						</td>
						<td style="width:55px">
						</td>
						<td style="width:12px">
						</td>
					</tr>
				</table>
				<?php 
				}
				foreach ($liste_commissions_regles as $commission_regle) {
				?>
				<div class="caract_table" id="tarif_table_<?php echo $commission_regle->id_commission_regle; ?>">
				<table>
					<tr>
						<td>
							<form action="commission_mod.php" method="post" id="commission_mod_<?php echo $commission_regle->id_commission_regle; ?>" name="commission_mod_<?php echo $commission_regle->id_commission_regle; ?>" target="formFrame" >
							<table>
								<tr class="smallheight">
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td>
									<input id="lib_comm_<?php echo $commission_regle->id_commission_regle; ?>" name="lib_comm_<?php echo $commission_regle->id_commission_regle; ?>" type="text" value="<?php echo htmlentities($commission_regle->lib_comm); ?>"  class="classinput_lsize"/>
									<input name="id_commission_regle" id="id_commission_regle" type="hidden" value="<?php echo $commission_regle->id_commission_regle; ?>" />
									</td>
									<td>
									<input id="formule_comm_<?php echo $commission_regle->id_commission_regle; ?>" name="formule_comm_<?php echo $commission_regle->id_commission_regle; ?>" value="<?php echo htmlentities($commission_regle->formule_comm); ?>" type="hidden"  class="classinput_hsize"/>
									<div id="aff_formule_comm_<?php echo $commission_regle->id_commission_regle; ?>" style="cursor:pointer; text-decoration:underline;"><?php echo $commission_regle->formule_comm; ?></div>
									</td>
									<td>
									<?php echo $commission_regle->nb_comm; ?>
									</td>
									<td>
									<div style="text-align:right">
										<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
									</div>
									</td>
								</tr>
							</table>
							</form>
						</td>
						<td style="width:55px; text-align:center">
						<form method="post" action="commission_sup.php" id="commission_sup_<?php echo $commission_regle->id_commission_regle; ?>" name="commission_sup_<?php echo $commission_regle->id_commission_regle; ?>" target="formFrame">
							<input name="id_commission_regle" id="id_commission_regle" type="hidden" value="<?php echo $commission_regle->id_commission_regle; ?>" />
							<input name="id_commission_regle_remplacement_<?php echo $commission_regle->id_commission_regle; ?>" id="id_commission_regle_remplacement_<?php echo $commission_regle->id_commission_regle; ?>" type="hidden" value="" />
							
						</form>
						<a href="#" id="liste_commission_sup_<?php echo $commission_regle->id_commission_regle; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
						<script type="text/javascript">
						Event.observe('liste_commission_sup_<?php echo $commission_regle->id_commission_regle; ?>', 'click',  function(evt){Event.stop(evt); alerte_sup_grille_tarif ('Suppression d\'une commission', 'Confirmez la suppression d\'une commission<br/>S&eacute;lectionnez une grille de commissionnement de remplacement s.v.p.<br /><select id="id_commission_regle_sup" name="id_commission_regle_sup" class="classinput_lsize"><option value=""></option><?php 
											foreach ($liste_commissions_regles as $commission_regle_b) {
												if ($commission_regle->id_commission_regle != $commission_regle_b->id_commission_regle) {
												?><option value="<?php echo $commission_regle_b->id_commission_regle; ?>"><?php echo addslashes(htmlentities($commission_regle_b->lib_comm)); ?></option><?php 
												}
											}
											?></select>', '<input type="submit" name="bouton1" id="bouton1" value="Confirmez la suppression" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />', 'commission_sup_<?php echo $commission_regle->id_commission_regle; ?>', 'id_commission_regle_sup', 'id_commission_regle_remplacement_<?php echo $commission_regle->id_commission_regle; ?>');		},false); 
											
						</script>
						</td>
						<td style="width:12px">&nbsp;
						
						</td>
					</tr>
				</table>
				</div>
				<br />
				<?php
				}
				?>
				<div id="v_add_commission" style="display:none">
				<table>
					<tr class="smallheight">
						<td>
							<table>
								<tr class="smallheight">
									<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td ><span class="labelled">Libell&eacute;:</span>
									</td>
									<td ><span class="labelled">Commission:</span>
									</td>
									<td >
									</td>
									<td>
									</td>
								</tr>
							</table>
						</td>
						<td style="width:55px">
						</td>
						<td style="width:12px">
						</td>
					</tr>
				</table>
				<div class="caract_table">
				<table>
					<tr class="smallheight">
						<td>
							<form action="commission_add.php" method="post" id="commission_add" name="commission_add" target="formFrame" >
							<table>
								<tr class="smallheight">
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td>
									<input name="lib_comm" id="lib_comm" type="text" value=""  class="classinput_lsize"/>
									<input name="ajout_comm" id="ajout_comm" type="hidden" value="1"/>
									</td>
									<td>
										
									<input name="formule_comm" id="formule_comm" value="" type="hidden"  class="classinput_hsize"/>
									<div id="aff_formule_comm" style="cursor:pointer; text-decoration:underline;" class="classinput_lsize">Cr&eacute;er une formule de commissionnement</div>
									</td>
									<td>
									</td>
									<td>
										<div style="text-align:right">
										<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
										</div>
									</td>
			
								</tr>
							</table>
							</form>
						</td>
						<td style="width:55px">
						</td>
						<td style="width:12px">
						</td>
					</tr>
				</table>
				</div>
				</div>
				<span id="add_commission" style="cursor:pointer; text-decoration:underline; display:">Créer une nouvelle grille</span>
			</div>
			</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="font-weight:bolder">Exceptions aux règles de commissionnements / Catégories d'articles</td>
		<td>
		<span style="cursor:pointer; text-decoration:underline" id="comm_consult_art_categ">Consulter</span>
		<script type="text/javascript">
			new Event.observe("comm_consult_art_categ", "click", function(evt){
				Event.stop(evt); 
				page.verify('commission_art_categ','commission_art_categ.php','true','sub_content');
			}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="font-weight:bolder">Exceptions aux règles de commissionnements / Articles</td>
		<td>
		<span style="cursor:pointer; text-decoration:underline" id="comm_consult_article">Consulter</span>
		<script type="text/javascript">
			new Event.observe("comm_consult_article", "click", function(evt){
				Event.stop(evt); 
				page.verify('commission_article','commission_article.php','true','sub_content');
			}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom:1px solid #999999"> </td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Catégories de commerciaux:		</td>
	</tr>
	<tr>
		<td colspan="3">
		<table class="minimizetable">
			<tr>
			<td>
			<div id="cat_commercial">
			<?php 
				if ($liste_categories_commercial) {
				?>
				<table>
					<tr>
						<td>
							<table>
								<tr class="smallheight">
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td>&nbsp;
									</td>
									<td ><span class="labelled">Libell&eacute;:</span>
									</td>
									<td ><span class="labelled">Commissionnement:</span>
									</td>
									<td>&nbsp;
									</td>
									<td>&nbsp;
									</td>
								</tr>
							</table>
						</td>
							<td style="width:55px">&nbsp;
							</td>
							<td style="width:12px">&nbsp;
							</td>
						</tr>
					</table>
				<?php 
				}
				foreach ($liste_categories_commercial as $liste_categorie) {
				?>
				<div class="caract_table" id="categories_commercial_table_<?php echo $liste_categorie->id_commercial_categ; ?>">
				<table>
					<tr>
						<td >
							<form action="annuaire_gestion_categories_commercial_mod.php" method="post" id="annuaire_gestion_categories_commercial_mod_<?php echo $liste_categorie->id_commercial_categ; ?>" name="annuaire_gestion_categories_commercial_mod_<?php echo $liste_categorie->id_commercial_categ; ?>" target="formFrame" >
							<table>
								<tr class="smallheight">
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td style="text-align:center">
									<input name="defaut_commercial_categ_<?php echo $liste_categorie->id_commercial_categ; ?>"  type="checkbox" id="defaut_commercial_categ_<?php echo $liste_categorie->id_commercial_categ; ?>" value="1" <?php if ( $DEFAUT_ID_COMMERCIAL_CATEG == $liste_categorie->id_commercial_categ) { echo 'checked="checked"';} ?> alt="Catégorie par défaut" title="Catégorie par défaut" />
									</td>
									<td>
									<input id="lib_commercial_categ_<?php echo $liste_categorie->id_commercial_categ; ?>" name="lib_commercial_categ_<?php echo $liste_categorie->id_commercial_categ; ?>" type="text" value="<?php echo htmlentities($liste_categorie->lib_commercial_categ); ?>"  class="classinput_lsize"/>
						<input name="id_commercial_categ" id="id_commercial_categ" type="hidden" value="<?php echo $liste_categorie->id_commercial_categ; ?>" />
									</td>
									<td>
									<select name="categ_id_commission_regle_<?php echo $liste_categorie->id_commercial_categ; ?>" id ="categ_id_commission_regle_<?php echo $liste_categorie->id_commercial_categ; ?>" class="classinput_xsize">
									<?php 
									foreach ($liste_commissions_regles as $commission_regle) {
										?>
										<option value="<?php echo $commission_regle->id_commission_regle;?>" <?php if ($commission_regle->id_commission_regle == $liste_categorie->id_commission_regle) {?>selected="selected"<?php } ?>><?php echo $commission_regle->lib_comm;?> <?php echo $commission_regle->formule_comm;?></option>
										<?php
									}
									?>
									</select>
									</td>
									<td>
									</td>
									<td>
									
										<div style="text-align:right">
											<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
										</div>
									</td>
								</tr>
							</table>
							</form>
						</td>
						<td style="width:55px; text-align:center">
						<form method="post" action="annuaire_gestion_categories_commercial_sup.php" id="annuaire_gestion_categories_commercial_sup_<?php echo $liste_categorie->id_commercial_categ; ?>" name="annuaire_gestion_categories_commercial_sup_<?php echo $liste_categorie->id_commercial_categ; ?>" target="formFrame">
						<input name="id_commercial_categ" id="id_commercial_categ" type="hidden" value="<?php echo $liste_categorie->id_commercial_categ; ?>" />
						</form>
						<a href="#" id="link_annuaire_gestion_categories_commercial_sup_<?php echo $liste_categorie->id_commercial_categ; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
						<script type="text/javascript">
						Event.observe("link_annuaire_gestion_categories_commercial_sup_<?php echo $liste_categorie->id_commercial_categ; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('categories_commercial_sup', 'annuaire_gestion_categories_commercial_sup_<?php echo $liste_categorie->id_commercial_categ; ?>');}, false);
						</script>
						</td>
						<td style="width:12px; text-align:center">&nbsp;
						</td>
					</tr>
				</table>
				</div>
				<br />
				<?php
				}
				?>
				
				<div id="v_add_categ" style="display:none">
				<table>
					<tr>
						<td >
								<table>
								<tr class="smallheight">
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td>&nbsp;
									</td>
									<td ><span class="labelled">Libell&eacute;:</span>
									</td>
									<td ><span class="labelled">Commissionnement:</span>
									</td>
									<td>&nbsp;
									</td>
									<td>&nbsp;
									</td>
								</tr>
							</table>
							</td>
							<td style="width:55px">&nbsp;
							</td>
							<td style="width:12px">&nbsp;
							</td>
						</tr>
					</table>
				<div class="caract_table">
				<table>
					<tr>
						<td>
							<form action="annuaire_gestion_categories_commercial_add.php" method="post" id="annuaire_gestion_categories_commercial_add" name="annuaire_gestion_categories_commercial_add" target="formFrame" >
							<table>
								<tr class="smallheight">
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td>&nbsp;
									</td>
									<td>
									<input name="lib_commercial_categ" id="lib_commercial_categ" type="text" value=""  class="classinput_lsize"/>
									</td>
									<td>
									<select name="categ_id_commission_regle" id ="categ_id_commission_regle" class="classinput_xsize">
									<?php 
									foreach ($liste_commissions_regles as $commission_regle) {
										?>
										<option value="<?php echo $commission_regle->id_commission_regle;?>"><?php echo $commission_regle->lib_comm;?> <?php echo $commission_regle->formule_comm;?></option>
										<?php
									}
									?>
									</select>
									</td>
									<td>
									</td>
									<td>
										<div style="text-align:right">
										<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
										</div>
									</td>
								</tr>
							</table>
							</form>
						</td>
						<td style="width:55px">&nbsp;
						</td>
						<td style="width:12px">&nbsp;
						</td>
					</tr>
				</table>
				</div>
				</div>
				<br />
				<span id="add_categ" style="cursor:pointer; text-decoration:underline; display:">Créer une nouvelle catégorie</span>
			</div>
			
			</td>
			</tr>
			</table>
			
			<SCRIPT type="text/javascript">
			new Event.observe("add_categ", "click", function(evt){
				$("add_categ").hide();
				$("v_add_categ").show();
			}, false);

			new Form.EventObserver('annuaire_gestion_categories_commercial_add', function(element, value){formChanged();});
			
			<?php 
			foreach ($liste_categories_commercial as $liste_categorie) {
				?>
					new Form.EventObserver('annuaire_gestion_categories_commercial_mod_<?php echo $liste_categorie->id_commercial_categ; ?>', function(element, value){formChanged();});
				<?php
			}
			?>
			</SCRIPT>
		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom:1px solid #999999"> </td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Liste des commerciaux:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3">
		<table class="minimizetable">
			<tr>
			<td>
			<div id="commerciaux">
			<?php 
			foreach ($liste_commerciaux as $commerciaux) {
				?>
				<div class="caract_table" id="commerciaux_table_<?php echo $commerciaux->ref_contact; ?>">
				<table>
					<tr>
						<td >
							<form action="commission_commercial_mod.php" method="post" id="commission_commercial_mod_<?php echo $commerciaux->ref_contact; ?>" name="commission_commercial_mod_<?php echo $commerciaux->ref_contact; ?>" target="formFrame" >
							<table>
								<tr class="smallheight">
									<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td style="text-align:center">
									<span id="look_<?php echo ($commerciaux->ref_contact)?>" style="cursor:pointer"><?php echo $commerciaux->nom; ?></span>
									
									<script type="text/javascript">
									Event.observe("look_<?php echo ($commerciaux->ref_contact)?>", "click",  function(evt){Event.stop(evt); page.verify('affaires_affiche_fiche','index.php#annuaire_view_fiche.php?ref_contact=<?php echo ($commerciaux->ref_contact)?>','true','_blank');}, false);
									</script>
									</td>
									<td>
									
									<select  id="comm_id_commercial_categ_<?php echo $commerciaux->ref_contact; ?>"  name="comm_id_commercial_categ_<?php echo $commerciaux->ref_contact; ?>" class="classinput_xsize">
									<?php
									foreach ($liste_categories_commercial as $liste_categorie_commercial){
										?>
										<option value="<?php echo $liste_categorie_commercial->id_commercial_categ;?>" <?php if ($commerciaux->id_commercial_categ == $liste_categorie_commercial->id_commercial_categ) {echo 'selected="selected"'; }?>>
										<?php echo htmlentities($liste_categorie_commercial->lib_commercial_categ)?></option>
										<?php 
									}?>
									</select>
									<input name="ref_contact" id="ref_contact" type="hidden" value="<?php echo $commerciaux->ref_contact; ?>" />
									</td>
									<td>
									<select name="comm_id_commission_regle_<?php echo $commerciaux->ref_contact; ?>" id ="comm_id_commission_regle_<?php echo $commerciaux->ref_contact; ?>" class="classinput_xsize">
									<?php 
									foreach ($liste_commissions_regles as $commission_regle) {
										?>
										<option value="<?php echo $commission_regle->id_commission_regle;?>" <?php if ($commission_regle->id_commission_regle == $commerciaux->id_commission_regle) {?>selected="selected"<?php } ?>><?php echo $commission_regle->lib_comm;?> <?php echo $commission_regle->formule_comm;?></option>
										<?php
									}
									?>
									</select>
									</td>
									<td>
									</td>
									<td>
									
										<div style="text-align:right">
											<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
										</div>
									</td>
								</tr>
							</table>
							</form>
						</td>
						<td style="width:55px; text-align:center">
						</td>
						<td style="width:12px; text-align:center">&nbsp;
						</td>
					</tr>
				</table>
				</div>
				<br />
				<?php
				}
				?>
				<div id="add_commercial" style=" cursor:pointer; text-decoration:underline">Ajouter un Commercial</div>
				<script type="text/javascript">
				Event.observe('add_commercial', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ('add_commercial', '\'\'');},false); 
				</script>
			</div>
			</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
</div>
<SCRIPT type="text/javascript">

new Event.observe("gestion_comm_commerciaux", "click", function(evt){
	$("form_gestion_comm_commerciaux").submit();
}, false);


<?php if ($GESTION_COMM_COMMERCIAUX) {?>
new Event.observe("add_commission", "click", function(evt){
	$("add_commission").hide();
	$("v_add_commission").show();
}, false);


new Form.EventObserver('commission_add', function(element, value){formChanged();});

Event.observe('aff_formule_comm', "click", function(evt){Event.stop(evt);  $('pop_up_assistant_comm_commission').style.display='block'; $('pop_up_assistant_comm_commission_iframe').style.display='block'; $('assistant_comm_cellule').value='';
 if ($("formule_comm").value != "") {edition_formule_commission ("formule_comm");} });

<?php 
	foreach ($liste_commissions_regles as $commission_regle) {
?>
Event.observe('aff_formule_comm_<?php echo $commission_regle->id_commission_regle; ?>', "click", function(evt){Event.stop(evt);  $('pop_up_assistant_comm_commission').style.display='block'; $('pop_up_assistant_comm_commission_iframe').style.display='block'; $('assistant_comm_cellule').value='_<?php echo $commission_regle->id_commission_regle; ?>'; edition_formule_commission ("formule_comm_<?php echo $commission_regle->id_commission_regle; ?>"); });

new Form.EventObserver('commission_mod_<?php echo $commission_regle->id_commission_regle; ?>', function(element, value){formChanged();});

<?php
	}
?>
//centrage de l'assistant commission

centrage_element("pop_up_assistant_comm_commission");
centrage_element("pop_up_assistant_comm_commission_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_comm_commission_iframe");
centrage_element("pop_up_assistant_comm_commission");
});
<?php
	}
?>
//centrage du mini_moteur de recherche d'un contact

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});

//on masque le chargement
H_loading();
</SCRIPT>