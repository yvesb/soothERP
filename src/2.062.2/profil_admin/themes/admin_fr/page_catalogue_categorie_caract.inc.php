<div style="padding-left:10px; padding-right:10px; height:100%">
	<p><a href="catalogue_categorie_preview_caract.php?ref_art_categs=<?php echo $art_categ->getRef_art_categ(); ?>" target="preview_caracts" style="float:right; margin-right:30px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/preview.gif" width="65" height="18" /></a><br />
<span  class="bolder">Ajouter une caract&eacute;ristique</span> <br />

	<div class="caract_table">
	<table>
	<tr class="smallheight">
	<td>
	<form action="catalogue_categorie_caract_add.php" method="post" id="catalogue_categorie_add_caract" name="catalogue_categorie_add_caract" target="formFrame" >
	<table>
		<tr class="smallheight">
			<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>	
		<tr>
			<td><span class="labelled_nowidth">Libell&eacute;: 
				<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
			</span></td>
			<td><span class="labelled_nowidth">Unit&eacute;:</span></td>
			<td><span class="labelled_nowidth">Crit&egrave;re de recherche: </span></td>
			<td><span class="labelled_nowidth">Affichage:</span></td>
			</tr>	
		<tr>
			<td><input name="lib_carac" id="lib_carac" value=""  class="classinput_xsize"/></td>
			<td><input name="unite" id="unite" type="text" class="classinput_xsize" /></td>
			<td><select name="moteur_recherche" id="moteur_recherche"  class="classinput_xsize">
					<option value="0">Non</option>
					<option value="1">Simple</option>
					<option value="2">Avanc&eacute;</option>
				</select></td>
			<td><select name="affichage" id="affichage"  class="classinput_xsize">
				<option value="1">Normal</option>
				<option value="2" selected="selected">Prioritaire</option>
			</select></td>
			</tr>
		<tr>
			<td><span class="labelled_nowidth">Valeur(s) par d&eacute;faut: </span></td>
			<td><span class="labelled_nowidth">Valeurs autoris&eacute;es:</span></td>
			<td><span class="labelled_nowidth">Groupe:</span></td>
			<td><span class="labelled_nowidth">Variante:</span></td>
			</tr>
		<tr>
			<td><input name="default_value" id="default_value" type="text" value="" class="classinput_xsize" /></td>
			<td><input name="allowed_values" type="text" class="classinput_xsize" id="allowed_values" value="" /></td>
			<td><select name="ref_carac_groupe" id="ref_carac_groupe"  class="classinput_xsize">
				<option value="">Aucun</option>
				<?php 
	$exist_carac_groupes	=	$art_categ-> getCarac_groupes ();
	foreach ($exist_carac_groupes as $exist_carac_groupe) {
	?>
				<option value="<?php echo $exist_carac_groupe->ref_carac_groupe; ?>"><?php echo htmlentities($exist_carac_groupe->lib_carac_groupe)?></option>
				<?php

	}
	?>
			</select></td>
			<td>
				<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="float:right"/>
				<input type="checkbox" name="variante" id="variante_0" value="1" />			</td>
			</tr>
</table>
<script type="text/javascript">
	
