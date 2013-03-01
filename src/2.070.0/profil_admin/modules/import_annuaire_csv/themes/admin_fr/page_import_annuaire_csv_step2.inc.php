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
tableau_smenu[1] = Array('<?php echo $import_annuaire_csv['menu_admin'][1][0];?>','<?php echo $import_annuaire_csv['menu_admin'][1][1];?>','<?php echo $import_annuaire_csv['menu_admin'][1][2];?>','<?php echo $import_annuaire_csv['menu_admin'][1][3];?>', "<?php echo $import_annuaire_csv['menu_admin'][1][4];?>");
update_menu_arbo();
</script>
<div class="emarge">


<p class="titre">Listes des contacts à importer</p>
<div>

<form action="modules/import_annuaire_csv/import_annuaire_csv_step2_done.php" enctype="multipart/form-data" method="POST" id="import_annuaire_csv_done" name="import_annuaire_csv_done" target="formFrame" class="classinput_nsize" />
<input type="hidden" name="first_import" value="42"/>
<table class="contactview_corps" style=" width:100%">
	<tr>
		<td style="width:50%">
		<input type="hidden" name="orderby_s" id="orderby_s" value="nom" />
		<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
		<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
		<input type="checkbox" id="import_fiches_valides" name="import_fiches_valides" value="1" <?php if ($import_annuaire->getLimite() == "1" || $import_annuaire->getLimite() == "3" ) {?>checked="checked"<?php } ?>/> Importer les fiches valides.
		<br />
		<span style=" <?php if (!$total_avert) {?>display:none<?php } ?>">
		<input type="checkbox" id="import_fiches_unvalides" name="import_fiches_unvalides" value="2" <?php if ($import_annuaire->getLimite() == "2" || $import_annuaire->getLimite() == "3" ) {?>checked="checked"<?php } ?>/> Importer les fiches en avertissement.<br />
		</span>
		<script type="text/javascript">
			Event.observe("import_fiches_valides", "click", function(evt){
				limite = 0;
				if (!$("import_fiches_valides").checked) {
					$("import_fiches_valides").checked = false;
				} else {
					$("import_fiches_valides").checked = true;
					limite = parseInt($("import_fiches_valides").value);
				}
				if ($("import_fiches_unvalides").checked) {limite += parseInt($("import_fiches_unvalides").value);}
				annuaire_import_maj_limite(limite);
			});
			
			Event.observe("import_fiches_unvalides", "click", function(evt){
				limite = 0;
				if (!$("import_fiches_unvalides").checked) {
					$("import_fiches_unvalides").checked = false;
				} else {
					$("import_fiches_unvalides").checked = true;
					limite = parseInt($("import_fiches_unvalides").value);
				}
				if ($("import_fiches_valides").checked) {limite += parseInt($("import_fiches_valides").value);}
				annuaire_import_maj_limite(limite);
			});
		</script>
		<br />
			<input type="hidden" name="id_profil_s" id="id_profil_s" value="<?php echo $import_annuaire->getLimite();?>"/>
			<input type="submit" value="Lancer l'import">
		</td>
		<td>
		<?php echo count($array_retour); ?> fiche(s) à importer<br />
		<strong><?php echo count($array_retour)-$total_avert-$count_nom_vide; ?> fiche(s) valide(s)</strong><br />
		<?php if ($total_avert) { ?>
			<strong><?php echo $total_avert; ?> Avertissement(s)</strong><br />
			dont <?php echo $count_nom_doublon; ?> nom existant dans vos contacts<br />
			dont <?php echo $count_email_doublon; ?> email existant dans vos contacts<br />
		<?php } ?>
		<?php if ($count_nom_vide) { ?>
			<strong><?php echo $count_nom_vide; ?> fiche(s) invalides</strong><br />
		<?php } ?>
		</td>
	</tr>
</table>
<br />
</form>


</div>
<div id="resultat_imports">
</div>

<SCRIPT type="text/javascript">
	annuaire_import();
//on masque le chargement
H_loading();
</SCRIPT>
</div>