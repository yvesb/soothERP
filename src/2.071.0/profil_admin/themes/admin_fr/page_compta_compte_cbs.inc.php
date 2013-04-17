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
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('compte_cbs','compta_compte_cbs.php','true','sub_content', "Gestion des cartes bancaires de la soci&eacute;t&eacute;");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des cartes bancaires de la soci&eacute;t&eacute;</p>
<div style="height:50px">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">
<p>Ajouter une carte bancaire </p>


	<div class="caract_table">

	<table>
	<tr>
		<td style="width:95%">
			<form action="compta_compte_cbs_add.php" method="post" id="compta_compte_cbs_add" name="compta_compte_cbs_add" target="formFrame" >
			<table>
				<tr class="smallheight">
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td style="text-align:right">Nom de la Banque: 
					</td>
					<td>
						<select id="id_compte_bancaire" name="id_compte_bancaire"  class="classinput_xsize" >
						<?php 
						foreach ($comptes_bancaires as $compte_bancaire) {
							?>
							<option value="<?php echo $compte_bancaire->id_compte_bancaire; ?>"><?php echo htmlentities($compte_bancaire->lib_compte); ?></option>
							<?php 
						}
						?>
						</select>
					</td>
					<td style="text-align:right">Porteur: 
					</td>
					<td>
					<input name="ref_porteur" id="ref_porteur" type="hidden" value="" />
					<table cellpadding="0" cellspacing="0" border="0" style=" width:100%">
						<tr>
							<td>
							<input name="nom_porteur" id="nom_porteur" type="text" value=""  class="classinput_xsize" readonly=""/>
							</td>
							<td style="width:20px">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_porteur_select_img">
							</td>
						</tr>
					</table>
					
				<script type="text/javascript">
		//effet de survol sur le faux select
			Event.observe('ref_porteur_select_img', 'mouseover',  function(){$("ref_porteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_porteur_select_img', 'mousedown',  function(){$("ref_porteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_porteur_select_img', 'mouseup',  function(){$("ref_porteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_porteur_select_img', 'mouseout',  function(){$("ref_porteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_porteur_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_compte_b_set_contact", "\'ref_porteur\', \'nom_porteur\' "); preselect ('<?php echo $COLLAB_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
				</script>
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td style="text-align:right">
					</td>
					<td colspan="3">
					<table style="width:100%" >
						<tr>
							<td style="width:25%; text-align:center"><span>Type de carte:</span><br />
							<select name="id_cb_type" id="id_cb_type" class="classinput_nsize" >
							<?php 
							foreach ($types_cbs as $type_cb) {
								?>
								<option value="<?php echo $type_cb->id_cb_type; ?>"><?php echo htmlentities($type_cb->lib_cb_type); ?></option>
								<?php 
							}
							?>
							</select>
							</td>
							<td style="width:25%; text-align:center"><span>Num&eacute;ro de carte:</span><br />
							<input name="numero_carte" id="numero_carte" type="text" value=""  class="classinput_nsize"/>
							</td>
							<td style="width:25%; text-align:center"><span>Expiration (mm-aa):</span><br />
							<input name="date_expiration" id="date_expiration" type="text" value="mm-aa"  class="classinput_nsize" maxlength="5"/>
							</td>
							<td style="width:25%; text-align:center"><span style="display:none">Contr&ocirc;le</span><br />
							<input name="controle" id="controle" type="text" value="" style="display:none" class="classinput_nsize"/>
							</td>
							<td style="width:25%; text-align:center"><span>Diff&eacute;r&eacute;</span><br />
							<select name="differe" id="differe" class="classinput_nsize" >
							<?php 
							for ($i = 0; $i <= 31; $i++) {
								?>
								<option value="<?php echo $i; ?>"><?php echo htmlentities($i); ?></option>
								<?php
							}
							?>
							</select>
							</td>
						</tr>
					</table>
					</td>
					<td style="text-align:center">
					<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
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
<?php 
if ($comptes_cbs) {
	?>
	<p>Cartes bancaires </p>
	<?php
	
	$fleches_ascenseur=0;
	foreach ($comptes_cbs as $compte_cb) {
		?>
		<div class="caract_table">
			<table>
			<tr>
				<td style="width:95%">
					<form action="compta_compte_cbs_mod.php" method="post" id="compta_compte_cbs_mod_<?php echo $compte_cb->id_compte_cb;?>" name="compta_compte_cbs_mod_<?php echo $compte_cb->id_compte_cb;?>" target="formFrame" >
					<table>
						<tr class="smallheight">
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>	
						<tr>
							<td style="text-align:right">Banque: 
							</td>
							<td>
						<select id="id_compte_bancaire_<?php echo $compte_cb->id_compte_cb;?>" name="id_compte_bancaire_<?php echo $compte_cb->id_compte_cb;?>"  class="classinput_xsize" >
						<?php 
						foreach ($comptes_bancaires as $compte_bancaire) {
							?>
							<option value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" <?php if ($compte_bancaire->id_compte_bancaire == $compte_cb->id_compte_bancaire) {echo 'selected="selected"';}?>><?php echo htmlentities($compte_bancaire->lib_compte); ?></option>
							<?php 
						}
						?>
						</select>
							</td>
							<td style="text-align:right">Nom du porteur: 
							</td>
							<td>
							<input name="ref_porteur_<?php echo $compte_cb->id_compte_cb;?>" id="ref_porteur_<?php echo $compte_cb->id_compte_cb;?>" type="hidden" value="<?php echo htmlentities($compte_cb->ref_porteur);?>" />
							<input name="id_compte_cb" id="id_compte_cb" type="hidden" value="<?php echo $compte_cb->id_compte_cb;?>" />
							<table>
								<tr>
									<td>
									<input name="nom_porteur_<?php echo $compte_cb->id_compte_cb;?>" id="nom_porteur_<?php echo $compte_cb->id_compte_cb;?>" type="text" value="<?php echo htmlentities($compte_cb->nom_porteur);?>"  class="classinput_xsize" readonly=""/>
									</td>
									<td style="width:20px">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>">
									</td>
								</tr>
							</table>
							
						<script type="text/javascript">
				//effet de survol sur le faux select
					Event.observe('ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>', 'mouseover',  function(){$("ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
					Event.observe('ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>', 'mousedown',  function(){$("ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
					Event.observe('ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>', 'mouseup',  function(){$("ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
					
					Event.observe('ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>', 'mouseout',  function(){$("ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
					Event.observe('ref_porteur_select_img_<?php echo $compte_cb->id_compte_cb;?>', 'click',  function(evt){Event.stop(evt);  show_mini_moteur_contacts ("recherche_compte_b_set_contact", "\'ref_porteur_<?php echo $compte_cb->id_compte_cb;?>\', \'nom_porteur_<?php echo $compte_cb->id_compte_cb;?>\' "); preselect ('<?php echo $COLLAB_ID_PROFIL; ?>', 'id_profil_m');}, false);
						</script>
							</td>
							<td style="text-align:center">Actif: 
							<input type="checkbox" id="actif_<?php echo $compte_cb->id_compte_cb;?>" name="actif_<?php echo $compte_cb->id_compte_cb;?>" value="1" <?php if ($compte_cb->actif) {echo 'checked="checked"';};?>/>
							</td>
						</tr>
						<tr>
							<td style="text-align:right">Rib:
							</td>
							<td colspan="3">
							<table style="width:100%" >
						<tr>
							<td style="width:25%; text-align:center"><span>Type de carte:</span><br />
							<select name="id_cb_type_<?php echo $compte_cb->id_compte_cb;?>" id="id_cb_type_<?php echo $compte_cb->id_compte_cb;?>" class="classinput_nsize" >
							<?php 
							foreach ($types_cbs as $type_cb) {
								?>
								<option value="<?php echo $type_cb->id_cb_type; ?>" <?php if ($type_cb->id_cb_type == $compte_cb->id_cb_type) {echo 'selected="selected"';}?>><?php echo htmlentities($type_cb->lib_cb_type); ?></option>
								<?php 
							}
							?>
							</select>
							</td>
							<td style="width:25%; text-align:center"><span>Num&eacute;ro de carte:</span><br />
							<input name="numero_carte_<?php echo $compte_cb->id_compte_cb;?>" id="numero_carte_<?php echo $compte_cb->id_compte_cb;?>" type="text" value="<?php echo htmlentities($compte_cb->numero_carte);?>"  class="classinput_nsize"/>
							</td>
							<td style="width:25%; text-align:center"><span>Expiration (mm-aa):</span><br />
							<input name="date_expiration_<?php echo $compte_cb->id_compte_cb;?>" id="date_expiration_<?php echo $compte_cb->id_compte_cb;?>" type="text" value="<?php echo (date("m", strtotime($compte_cb->date_expiration)));?>-<?php echo (date("y", strtotime($compte_cb->date_expiration)));?>"  class="classinput_nsize" maxlength="5"/>
							</td>
							<td style="width:25%; text-align:center"><span style="display:none">Contr&ocirc;le</span><br />
							<input name="controle_<?php echo $compte_cb->id_compte_cb;?>" id="controle_<?php echo $compte_cb->id_compte_cb;?>" type="text" value="<?php echo htmlentities($compte_cb->controle);?>" class="classinput_nsize" style="display:none"/>
							</td>
							<td style="width:25%; text-align:center"><span>Diff&eacute;r&eacute;</span><br />
							<select name="differe_<?php echo $compte_cb->id_compte_cb;?>" id="differe_<?php echo $compte_cb->id_compte_cb;?>" class="classinput_nsize" >
							<?php 
							for ($i = 0; $i <= 31; $i++) {
								?>
								<option value="<?php echo $i; ?>" <?php if ($i == $compte_cb->differe) {echo 'selected="selected"';}?>><?php echo htmlentities($i); ?></option>
								<?php
							}
							?>
							</select>
							</td>
						</tr>
					</table>
							</td>
							<td style="text-align:center">
					<input name="modifier_<?php echo $compte_cb->id_compte_cb;?>" id="modifier_<?php echo $compte_cb->id_compte_cb;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</td>
						</tr>
	
					</table>
					</form>
				</td>
				<td style="width:55px; text-align:center">
				<form method="post" action="compta_compte_cbs_sup.php" id="compta_compte_cbs_sup_<?php echo $compte_cb->id_compte_cb; ?>" name="compta_compte_cbs_sup_<?php echo $compte_cb->id_compte_cb; ?>" target="formFrame">
					<input name="id_compte_cb" id="id_compte_cbs" type="hidden" value="<?php echo $compte_cb->id_compte_cb; ?>" />
				</form>
				<a href="#" id="link_compta_compte_cbs_sup_<?php echo $compte_cb->id_compte_cb; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_compta_compte_cbs_sup_<?php echo $compte_cb->id_compte_cb; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_compte_cbs_sup', 'compta_compte_cbs_sup_<?php echo $compte_cb->id_compte_cb; ?>');}, false);
				</script>
				<table cellspacing="0">
					<tr>
						<td>
							<div id="up_arrow_<?php echo $compte_cb->id_compte_cb; ?>">
							<?php
							if ($fleches_ascenseur!=0) {
							?>
							<form action="compta_compte_cbs_ordre.php" method="post" id="compta_compte_cbs_ordre_<?php echo $compte_cb->id_compte_cb; ?>" name="compta_compte_cbs_ordre_<?php echo $compte_cb->id_compte_cb; ?>" target="formFrame">
								<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_cb->ordre)-1?>" />
								<input name="id_compte_cb" id="id_compte_cb" type="hidden" value="<?php echo $compte_cb->id_compte_cb; ?>" />	
								<input name="modifier_ordre_<?php echo $compte_cb->id_compte_cb; ?>" id="modifier_ordre_<?php echo $compte_cb->id_compte_cb; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
							</form>
							<?php
							} else {
							?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
							<?php
							}
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<div id="down_arrow_<?php echo $compte_cb->id_compte_cb; ?>">
							<?php
							if ($fleches_ascenseur!=count($comptes_cbs)-1) {
							?>
						<form action="compta_compte_cbs_ordre.php" method="post" id="compta_compte_cbs_ordre_<?php echo $compte_cb->id_compte_cb; ?>" name="compta_compte_cbs_ordre_<?php echo $compte_cb->id_compte_cb; ?>" target="formFrame">
								<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_cb->ordre)+1?>" />
								<input name="id_compte_cb" id="id_compte_cb" type="hidden" value="<?php echo $compte_cb->id_compte_cb; ?>" />
								<input name="modifier_ordre_<?php echo $compte_cb->id_compte_cb; ?>" id="modifier_ordre_<?php echo $compte_cb->id_compte_cb; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
							</form>
							<?php
							} else {
							?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>							
							<?php
							}
							?>
							</div>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
		<?php 
		$fleches_ascenseur++;
		}
	?>
	<?php 
	}
?>

</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('compta_compte_cbs_add', function(){formChanged();});
new Event.observe("date_expiration", "blur", expdatemask, false);


	<?php
	foreach ($comptes_cbs as $compte_cb) {
		?>
		new Form.EventObserver('compta_compte_cbs_mod_<?php echo $compte_cb->id_compte_cb;?>', function(){formChanged();});
		
		new Event.observe("date_expiration_<?php echo $compte_cb->id_compte_cb;?>", "blur", expdatemask, false);
		
		Event.observe($("actif_<?php echo $compte_cb->id_compte_cb;?>"), "click", function(evt){
			if ($("actif_<?php echo $compte_cb->id_compte_cb;?>").checked) {
				set_active_compte_cb("<?php echo $compte_cb->id_compte_cb;?>");
			} else {
				set_desactive_compte_cb("<?php echo $compte_cb->id_compte_cb;?>");
			}
		});
	
		
		<?php 
		}
	?>
	
//centrage du mini_moteur

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});

		return_to_page = "compte_cbs=1";


//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>