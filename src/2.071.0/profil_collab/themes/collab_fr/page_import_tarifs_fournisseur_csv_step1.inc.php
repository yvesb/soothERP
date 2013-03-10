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

$colonne = new import_tarifs_fournisseur_csv_colonne();
$arrayColonne = array();
if(is_object($colonne)) {
	if (method_exists($colonne, "readAll")){
		$arrayColonne = $colonne->readAll();
	}
}
?>

<p class="titre">Renseigner les correspondances</p>
<div>
Sélectionnez les correspondances entre les informations de LMB et les différentes colonnes de votre fichier CSV.
<p>
<form action="import_tarifs_fournisseur_csv_step1_done.php" enctype="multipart/form-data" 
		method="POST" id="import_tarifs_fournisseur_csv_done" name="import_tarifs_fournisseur_csv_done" 
		target="formFrame" class="classinput_nsize" />
		
<?php
foreach ($import_tarifs_fournisseur_csv['liste_entete'] as $entete_corresp) {
?>
<div style="font-weight:bolder"><?php echo $entete_corresp['main_lib'];?></div>
<table class="contactview_corps" style=" width:100%">
	<?php
	foreach ($entete_corresp['champs'] as $champs_val) {
		?>
		<tr>
			<td style="width:50%">
				<span id="lib_champ_<?php echo $champs_val['id'];?>"><?php echo $champs_val['lib'];?></span>
			</td>
			<td>
				<select class="classinput_lsize" id="<?php echo $champs_val['id'];?>" 
						name="<?php echo $champs_val['id'];?><?php if (isset($champs_val['multiple'])) {?>[]<?php } ?>" 
						<?php if (isset($champs_val['multiple'])) {?>  size="<?php echo $champs_val['multiple'];?>" multiple="multiple"<?php } ?>>
					<?php 
					$preselect = 0;
					foreach ($arrayColonne as $colonne) { ?>
						<option value="<?php echo $colonne->getId_colonne(); ?>" 
							<?php if (in_array(strtolower(trim($colonne->getLibelle())), $champs_val['corresp'])){ 
								echo ' selected="selected" ';
								$preselect = 1;
							}
						?>><?php echo ucwords($colonne->getLibelle());?></option>
						<?php 
					}
					?>
					<option value="0" <?php if (!$preselect) {echo 'selected="selected"';}?>>Non d&eacute;termin&eacute;e</option>
				</select>
			</td>
		</tr>
		<?php
	}
	?>
</table>
<?php
}
if($fournisseurs_import_tarifs->getId_ref_oem() != ""){
	?>
	<p>
	<input type="button" value="Utiliser les correspondances du précédent import pour ce fournisseur" id="use_old_corres" />
	<script type="text/javascript">
		Event.observe("use_old_corres", "click", function(evt){
			<?php 
			foreach ($entete_corresp['champs'] as $champs_val) {
				switch($champs_val['id']){
					case "ref_oem":
					?>
						$("<?php echo $champs_val['id']; ?>").value = "<?php echo $fournisseurs_import_tarifs->getId_ref_oem(); ?>";
					<?php 
						break;
					case "ref_interne":
					?>
						$("<?php echo $champs_val['id']; ?>").value = "<?php echo $fournisseurs_import_tarifs->getId_ref_interne(); ?>";
					<?php 
						break;
					case "ref_article_externe":
					?>
						$("<?php echo $champs_val['id']; ?>").value = "<?php echo $fournisseurs_import_tarifs->getId_ref_fournisseur(); ?>";
					<?php 
						break;
					case "lib":
					?>
						$("<?php echo $champs_val['id']; ?>").value = "<?php echo $fournisseurs_import_tarifs->getId_lib_fournisseur(); ?>";
					<?php 
						break;
					case "pa_ht":
					?>
						$("<?php echo $champs_val['id']; ?>").value = "<?php echo $fournisseurs_import_tarifs->getId_pua_ht(); ?>";
					<?php 
						break;
				}
			}
			?>
		}, false);
	</script>
	</p>
	<?php
}
?>
<p>
<input type="submit" value="Valider les correspondances">
<input type="reset" value="Annuler" />
</p>
</form>
</p>
</div>

<script type="text/javascript">
	// On masque le chargement
	H_loading();
</script>
</div>