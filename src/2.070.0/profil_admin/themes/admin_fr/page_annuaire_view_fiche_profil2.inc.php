

<div class="profil_reduce">
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil2_suppression" name="annu_edition_profil2_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations administrateur</p>
<div class="reduce_in_edit_mode">
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil2" name="annu_edition_profil2" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Type:</span>
			</td>
			<td>
			<select name="type_admin" id="type_admin" class="classinput_xsize">
			<?php
			$admin_type =  htmlentities($BDD_TYPE_ADMIN[0]);
			foreach ($BDD_TYPE_ADMIN as $type_adm) {
				?>
				<option value="<?php echo htmlentities($type_adm)?>" <?php if ($profils[$id_profil]->getType_admin ()== $type_adm) {echo 'selected="selected"'; $admin_type =  htmlentities($type_adm);}?>><?php echo htmlentities($type_adm)?></option>
				<?php 
			}
			?>
			</select>
			</td>
		</tr>
	</table>
<p style="text-align:center">
<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
</p>
</form>
	<table class="minimizetable" id="start_visible_profil<?php echo $id_profil?>">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Type:</span>
			</td>
			<td>
<a href="#" id="show_type_admin" class="modif_select1"><?php echo  htmlentities($admin_type)?></a>
				</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>
	
<script type="text/javascript" language="javascript">
new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});

Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
	Event.stop(evt); 
	$('annu_edition_profil<?php echo $id_profil?>').toggle();
	$('start_visible_profil<?php echo $id_profil?>').toggle();
}, false);

Event.observe("show_type_admin", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','type_admin');}, false);
//on masque le chargement
H_loading();

</script>
</div>
</div>
