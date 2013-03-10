<table style="width:100%">
<tr>
<td>
<div>
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil7_suppression" name="annu_edition_profil7_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations commercial </p>
<div class="reduce_in_edit_mode">
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil7" name="annu_edition_profil7" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie:</span>
			</td>
			<td>
				<select  id="id_commercial_categ"  name="id_commercial_categ" class="classinput_xsize">
				<?php
				foreach ($liste_categories_commercial as $liste_categorie_commercial){
					?>
					<option value="<?php echo $liste_categorie_commercial->id_commercial_categ;?>" <?php if ($profils[$id_profil]->getId_commercial_categ () == $liste_categorie_commercial->id_commercial_categ) {echo 'selected="selected"'; $id_commercial_categ =  htmlentities($liste_categorie_commercial->id_commercial_categ);}?>>
					<?php echo htmlentities($liste_categorie_commercial->lib_commercial_categ)?></option>
					<?php 
				}?>
				</select>
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
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie :</span>
			</td>
			<td>
			<a href="#" id="show7_id_commercial_categ" class="modif_select1">
			<?php
			foreach ($liste_categories_commercial as $liste_categorie_commercial){
				if ($profils[$id_profil]->getId_commercial_categ () == $liste_categorie_commercial->id_commercial_categ) {?>
				<?php echo htmlentities($liste_categorie_commercial->lib_commercial_categ)?>
				<?php 
				}
			}
			?>
			</a>
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

Event.observe("show7_id_commercial_categ", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_commercial_categ');}, false);

new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});

//on masque le chargement
H_loading();

</script>
</div>
</div></td>
<td style="width:35%">&nbsp;</td>
</tr>
</table>
