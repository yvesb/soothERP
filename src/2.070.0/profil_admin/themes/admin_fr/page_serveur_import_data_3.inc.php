
<p class="titre">Import de fiches contact de l'annuaire de <?php echo $import_serveur->getLib_serveur_import();?></p>

<div id="list_annuaire">

<?php 
if (count($import_annuaire_data_dispo)) {
	?>
		<table style="width:100%;">
		<tr class="smallheight">
			<td style="width:50%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style=" width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
			<?php
				foreach ($import_annuaire_data_dispo as $import_annuaire) {
					?>
					<tr>
						<td>
						<?php echo nl2br($import_annuaire["DESCRIPTION"]);?>
						</td>
						<td>
						<div style="text-align:center"><span id="lauch_maj_annuaire_<?php echo ($import_annuaire["ID_ANNUAIRE_DATA"]);?>" style="cursor:pointer; font-weight:bolder">LANCER L'IMPORT</span></div>
						</td>
						<td>
						<div id="maj_encours_<?php echo ($import_annuaire["ID_ANNUAIRE_DATA"]);?>">
						</div>
						<script type="text/javascript">
						
						Event.observe('lauch_maj_annuaire_<?php echo ($import_annuaire["ID_ANNUAIRE_DATA"]);?>', 'click',  function(evt){
							Event.stop(evt); 
							$("lauch_maj_annuaire_<?php echo ($import_annuaire["ID_ANNUAIRE_DATA"]);?>").hide();
							var AppelAjax = new Ajax.Updater(
															"maj_encours_<?php echo ($import_annuaire["ID_ANNUAIRE_DATA"]);?>",
															"serveur_import_data_3_maj.php", 
															{
															parameters: {ref_serveur : "<?php echo $import_serveur->getRef_serveur_import();?>", id_annuaire_data: "<?php echo ($import_annuaire["ID_ANNUAIRE_DATA"]);?>" },
															evalScripts:true,
															onLoading:S_loading
															}
															);
						}, false);
						</script>
						</td>
					</tr>
					<tr>
						<td colspan="3">
						<hr />
						</td>
					</tr>
					<?php
				}
			?>
			</table>
	
	
	<?php 
} else {
	?>
	Aucune donnée à importer
	<?php
}
?>
	<script type="text/javascript">
	//on masque le chargement
	H_loading();
	</script>
</div>