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

	$dao_csv_import_catalogue_cols2 = new import_catalogue_csv_colonne();
	$arrayColonne = array();
	if(is_object($dao_csv_import_catalogue_cols2)) {
		if (method_exists($dao_csv_import_catalogue_cols2, "read")){
			$arrayColonne = $dao_csv_import_catalogue_cols2->readAll();
		}
	}
?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('<?php echo $import_catalogue_csv['menu_admin'][1][0];?>','<?php echo $import_catalogue_csv['menu_admin'][1][1];?>','<?php echo $import_catalogue_csv['menu_admin'][1][2];?>','<?php echo $import_catalogue_csv['menu_admin'][1][3];?>', "<?php echo $import_catalogue_csv['menu_admin'][1][4];?>");
update_menu_arbo();
</script>
<div class="emarge">


<p class="titre">Renseigner les correspondances</p>
<div>
Sélectionnez les correspondances entre les informations de LMB et les différentes colonnes de votre fichier csv.
<br />&nbsp;
<form action="modules/import_catalogue_csv/import_catalogue_csv_step1_done.php" enctype="multipart/form-data" method="POST" id="import_catalogue_csv_done" name="import_catalogue_csv_done" target="formFrame" class="classinput_nsize" />
 
			
			
			
			
<div style="font-weight:bolder">Catégories d'articles</div>
<table class="contactview_corps" style=" width:100%">
		<tr>
			<td style="width:50%"><span id="lib_champ_ref_art_categ">Catégorie d'article par défaut</span>
<span style="text-align: left; float:left; font-style:italic">Indiquez la catégorie d'article qui sera utilisée si aucune catégorie n'est définie:</span>
			</td>
			<td>
			<select  name="ref_art_categ_import" id="ref_art_categ_import" class="classinput_lsize">
			<?php
				$select_art_categ =	get_articles_categories();
				foreach ($select_art_categ  as $s_art_categ){
					?>
					<option value="<?php echo ($s_art_categ->ref_art_categ)?>">
					<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
					</option>
					<?php
				}
			?>
			</select>
			
			</td>
		</tr>
		<tr>
			<td style="width:50%"><span id="lib_champ_ref_art_categ">Catégorie d'article</span>
			</td>
			<td>
			<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
			<div id="correspondances_ref_art_categ"  class="choix_correspondances" style="display:none"></div></div>
				<select class="classinput_lsize" id="ref_art_categ" name="ref_art_categ" >
					<?php 
					$preselect = 0;
					foreach ($arrayColonne as $indexArrayColonne)	{
						?>
						<option value="<?php echo $indexArrayColonne->__getId(); ?>" ><?php echo ucwords($indexArrayColonne->__getLibelle());?></option>
						<?php 
					}
					?>
					<option value="" <?php if (!$preselect) {echo 'selected="selected"';}?>>Non d&eacute;termin&eacute;e</option>
				</select>
				
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/ajouter.gif" id="v_correspondances_ref_art_categ" style="cursor:pointer; display:<?php if (!$preselect) {?>none<?php } ?>" />
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/moins.gif" id="unv_correspondances_ref_art_categ" style="display:none; cursor:pointer" />
			<script type="text/javascript">
			<?php if ($preselect) {?>
					page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=ref_art_categ&csv_col='+$("ref_art_categ").options[$("ref_art_categ").selectedIndex].value,'true','correspondances_ref_art_categ');
			<?php } ?>
				Event.observe("ref_art_categ", "change",  function(evt){
					Event.stop(evt);
					if ($("ref_art_categ").options[$("ref_art_categ").selectedIndex].value != "") {
					$("correspondances_ref_art_categ").show();
					$("v_correspondances_ref_art_categ").hide();
					$("unv_correspondances_ref_art_categ").show();
					page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=ref_art_categ&csv_col='+$("ref_art_categ").options[$("ref_art_categ").selectedIndex].value,'true','correspondances_ref_art_categ');
					} else {
					$("v_correspondances_ref_art_categ").hide();
					$("unv_correspondances_ref_art_categ").hide();
					}
				
				}, false);
				Event.observe("v_correspondances_ref_art_categ", "click",  function(evt){
					Event.stop(evt);
					$("correspondances_ref_art_categ").show();
					$("v_correspondances_ref_art_categ").hide();
					$("unv_correspondances_ref_art_categ").show();
					if ($("correspondances_ref_art_categ").innerHTML == "") {
						page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=ref_art_categ&csv_col='+$("ref_art_categ").options[$("ref_art_categ").selectedIndex].value,'true','correspondances_ref_art_categ');
					}
				
				}, false);
				Event.observe("unv_correspondances_ref_art_categ", "click",  function(evt){
					Event.stop(evt);
					$("correspondances_ref_art_categ").hide();
					$("v_correspondances_ref_art_categ").show();
					$("unv_correspondances_ref_art_categ").hide();
				
				}, false);
			</script>
			</td>
		</tr>