Event.observe($("variante_0"), "click", function(evt){
	if ($("variante_0").checked) {
		$("allowed_values").value = "";
		$("allowed_values").disabled = "disabled";
		$("allowed_values").className="classinput_xsize_disabled";
	} else {
		$("allowed_values").disabled = "";
		$("allowed_values").className="classinput_xsize";
	}
});
</script>

		</form>
	</td>
	<td style="width:0px
	">
	</td>
	<td style="width:12px">
	</td>
	</tr>
	</table>
	</div>
	<br />
	<?php 
	$exist_caracs	=	$art_categ-> getCarac ();
	if ($exist_caracs) {
	?>		
	</p>
	<p class="bolder">Liste des  caract&eacute;ristiques<br />
	<?php 
	}
	$fleches_ascenseur=0;
	foreach ($exist_caracs as $exist_carac) {
	?>		
	<div class="caract_table" id="caract_table_<?php echo $exist_carac->ref_carac; ?>">
	<table>
	<tr class="smallheight">
	<td>
	<form action="catalogue_categorie_caract_mod.php" method="post" id="catalogue_categorie_mod_caract_<?php echo $exist_carac->ref_carac; ?>" name="catalogue_categorie_mod_caract_<?php echo $exist_carac->ref_carac; ?>" target="formFrame" >
		<table>
			<tr class="smallheight">
				<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td><span class="labelled_nowidth">Libell&eacute;:</span>
						<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
						<input name="ref_carac" id="ref_carac" type="hidden" value="<?php echo $exist_carac->ref_carac; ?>" />				</td>
				<td><span class="labelled_nowidth">Unit&eacute;: </span></td>
				<td><span class="labelled_nowidth">Crit&egrave;re de recherche: </span></td>
				<td><span class="labelled_nowidth">Affichage:</span></td>
			</tr>
			<tr>
				<td><input name="lib_carac_<?php echo $exist_carac->ref_carac; ?>" id="lib_carac_<?php echo $exist_carac->ref_carac; ?>" value="<?php echo htmlentities($exist_carac->lib_carac); ?>"  class="classinput_xsize"/></td>
				<td><span class="labelled_nowidth">
					<input name="unite_<?php echo $exist_carac->ref_carac; ?>" id="unite_<?php echo $exist_carac->ref_carac; ?>" type="text" value="<?php echo htmlentities($exist_carac->unite); ?>" class="classinput_xsize" />
				</span></td>
				<td><select name="moteur_recherche_<?php echo $exist_carac->ref_carac; ?>" id="moteur_recherche_<?php echo $exist_carac->ref_carac; ?>"  class="classinput_xsize">
						<option value="0" <?php if ($exist_carac->moteur_recherche==0) {echo 'selected="selected"';}?>>Non</option>
						<option value="1" <?php if ($exist_carac->moteur_recherche==1) {echo 'selected="selected"';}?>>Simple</option>
						<option value="2" <?php if ($exist_carac->moteur_recherche==2) {echo 'selected="selected"';}?>>Avanc&eacute;</option>
				</select></td>
				<td><select name="affichage_<?php echo $exist_carac->ref_carac; ?>" id="affichage_<?php echo $exist_carac->ref_carac; ?>"  class="classinput_xsize">
						<option value="1" <?php if ($exist_carac->affichage==1) {echo 'selected="selected"';}?>>Normal</option>
						<option value="2" <?php if ($exist_carac->affichage==2) {echo 'selected="selected"';}?>>Prioritaire</option>
				</select></td>
			</tr>
			<tr>
				<td><span class="labelled_nowidth">Valeur(s) par d&eacute;faut:</span></td>
				<td><span class="labelled_nowidth">Valeurs autoris&eacute;es:</span></td>
				<td><span class="labelled_nowidth">Groupe:</span></td>
				<td><span class="labelled_nowidth">Variante:</span></td>
			</tr>
			<tr>
				<td><input name="default_value_<?php echo $exist_carac->ref_carac; ?>" id="default_value_<?php echo $exist_carac->ref_carac; ?>" type="text" value="<?php echo htmlentities($exist_carac->default_value); ?>" class="classinput_xsize" /></td>
				<td><input name="allowed_values_<?php echo $exist_carac->ref_carac; ?>" type="text" class="classinput_xsize<?php if ($exist_carac->variante==1) {?>_disabled" disabled="disabled<?php }?>" id="allowed_values_<?php echo $exist_carac->ref_carac; ?>" value="<?php if ($exist_carac->variante !=1) {echo htmlentities($exist_carac->allowed_values);} ?>" /></td>
				<td><select name="ref_carac_groupe_<?php echo $exist_carac->ref_carac; ?>" id="ref_carac_groupe_<?php echo $exist_carac->ref_carac; ?>"  class="classinput_xsize">
						<option value="">Aucun</option>
						<?php 
	$exist_carac_groupes	=	$art_categ-> getCarac_groupes ();
	foreach ($exist_carac_groupes as $exist_carac_groupe) {
	?>
						<option value="<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" <?php if ($exist_carac_groupe->ref_carac_groupe==$exist_carac->ref_carac_groupe) {echo 'selected="selected"';}?>><?php echo htmlentities($exist_carac_groupe->lib_carac_groupe)?></option>
						<?php

	}
	?>
				</select></td>
				<td><input name="modifier_<?php echo $exist_carac->ref_carac; ?>" id="modifier_<?php echo $exist_carac->ref_carac; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="float:right;"/>
						<input type="checkbox" name="variante_<?php echo $exist_carac->ref_carac; ?>" id="variante_<?php echo $exist_carac->ref_carac; ?>" value="1" <?php if ($exist_carac->variante==1) {echo 'checked="checked"';}?> />		
						<input type="hidden" name="old_variante_<?php echo $exist_carac->ref_carac; ?>" id="old_variante_<?php echo $exist_carac->ref_carac; ?>" value="<?php echo $exist_carac->variante;?>" />				</td>
			</tr>
		</table>
<script type="text/javascript">

Event.observe("modifier_<?php echo $exist_carac->ref_carac; ?>", "click",  function(evt){
	Event.stop(evt); 
	if (!$("variante_<?php echo $exist_carac->ref_carac; ?>").checked && $("old_variante_<?php echo $exist_carac->ref_carac; ?>").value == "1") {
		alerte.confirm_mod_carc_var('variante_alerte', 'catalogue_categorie_mod_caract_<?php echo $exist_carac->ref_carac; ?>', "variante_<?php echo $exist_carac->ref_carac; ?>");
	} else {
		$("catalogue_categorie_mod_caract_<?php echo $exist_carac->ref_carac; ?>").submit();
	}
}, false);

Event.observe($("variante_<?php echo $exist_carac->ref_carac; ?>"), "click", function(evt){
	if ($("variante_<?php echo $exist_carac->ref_carac; ?>").checked) {
		$("allowed_values_<?php echo $exist_carac->ref_carac; ?>").value = "";
		$("allowed_values_<?php echo $exist_carac->ref_carac; ?>").disabled = "disabled";
		$("allowed_values_<?php echo $exist_carac->ref_carac; ?>").className="classinput_xsize_disabled";
	} else {
		$("allowed_values_<?php echo $exist_carac->ref_carac; ?>").disabled = "";
		$("allowed_values_<?php echo $exist_carac->ref_carac; ?>").className="classinput_xsize";
	}
});
</script>
	</form>	</td>
	<td style="width:0px">	</td>
	<td style="width:12px">
	
		<form method="post" action="catalogue_categorie_caract_sup.php" id="catalogue_categorie_sup_caract_<?php echo $exist_carac->ref_carac; ?>" name="catalogue_categorie_sup_caract_<?php echo $exist_carac->ref_carac; ?>" target="formFrame">
			<input name="ref_carac" id="ref_carac" type="hidden" value="<?php echo $exist_carac->ref_carac; ?>" />
			<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
		</form>
		<a href="#" id="link_catalogue_categorie_sup_caract_<?php echo $exist_carac->ref_carac; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe("link_catalogue_categorie_sup_caract_<?php echo $exist_carac->ref_carac; ?>", "click",  function(evt){
			Event.stop(evt);
		
			if ($("old_variante_<?php echo $exist_carac->ref_carac; ?>").value == "1") {
				alerte.confirm_supprimer('variante_alerte_sup_caract', 'catalogue_categorie_sup_caract_<?php echo $exist_carac->ref_carac; ?>');
			} else {
				alerte.confirm_supprimer('catalogue_categorie_sup_caract', 'catalogue_categorie_sup_caract_<?php echo $exist_carac->ref_carac; ?>');
			}
			
	}, false);
		</script>
		<br />

	
	<table cellspacing="0">
					<tr>
						<td>
							<div id="up_arrow_<?php echo $exist_carac->ref_carac; ?>">
							<?php
							if ($fleches_ascenseur!=0) {
							?>
							<form action="catalogue_categorie_caract_ordre.php" method="post" id="catalogue_categs_grpcaract_ordre_up_<?php echo $exist_carac->ordre; ?>" name="catalogue_categs_grpcaract_ordre_up_<?php echo $exist_carac->ordre; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($exist_caracs[$fleches_ascenseur-1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($exist_carac->ordre)?>" />
								<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
								
								<input name="modifier_ordre_<?php echo $exist_carac->ordre; ?>" id="modifier_ordre_<?php echo $exist_carac->ordre; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
							</form>
							<?php
							} else {
							?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
							<?php
							}
							?>
							</div>						</td>
					</tr>
					<tr>
						<td>
						<div id="down_arrow_<?php echo $exist_carac->ref_carac; ?>">
							<?php
							if ($fleches_ascenseur!=count($exist_caracs)-1) {
							?>
							<form action="catalogue_categorie_caract_ordre.php" method="post" id="catalogue_categs_grpcaract_ordre_down_<?php echo $exist_carac->ordre; ?>" name="catalogue_categs_grpcaract_ordre_down_<?php echo $exist_carac->ordre; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($exist_caracs[$fleches_ascenseur+1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($exist_carac->ordre)?>" />
								<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
								
								<input name="modifier_ordre_<?php echo $exist_carac->ordre; ?>" id="modifier_ordre_<?php echo $exist_carac->ordre; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
							</form>
							<?php
							} else {
							?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>							
							<?php
							}
							?>
							</div>						</td>
					</tr>
				</table>	</td>
	</tr>
	</table>
	</div>
	<br />
	<?php
	
	$fleches_ascenseur++;
	}
	?>
  </p>
</div>