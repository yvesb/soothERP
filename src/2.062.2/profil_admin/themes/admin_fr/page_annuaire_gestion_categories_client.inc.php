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
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('annuaire_gestion_categ_client','annuaire_gestion_categories_client.php',"true" ,"sub_content", "Gestion des catégories de Clients");
update_menu_arbo();
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div class="emarge">

<p class="titre">Gestion des catégories de Clients</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">

	
	<p>Ajouter une cat&eacute;gorie </p>
	
		<table>
		<tr>
			<td style="width:95%">
					<table>
					<tr class="smallheight">
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled" style="text-align:center">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled" style="text-align:center">Grille tarifaire:</span>
						</td>
						<td ><span class="labelled" style="text-align:center">Facturation p&eacute;riodique:</span>
						</td>
						<td ><span class="labelled" style="text-align:center">D&eacute;lai de r&egrave;glement des factures:</span>
						</td>
						<td ><span class="labelled" style="text-align:center">Commercial:</span>
						</td>
						<td><span class="labelled" style="text-align:center">Note:</span>
						</td>

					</tr>
				</table>
				</td>
				<td>
				</td>
			</tr>
		</table>
	<div class="caract_table">

		<table>
		<tr>
			<td style="width:95%">
				<form action="annuaire_gestion_categories_client_add.php" method="post" id="annuaire_gestion_categories_client_add" name="annuaire_gestion_categories_client_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:19%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_client_categ" id="lib_client_categ" type="text" value=""  class="classinput_lsize"/>
						</td>
						<td>
							<select id="id_tarif" name="id_tarif" class="classinput_lsize">
								<option value="">Selon point de vente</option>
								<?php 
								foreach ($tarifs_liste as $tarif_liste) {
									?>
									<option value="<?php echo $tarif_liste->id_tarif; ?>"><?php echo htmlentities($tarif_liste->lib_tarif); ?>
									</option>
									<?php 
								}
								?>
							</select>
							<br />
							<br />
							Encours<br/>par défaut:<br />
							<input name="defaut_encours" 
							id="defaut_encours"
							type="text" value="0"  class="classinput_nsize" size="4"/><?php echo $MONNAIE[1];?>
						</td>
						<td>
							<select id="facturation_periodique" name="facturation_periodique" class="classinput_lsize">
							<?php 
							 foreach ($FACTURES_PAR_MOIS as $key=>$valeur) {
								?>
								<option value="<?php echo $key;?>"><?php echo $valeur;?></option>
								<?php
								}
							?>
							</select>
							<br />
							<br />
							Prépaiement commande :<br/>
							<select name="prepaiement_type" id="prepaiement_type"><option value="Acompte" >Acompte</option><option value="Arrhes">Arrhes</option></select>
							<br/>
							Pourcentage:
							<br/>
							<input id="prepaiement_ratio" name="prepaiement_ratio" type="text" value="" class="classinput_nsize" size="4"/> %
						</td>
						<td>
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
						<input name="delai_reglement" id="delai_reglement" type="text" value=""  class="classinput_nsize" size="4"/>
								jour(s)
								
								<br/>
								 <input id="delai_reglement_fdm" name="delai_reglement_fdm" type="checkbox" />Fin de mois
								 <br/><br/>
								 Mode de règlement favori<br/>
								 <select id="reglement_mode_favori" name="reglement_mode_favori">
								 <option value="0" >Non Défini</option>
								 <?php 
								 foreach ($reglements_modes as $reglement_mode){
								 	?>
								 	<option value="<?php echo $reglement_mode->id_reglement_mode; ?>" ><?php echo $reglement_mode->lib_reglement_mode; ?></option>
								 	<?php 
								 }
								 ?>
								 </select>
								 <br/><br/>
								 Cycle de relance par défaut<br/>
								 <select id="cycle_relance" name="cycle_relance">
                                                                 <?php 
								 foreach ($cycles_relances as $cycle_relance){
								 	?>
								 	<option value="<?php echo $cycle_relance->id_relance_modele; ?>" ><?php echo $cycle_relance->lib_relance_modele; ?></option>
								 	<?php 
								 }
								 ?>
								 </select>
								</td>
							</tr>
						</table>
						</td>
						<td>
														
						<input name="ref_commercial" id="ref_commercial" type="hidden" value="" />
							<table cellpadding="0" cellspacing="0" border="0" style=" width:100%">
								<tr>
									<td>
									<input name="nom_commercial" id="nom_commercial" type="text" value=""  class="classinput_xsize" readonly=""/>
									<br/><br/><br/>
									 Mode d'édition favori<br/>
									 <select id="edition_mode_favori" name="edition_mode_favori">
									 <option value="0" >Non Défini</option>
									 <?php 
									 foreach ($editions_modes as $edition_mode){
									 	?>
									 	<option value="<?php echo $edition_mode->id_edition_mode; ?>" ><?php echo $edition_mode->lib_edition_mode; ?></option>
									 	<?php 
									 }
									 ?>
									 </select>
									</td>
									<td style="width:20px">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_commercial_select_img">
									</td>
									<td style="width:20px">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_commercial_empty_s">
									
									<script type="text/javascript">
									Event.observe('ref_commercial_empty_s', 'click',  function(evt){Event.stop(evt); 
									$("ref_commercial").value = "";
									$("nom_commercial").value = "";
									}, false);
									</script>
									</td>
								</tr>
							</table>
							
						<script type="text/javascript">
						//effet de survol sur le faux select
							Event.observe('ref_commercial_select_img', 'mouseover',  function(){
							$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";
							}, false);
							Event.observe('ref_commercial_select_img', 'mousedown',  function(){
							$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";
							}, false);
							Event.observe('ref_commercial_select_img', 'mouseup',  function(){
							$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";
							}, false);
							
							Event.observe('ref_commercial_select_img', 'mouseout',  function(){
							$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";
							}, false);
							
							Event.observe('ref_commercial_select_img', 'click',  function(evt){
							Event.stop(evt); 
							show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_commercial\', \'nom_commercial\' "); 
							preselect ('<?php echo $COMMERCIAL_ID_PROFIL; ?>', 'id_profil_m'); 
							page.annuaire_recherche_mini();
							}, false);
						</script>
						

							
						</td>
						<td>
						<textarea name="note" id="note" class="classinput_xsize"></textarea>
							<p style="text-align: right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	if ($liste_categories) {
	?>
	<p>Liste des cat&eacute;gories </p>

		<table>
		<tr>
			<td style="width:95%">
					<table>
					<tr class="smallheight">
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Grille tarifaire:</span>
						</td>
						<td ><span class="labelled">Facturation p&eacute;riodique:</span>
						</td>
						<td ><span class="labelled">D&eacute;lai de r&egrave;glement des factures:</span>
						</td>
						<td ><span class="labelled">Commercial:</span>
						</td>
						<td><span class="labelled">Note:</span>
						</td>

					</tr>
				</table>
			</td>
			<td>
			</td>
			</tr>
		</table>
	<?php 
	}
	//_vardump($liste_categories);
	foreach ($liste_categories as $liste_categorie) {
	?>
	<div class="caract_table" id="categories_client_table_<?php echo $liste_categorie->id_client_categ; ?>">

		<table>
		<tr>
			<td style="width:95%">
				<form action="annuaire_gestion_categories_client_mod.php" method="post" id="annuaire_gestion_categories_client_mod_<?php echo $liste_categorie->id_client_categ; ?>" name="annuaire_gestion_categories_client_mod_<?php echo $liste_categorie->id_client_categ; ?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td style="text-align:center">
						<input name="defaut_client_categ_<?php echo $liste_categorie->id_client_categ; ?>"  type="checkbox" id="defaut_client_categ_<?php echo $liste_categorie->id_client_categ; ?>" value="1" <?php if ( $DEFAUT_ID_CLIENT_CATEG == $liste_categorie->id_client_categ) { echo 'checked="checked"';} ?> alt="Catégorie par défaut" title="Catégorie par défaut" />
							
						</td>
						<td>
						<input id="lib_client_categ_<?php echo $liste_categorie->id_client_categ; ?>" name="lib_client_categ_<?php echo $liste_categorie->id_client_categ; ?>" type="text" value="<?php echo htmlentities($liste_categorie->lib_client_categ); ?>"  class="classinput_lsize"/>
			<input name="id_client_categ" id="id_client_categ" type="hidden" value="<?php echo $liste_categorie->id_client_categ; ?>" />
						</td>
						<td>
							<select id="id_tarif_<?php echo $liste_categorie->id_client_categ; ?>" name="id_tarif_<?php echo $liste_categorie->id_client_categ; ?>" class="classinput_lsize">
								<option value="">Selon point de vente</option>
							<?php 
							foreach ($tarifs_liste as $tarif_liste) {
								?>
								<option value="<?php echo $tarif_liste->id_tarif; ?>" <?php if ($tarif_liste->id_tarif==$liste_categorie->id_tarif){echo 'selected="selected"';}?>><?php echo htmlentities($tarif_liste->lib_tarif); ?>
								</option>
								<?php 
							}
							?>
							</select>
							<br />
							<br />
							Encours<br/>par défaut:<br />
							<input name="defaut_encours_<?php echo $liste_categorie->id_client_categ; ?>" 
							id="defaut_encours_<?php echo $liste_categorie->id_client_categ; ?>"
							type="text" value="<?php echo $liste_categorie->defaut_encours; ?>"  class="classinput_nsize" size="4"/><?php echo $MONNAIE[1];?>
						</td>
						<td>
							<select id="facturation_periodique_<?php echo $liste_categorie->id_client_categ; ?>" name="facturation_periodique_<?php echo $liste_categorie->id_client_categ; ?>" class="classinput_lsize">
							 <?php 
							 foreach ($FACTURES_PAR_MOIS as $key=>$valeur) {
								?>
								<option value="<?php echo $key;?>" <?php if ($liste_categorie->facturation_periodique == $key) {echo 'selected="selected"';}?>><?php echo $valeur;?></option>
								<?php
								}
							?>
							</select>
							<br />
							<br />
							Prépaiement commande :<br/>
							<select name="prepaiement_type_<?php echo $liste_categorie->id_client_categ; ?>" id="prepaiement_type_<?php echo $liste_categorie->id_client_categ; ?>"><option value="Acompte" <?php if ($liste_categorie->prepaiement_type == 'Acompte'){ echo "selected='selected'";}?>>Acompte</option><option value="Arrhes" <?php if ($liste_categorie->prepaiement_type == 'Arrhes'){ echo "selected='selected'";}?>>Arrhes</option></select>
							<br/>
							Pourcentage:
							<br/>
							<input id="prepaiement_ratio_<?php echo $liste_categorie->id_client_categ; ?>" name="prepaiement_ratio_<?php echo $liste_categorie->id_client_categ; ?>" type="text" value="<?php echo $liste_categorie->prepaiement_ratio?>" class="classinput_nsize" size="4"/> %

						</td>
						<td>
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
								<input name="delai_reglement_<?php echo $liste_categorie->id_client_categ; ?>" id="delai_reglement_<?php echo $liste_categorie->id_client_categ; ?>" type="text" value="<?php echo strpos($liste_categorie->delai_reglement,'FDM') === false ? htmlentities($liste_categorie->delai_reglement) : htmlentities(substr($liste_categorie->delai_reglement,0,strpos($liste_categorie->delai_reglement,'FDM'))); ?>"  class="classinput_nsize" size="4"/>
								 jour(s)
								 <br/>
								 <input id="delai_reglement_fdm_<?php echo $liste_categorie->id_client_categ; ?>" name="delai_reglement_fdm_<?php echo $liste_categorie->id_client_categ; ?>" type="checkbox" <?php echo strpos($liste_categorie->delai_reglement,'FDM') === false ? "" : "CHECKED"; ?>>Fin de mois</input>
								 <br/><br/>
								 Mode de règlement favori<br/>
								 <select id="reglement_mode_favori_<?php echo $liste_categorie->id_client_categ; ?>" name="reglement_mode_favori_<?php echo $liste_categorie->id_client_categ; ?>">
								 <option value="0" <?php echo ($liste_categorie->id_reglement_mode_favori == "" || $liste_categorie->id_reglement_mode_favori == 0) ? "selected='selected'" : ""  ?>>Non Défini</option>
								 <?php 
								 foreach ($reglements_modes as $reglement_mode){
								 	?>
								 	<option value="<?php echo $reglement_mode->id_reglement_mode; ?>" <?php echo $liste_categorie->id_reglement_mode_favori == $reglement_mode->id_reglement_mode ? "selected='selected'" : ""  ?>><?php echo $reglement_mode->lib_reglement_mode; ?></option>
								 	<?php 
								 }
								 ?>
								 </select>
								 <br/><br/>
								 Cycle de relance par défaut<br/>
								 <select id="cycle_relance_<?php echo $liste_categorie->id_client_categ; ?>" name="cycle_relance_<?php echo $liste_categorie->id_client_categ; ?>">
                                                                 <?php 
								 foreach ($cycles_relances as $cycle_relance){
								 	?>
								 	<option value="<?php echo $cycle_relance->id_relance_modele; ?>" <?php echo $liste_categorie->id_relance_modele == $cycle_relance->id_relance_modele ? "selected='selected'" : ""  ?>><?php echo $cycle_relance->lib_relance_modele; ?></option>
								 	<?php 
								 }
								 ?>
								 </select>
								</td>
							</tr>
						</table>
						</td>
						<td>
								
						<input name="ref_commercial_<?php echo $liste_categorie->id_client_categ; ?>" id="ref_commercial_<?php echo $liste_categorie->id_client_categ; ?>" type="hidden" value="<?php echo ($liste_categorie->ref_commercial); ?>" />
							<table cellpadding="0" cellspacing="0" border="0" style=" width:100%">
								<tr>
									<td>
									<input name="nom_commercial_<?php echo $liste_categorie->id_client_categ; ?>" id="nom_commercial_<?php echo $liste_categorie->id_client_categ; ?>" type="text" value="<?php echo ($liste_categorie->nom_commercial); ?>"  class="classinput_xsize" readonly=""/>
								<br/><br/><br/>
								 Mode d'édition favori<br/>
								 <select id="edition_mode_favori_<?php echo $liste_categorie->id_client_categ; ?>" name="edition_mode_favori_<?php echo $liste_categorie->id_client_categ; ?>">
								 <option value="0" <?php echo $liste_categorie->id_edition_mode_favori == "" ? "selected='selected'" : ""  ?>>Non Défini</option>
								 <?php 
								 foreach ($editions_modes as $edition_mode){
								 	?>
								 	<option value="<?php echo $edition_mode->id_edition_mode; ?>" <?php echo $liste_categorie->id_edition_mode_favori == $edition_mode->id_edition_mode ? "selected='selected'" : ""  ?>><?php echo $edition_mode->lib_edition_mode; ?></option>
								 	<?php 
								 }
								 ?>
								 </select>
								 	</td>
									<td style="width:20px">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>">
									</td>
									<td style="width:20px">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_commercial_empty_s_<?php echo $liste_categorie->id_client_categ; ?>">
									
									<script type="text/javascript">
									Event.observe('ref_commercial_empty_s_<?php echo $liste_categorie->id_client_categ; ?>', 'click',  function(evt){Event.stop(evt); 
									$("ref_commercial_<?php echo $liste_categorie->id_client_categ; ?>").value = "";
									$("nom_commercial_<?php echo $liste_categorie->id_client_categ; ?>").value = "";
									}, false);
									</script>
							</td>
								</tr>
							</table>
							
						<script type="text/javascript">
						//effet de survol sur le faux select
							Event.observe('ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>', 'mouseover',  function(){
							$("ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";
							}, false);
							Event.observe('ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>', 'mousedown',  function(){
							$("ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";
							}, false);
							Event.observe('ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>', 'mouseup',  function(){
							$("ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";
							}, false);
							
							Event.observe('ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>', 'mouseout',  function(){
							$("ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";
							}, false);
							
							Event.observe('ref_commercial_select_img_<?php echo $liste_categorie->id_client_categ; ?>', 'click',  function(evt){
							Event.stop(evt); 
							show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_commercial_<?php echo $liste_categorie->id_client_categ; ?>\', \'nom_commercial_<?php echo $liste_categorie->id_client_categ; ?>\' "); 
							preselect ('<?php echo $COMMERCIAL_ID_PROFIL; ?>', 'id_profil_m'); 
							page.annuaire_recherche_mini();
							}, false);
						</script>
						
				
						<br />

						</td>
						<td>
						<textarea id="note_<?php echo $liste_categorie->id_client_categ; ?>" name="note_<?php echo $liste_categorie->id_client_categ; ?>" class="classinput_xsize"><?php echo htmlentities($liste_categorie->note); ?></textarea>
							<p style="text-align: right">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td style=" text-align:right">
			<form method="post" action="annuaire_gestion_categories_client_sup.php" id="annuaire_gestion_categories_client_sup_<?php echo $liste_categorie->id_client_categ; ?>" name="annuaire_gestion_categories_client_sup_<?php echo $liste_categorie->id_client_categ; ?>" target="formFrame">
			<input name="id_client_categ" id="id_client_categ" type="hidden" value="<?php echo $liste_categorie->id_client_categ; ?>" />
		</form>
		<a href="#" id="link_annuaire_gestion_categories_client_sup_<?php echo $liste_categorie->id_client_categ; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe("link_annuaire_gestion_categories_client_sup_<?php echo $liste_categorie->id_client_categ; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('categories_client_sup', 'annuaire_gestion_categories_client_sup_<?php echo $liste_categorie->id_client_categ; ?>');}, false);
		</script>
			</td>
		</tr>
	</table>
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
new Form.EventObserver('annuaire_gestion_categories_client_add', function(element, value){formChanged();});
Event.observe("delai_reglement", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
<?php 
foreach ($liste_categories as $liste_categorie) {
	?>
	new Form.EventObserver('annuaire_gestion_categories_client_mod_<?php echo $liste_categorie->id_client_categ; ?>', function(){formChanged();});
	
	Event.observe("delai_reglement_<?php echo $liste_categorie->id_client_categ; ?>", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
	

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
</div>
</div>