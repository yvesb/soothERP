<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liaisons_liste");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<div class="emarge">

<p class="titre">Types de liaisons d'articles </p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="liaison" style="padding-left:10px; padding-right:10px;">


	
	<p>Liste des liaisons </p>

			<table>
		<tr>
			<td>
				<table>
					<tr class="smallheight">
						<td style="width:53%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:13%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td><span class="labelled">Libell&eacute;:</span>
						</td>
				
						<td><span class="labelled">Actif:</span>
						</td>
						<td>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:12px">
				
			</td>
		</tr>
	</table>
	<?php 
	
	$fleches_ascenseur=0;
	foreach ($liaisons_liste as $liaison_liste) {
	?>
	<div class="caract_table" id="liaison_table_<?php echo $liaison_liste->id_liaison_type; ?>">

		<table>
		<tr>
			<td>
				<form action="catalogue_liaisons_mod.php" method="post" id="catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>" name="catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:55%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td><?php echo htmlentities($liaison_liste->lib_liaison_type); ?>
			<input name="id_liaison_type" id="id_liaison_type" type="hidden" value="<?php echo $liaison_liste->id_liaison_type; ?>" />
						</td>
						<td>
						<input id="actif_<?php echo $liaison_liste->id_liaison_type; ?>" name="actif_<?php echo $liaison_liste->id_liaison_type; ?>" value="<?php echo htmlentities($liaison_liste->actif); ?>" type="checkbox"  <?php if($liaison_liste->actif==1){echo 'checked="checked"';}?>/>
						</td>
						<td>
							<p style="text-align:right">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td style="width:12px">
				<table cellspacing="0">
					<tr>
						<td>
							<div id="up_arrow_<?php echo $liaison_liste->id_liaison_type; ?>">
							<?php
							if ($fleches_ascenseur!=0) {
							?>
							<form action="catalogue_liaisons_ordre.php" method="post" id="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" name="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($liaisons_liste[$fleches_ascenseur-1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($liaison_liste->ordre)?>" />
								<input name="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" id="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
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
						<div id="down_arrow_<?php echo $liaison_liste->id_liaison_type; ?>">
							<?php
							if ($fleches_ascenseur!=count($liaisons_liste)-1) {
							?>
							<form action="catalogue_liaisons_ordre.php" method="post" id="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" name="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($liaisons_liste[$fleches_ascenseur+1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($liaison_liste->ordre)?>" />								
								<input name="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" id="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
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
	foreach ($liaisons_liste as $liaison_liste) {
?>
new Form.EventObserver('catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>', function(element, value){formChanged();});
<?php
	}
?>
	
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>