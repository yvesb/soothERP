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
tableau_smenu[1] = Array('annuaire_gestion_profils','annuaire_gestion_profils.php',"true" ,"sub_content", "Gestion des familles de contacts");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des Profils.</p>
<div style="height:50px">

<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="liste_profils" style="padding-left:10px; padding-right:10px">
	<br />
	<table>
		<tr class="smallheight">
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td style="width:25%">Libell&eacute;:</td>
			<td style="width:25%">Actif</td>
			<td style="width:25%;">Niveau de s&eacute;curit&eacute;</td>
			<td style="width:25%;">
				<p><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="70px" height="1" /></p>
			</td>
		</tr>	
	</table>
	<?php 
	$fleches_ascenseur=0;
	foreach ($profils_liste as $profil_liste) {
	?>
	<div class="caract_table" id="tarif_table_<?php echo $profil_liste->id_profil; ?>">
		<form action="annuaire_gestion_profils_mod.php" method="post" id="annuaire_gestion_profils_mod_<?php echo $profil_liste->id_profil; ?>" name="annuaire_gestion_profils_mod_<?php echo $profil_liste->id_profil; ?>" target="formFrame" >
			<table>
				<tr class="smallheight">
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td><?php echo htmlentities($profil_liste->lib_profil); ?>:
							<input name="id_profil" id="id_profil" type="hidden" value="<?php echo $profil_liste->id_profil; ?>" />
					</td>
					<td>
						<select id="actif_<?php echo $profil_liste->id_profil; ?>" name="actif_<?php echo $profil_liste->id_profil; ?>" class="classinput_lsize">
							<option value="0" disabled="disabled">Inactif</option>
							<option value="1" <?php if ($profil_liste->actif==1) {echo 'selected="selected"';}?>>Actif</option>
							<option value="2" <?php if ($profil_liste->actif==2) {echo 'selected="selected"';}?>>Actif mais secondaire</option>
							<option value="3" <?php if ($profil_liste->actif==3) {echo 'selected="selected"';}?>>Actif mais cach&eacute;</option>
						</select>
					</td>
					<td>
						<select id="niveau_secu_<?php echo $profil_liste->id_profil; ?>" name="niveau_secu_<?php echo $profil_liste->id_profil; ?>" class="classinput_lsize">
							<option value="1" <?php if ($profil_liste->niveau_secu==1) {echo 'selected="selected"';}?>>Bas</option>
							<option value="2" <?php if ($profil_liste->niveau_secu==2) {echo 'selected="selected"';}?>>Moyen</option>
							<option value="3" <?php if ($profil_liste->niveau_secu==3) {echo 'selected="selected"';}?>>Avanc&eacute;</option>
							<option value="4" <?php if ($profil_liste->niveau_secu==4) {echo 'selected="selected"';}?>>Haut</option>
							<option value="5" <?php if ($profil_liste->niveau_secu==5) {echo 'selected="selected"';}?>>Extrême</option>
						</select>
					</td>
					<td>
					<p style="text-align:center">
						<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
					</p>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<br />
	<?php
	$fleches_ascenseur++;
	}
	?>
</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">


<?php 
foreach ($profils_liste as $profil_liste) {
	?>
		new Form.EventObserver('annuaire_gestion_profils_mod_<?php echo $profil_liste->id_profil; ?>', function(element, value){formChanged();});
	<?php
}
?>
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>