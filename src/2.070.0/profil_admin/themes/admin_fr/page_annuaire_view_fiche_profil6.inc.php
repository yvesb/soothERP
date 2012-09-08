
<div class="profil_reduce">
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil6_suppression" name="annu_edition_profil6_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations constructeur </p>
<div class="reduce_in_edit_mode">
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil6" name="annu_edition_profil6" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">R&eacute;f&eacute;rence revendeur:</span>
			</td>
			<td>
				<input name="identifiant_revendeur" id="identifiant_revendeur" type="text" class="classinput_xsize" value="<?php echo 		htmlentities($profils[$id_profil]->getIdentifiant_revendeur ()) ?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions de garantie:</span>
			</td>
			<td>
				<textarea name="conditions_garantie" id="conditions_garantie" class="classinput_xsize"><?php echo htmlentities($profils[$id_profil]->getConditions_garantie ()) ?></textarea>
			</td>
		</tr>
	</table>
	<p style="text-align:center">
<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
</p>
	</form>
	
	<table class="minimizetable"  id="start_visible_profil<?php echo $id_profil?>">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">R&eacute;f&eacute;rence revendeur:</span>
			</td>
			<td>
			<a href="#" id="show6_identifiant_revendeur" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getIdentifiant_revendeur ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions de garantie:</span>
			</td>
			<td>
			<a href="#" id="show6_conditions_garantie" class="modif_input1"><?php echo  nl2br(htmlentities($profils[$id_profil]->getConditions_garantie ()))?></a>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>
	
	
<script type="text/javascript" language="javascript">
Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
	Event.stop(evt); 
	$('annu_edition_profil<?php echo $id_profil?>').toggle();
	$('start_visible_profil<?php echo $id_profil?>').toggle();
}, false);

Event.observe("show6_conditions_garantie", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','conditions_garantie');}, false);

Event.observe("show6_identifiant_revendeur", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','identifiant_revendeur');}, false);
new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});

//on masque le chargement
H_loading();

</script>
</div>
</div>