</table>
<br />
			
			
			
<?php
foreach ($import_catalogue_csv['liste_entete'] as $entete_corresp) {
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
					page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=<?php echo $champs_val['id'];?>&csv_col='+$("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value,'true','correspondances_<?php echo $champs_val['id'];?>');
			<?php } ?>
				Event.observe("<?php echo $champs_val['id'];?>", "change",  function(evt){
					Event.stop(evt);
					if ($("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value != "") {
					$("correspondances_<?php echo $champs_val['id'];?>").show();
					$("v_correspondances_<?php echo $champs_val['id'];?>").hide();
					$("unv_correspondances_<?php echo $champs_val['id'];?>").show();
					page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=<?php echo $champs_val['id'];?>&csv_col='+$("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value,'true','correspondances_<?php echo $champs_val['id'];?>');
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
						page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=<?php echo $champs_val['id'];?>&csv_col='+$("<?php echo $champs_val['id'];?>").options[$("<?php echo $champs_val['id'];?>").selectedIndex].value,'true','correspondances_<?php echo $champs_val['id'];?>');
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

<div style="font-weight:bolder">Prix de vente</div>
<table class="contactview_corps" style=" width:100%">
<?php 
$tarifs_liste = get_full_tarifs_listes ();
foreach ($tarifs_liste as $tarif) {
	?>
	<tr>
		<td style="width:50%"><span id="lib_champ_id_tarif_<?php echo $tarif->id_tarif;?>"><?php echo $tarif->lib_tarif;?></span>
		</td>
		<td>
			<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
			<div id="correspondances_id_tarif_<?php echo $tarif->id_tarif;?>"  class="choix_correspondances" style="display:none"></div></div>
				<select class="classinput_lsize" id="id_tarif_<?php echo $tarif->id_tarif;?>" name="id_tarif_<?php echo $tarif->id_tarif;?>" >
					<?php 
					$preselect = 0;
					foreach ($arrayColonne as $indexArrayColonne)	{
						?>
						<option value="<?php echo $indexArrayColonne->__getId(); ?>" ><?php echo ucwords($indexArrayColonne->__getLibelle());?></option>
						<?php 
					}
					?>
					<option value="" <?php if (!$preselect) {echo 'selected="selected"';}?>>Non d&eacute;termin&eacute;e</option>
				</select>
				
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/ajouter.gif" id="v_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>" style="cursor:pointer; display:<?php if (!$preselect) {?>none<?php } ?>" />
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/moins.gif" id="unv_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>" style="display:none; cursor:pointer" />
			<script type="text/javascript">
			
			
				Event.observe("id_tarif_<?php echo $tarif->id_tarif;?>", "change",  function(evt){
					Event.stop(evt);
					if ($("id_tarif_<?php echo $tarif->id_tarif;?>").options[$("id_tarif_<?php echo $tarif->id_tarif;?>").selectedIndex].value != "") {
					$("correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").show();
					$("v_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").hide();
					$("unv_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").show();
					page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=id_tarif&id_tarif=<?php echo $tarif->id_tarif;?>&csv_col='+$("id_tarif_<?php echo $tarif->id_tarif;?>").options[$("id_tarif_<?php echo $tarif->id_tarif;?>").selectedIndex].value,'true','correspondances_id_tarif_<?php echo $tarif->id_tarif;?>');
					} else {
					$("v_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").hide();
					$("unv_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").hide();
					}
				
				}, false);
				Event.observe("v_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>", "click",  function(evt){
					Event.stop(evt);
					$("correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").show();
					$("v_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").hide();
					$("unv_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").show();
					if ($("correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").innerHTML == "") {
						page.verify('import_catalogue_csv_correspondances','modules/import_catalogue_csv/import_catalogue_csv_correspondances.php?lmb_col=id_tarif&id_tarif=<?php echo $tarif->id_tarif;?>&csv_col='+$("id_tarif_<?php echo $tarif->id_tarif;?>").options[$("id_tarif_<?php echo $tarif->id_tarif;?>").selectedIndex].value,'true','correspondances_id_tarif_<?php echo $tarif->id_tarif;?>');
					}
				
				}, false);
				Event.observe("unv_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>", "click",  function(evt){
					Event.stop(evt);
					$("correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").hide();
					$("v_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").show();
					$("unv_correspondances_id_tarif_<?php echo $tarif->id_tarif;?>").hide();
				
				}, false);
			</script>
		</td>
	</tr>
	<?php
}
?>
</table><br />

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