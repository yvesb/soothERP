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

	$dao_csv_import_annu_cols2 = new import_annuaire_csv_colonne();
	$arrayColonne = array();
	if(is_object($dao_csv_import_annu_cols2)) {
		if (method_exists($dao_csv_import_annu_cols2, "read")){
			$arrayColonne = $dao_csv_import_annu_cols2->readAll();
		}
	}
?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('<?php echo $import_annuaire_csv['menu_admin'][1][0];?>','<?php echo $import_annuaire_csv['menu_admin'][1][1];?>','<?php echo $import_annuaire_csv['menu_admin'][1][2];?>','<?php echo $import_annuaire_csv['menu_admin'][1][3];?>', "<?php echo $import_annuaire_csv['menu_admin'][1][4];?>");
update_menu_arbo();
</script>
<div class="emarge">


<p class="titre">Renseigner les correspondances</p>
<div>
Sélectionnez les correspondances entre les informations de LMB et les différentes colonnes de votre fichier csv.
<br />&nbsp;
<form action="modules/import_annuaire_csv/import_annuaire_csv_step1_done.php" enctype="multipart/form-data" method="POST" id="import_annuaire_csv_done" name="import_annuaire_csv_done" target="formFrame" class="classinput_nsize" />

<?php
foreach ($import_annuaire_csv['liste_entete'] as $entete_corresp) {
if (isset($entete_corresp['id_profil']) && $entete_corresp['id_profil'] != $import_annuaire->getId_profil()) {continue;}
?>
<div style="font-weight:bolder"><?php echo $entete_corresp['main_lib'];?></div>
<table class="contactview_corps" style=" width:100%">
	<?php
	foreach ($entete_corresp['champs'] as $champs_val) {
		?>
		<tr>
			<td style="width:50%"><span id="lib_champ_<?php echo $champs_val['id'];?>"><?php echo $champs_val['lib'];?></span>
			</td>
			<td>
			<?php if (isset($champs_val['id_type'])) {?>
			<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
			<div id="correspondances_<?php echo $champs_val['id'];?>"  class="choix_correspondances" style="display:none"></div></div>
			<?php } ?>
				<select class="classinput_lsize" id="<?php echo $champs_val['id'];?>" name="<?php echo $champs_val['id'];?><?php if (isset($champs_val['multiple'])) {?>[]<?php } ?>" <?php if (isset($champs_val['multiple'])) {?>  size="<?php echo $champs_val['multiple'];?>" multiple="multiple"<?php } ?>>
					<?php 
					$preselect = 0;
					foreach ($arrayColonne as $indexArrayColonne)	{
						?>
						<option value="<?php echo $indexArrayColonne->__getId(); ?>" <?php
							if (in_array(strtolower(trim($indexArrayColonne->__getLibelle())), $champs_val['correps'])){ 
								echo ' selected="selected" ';	$preselect = 1;
							}
						?>><?php echo ucwords($indexArrayColonne->__getLibelle());?></option>
						<?php 
					}
					?>
					<option value="" <?php if (!$preselect) {echo 'selected="selected"';}?>>Non d&eacute;termin&eacute;e</option>
				</select>
				
			<?php if (isset($champs_val['id_type'])) {?>
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/ajouter.gif" id="v_correspondances_<?php echo $champs_val['id'];?>" style="cursor:pointer; display:<?php if (!$preselect) {?>none<?php } ?>" />
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/moins.gif" id="unv_correspondances_<?php echo $champs_val['id'];?>" style="display:none; cursor:pointer" />
			<script type="text/javascript">
			<?php if ($preselect) {?>
					page.verify('import_annuaire_csv_correspondances','modules/import_annuaire_csv/import_annuaire_csv_correspondances.php?lmb_col=<?php echo $champs_val['id'];?>&csv_col='+$("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value,'true','correspondances_<?php echo $champs_val['id'];?>');
			<?php } ?>
				Event.observe("<?php echo $champs_val['id'];?>", "change",  function(evt){
					Event.stop(evt);
					if ($("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value != "") {
					$("correspondances_<?php echo $champs_val['id'];?>").show();
					$("v_correspondances_<?php echo $champs_val['id'];?>").hide();
					$("unv_correspondances_<?php echo $champs_val['id'];?>").show();
					page.verify('import_annuaire_csv_correspondances','modules/import_annuaire_csv/import_annuaire_csv_correspondances.php?lmb_col=<?php echo $champs_val['id'];?>&csv_col='+$("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value,'true','correspondances_<?php echo $champs_val['id'];?>');
					} else {
					$("v_correspondances_<?php echo $champs_val['id'];?>").hide();
					$("unv_correspondances_<?php echo $champs_val['id'];?>").hide();
					}
				
				}, false);
				Event.observe("v_correspondances_<?php echo $champs_val['id'];?>", "click",  function(evt){
					Event.stop(evt);
					$("correspondances_<?php echo $champs_val['id'];?>").show();
					$("v_correspondances_<?php echo $champs_val['id'];?>").hide();
					$("unv_correspondances_<?php echo $champs_val['id'];?>").show();
					if ($("correspondances_<?php echo $champs_val['id'];?>").innerHTML == "") {
						page.verify('import_annuaire_csv_correspondances','modules/import_annuaire_csv/import_annuaire_csv_correspondances.php?lmb_col=<?php echo $champs_val['id'];?>&csv_col='+$("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value,'true','correspondances_<?php echo $champs_val['id'];?>');
					}
				
				}, false);
				Event.observe("unv_correspondances_<?php echo $champs_val['id'];?>", "click",  function(evt){
					Event.stop(evt);
					$("correspondances_<?php echo $champs_val['id'];?>").hide();
					$("v_correspondances_<?php echo $champs_val['id'];?>").show();
					$("unv_correspondances_<?php echo $champs_val['id'];?>").hide();
				
				}, false);
			</script>
			<?php } ?>
			</td>
		</tr>
		<?php
	}
	?>
</table>
<br />
<?php
}
?>

	<input type="submit" value="Valider les correspondances">
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />

</form>
</div>

<SCRIPT type="text/javascript">
	
//on masque le chargement
H_loading();
</SCRIPT>
</div>