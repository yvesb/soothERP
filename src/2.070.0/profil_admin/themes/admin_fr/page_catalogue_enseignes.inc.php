<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liste_enseignes");
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
tableau_smenu[1] = Array('catalogue_enseignes','catalogue_enseignes.php',"true" ,"sub_content", "Enseignes");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Enseigne.  </p>
<div style="height:50px;">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="enseignes" style=" padding-left:10px; padding-right:10px">

	
	<p>Ajouter une enseigne </p>
			<table>
		<tr>
			<td>
		<table>
			<tr class="smallheight">
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td></td>
			</tr>	
			<tr>
			<td ><span class="labelled">Libell&eacute;:</span>
			</td>
			<td>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
	<div class="caract_table">
	<table>
		<tr class="smallheight">
			<td>
				<form action="catalogue_enseignes_add.php" method="post" id="catalogue_enseignes_add" name="catalogue_enseignes_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_enseigne" id="lib_enseigne" type="text" value=""  class="classinput_lsize"/>
						<input name="ajout_enseigne" id="ajout_enseigne" type="hidden" value="1"/>
						</td>
						
						<td>
							<p style="text-align:right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>

					</tr>
				</table>
				</form>
			</td>
			<td style="width:2%">
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	if ($liste_enseignes) {
	?>
	<p>Liste des enseignes </p>

		<table>
		<tr>
			<td>
		<table>
			<tr class="smallheight">
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td></td>
			</tr>	
			<tr>
			<td ><span class="labelled">Libell&eacute;:</span>
			</td>
			<td>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
	<?php 
	}
	$i = 0;
	foreach ($liste_enseignes as $liste_enseigne) {
	?>
	<div class="caract_table" id="enseigne_table_<?php echo $liste_enseigne->id_mag_enseigne; ?>">

		<table>
		<tr>
			<td>
				<form action="catalogue_enseignes_mod.php" method="post" id="catalogue_enseignes_mod_<?php echo $liste_enseigne->id_mag_enseigne; ?>" name="catalogue_enseignes_mod_<?php echo $liste_enseigne->id_mag_enseigne; ?>" target="formFrame" >
				<table>
					
					<tr class="smallheight">
						<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input id="lib_enseigne_<?php echo $liste_enseigne->id_mag_enseigne; ?>" name="lib_enseigne_<?php echo $liste_enseigne->id_mag_enseigne; ?>" type="text" value="<?php echo htmlentities($liste_enseigne->lib_enseigne); ?>"  class="classinput_lsize"/>
			<input name="id_mag_enseigne" id="id_mag_enseigne" type="hidden" value="<?php echo $liste_enseigne->id_mag_enseigne; ?>" />
						
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
			
			<td style="width:2%">
			<?php 
			if ($i) {
				?>
				<form action="catalogue_enseignes_sup.php" method="post" id="catalogue_enseignes_sup_<?php echo $liste_enseigne->id_mag_enseigne; ?>" name="catalogue_enseignes_sup_<?php echo $liste_enseigne->id_mag_enseigne; ?>" target="formFrame" >
				<input name="id_mag_enseigne" id="id_mag_enseigne" type="hidden" value="<?php echo $liste_enseigne->id_mag_enseigne; ?>" />
				</form>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supprimer_<?php echo $liste_enseigne->id_mag_enseigne; ?>" style="cursor:pointer" title="supprimer"/>
				<script type="text/javascript">
				Event.observe("supprimer_<?php echo $liste_enseigne->id_mag_enseigne;?>", "click",  function(evt){
					Event.stop(evt); 
					alerte.confirm_supprimer("catalogue_enseignes_sup", "catalogue_enseignes_sup_<?php echo $liste_enseigne->id_mag_enseigne;?>");
				}, false);
				</script>
				
				<?php 
			}
			?>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php
	$i++;
	}
	?>
</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">
new Form.EventObserver('catalogue_enseignes_add', function(element, value){formChanged();});

<?php
    if(!empty($enseignes_liste)){
	foreach ($enseignes_liste as $liste_enseigne) {
?>
new Form.EventObserver('catalogue_enseignes_mod_<?php echo $liste_enseigne->id_mag_enseigne; ?>', function(element, value){formChanged();});
<?php
	}
    }
?>

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>