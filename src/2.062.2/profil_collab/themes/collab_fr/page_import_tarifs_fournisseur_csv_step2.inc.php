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
<div class="emarge">
<p class="titre">Listes des tarifs fournisseur à importer</p>
<div>
<form action="import_tarifs_fournisseur_csv_step2_done.php" 
	enctype="multipart/form-data" method="POST" 
	id="import_tarifs_fournisseur_csv_done" name="import_tarifs_fournisseur_csv_done" 
	target="formFrame" class="classinput_nsize" /
<table class="contactview_corps" style=" width:100%">
	<tr>
		<td style="width:50%">
			<input type="hidden" name="orderby_s" id="orderby_s" value="nom" />
			<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
			<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
			<p>
				<input type="submit" value="Lancer l'import">
			</p>
		</td>
		<td>
			<p>
				<?php echo count($array_retour); ?> article(s) à importer<br />
				<strong><?php echo count($array_retour)-$count_prix_vide-$count_corres_non_trouvee; ?> article(s) valide(s)</strong><br />
				<?php if ($count_corres_non_trouvee) { ?>
					<strong><?php echo $count_corres_non_trouvee; ?> correspondance(s) non trouvée(s)</strong><br />
				<?php }
				if ($count_prix_vide) { ?>
					<strong><?php echo $count_prix_vide; ?> fiche(s) invalide(s)</strong><br />
				<?php } ?>
			</p>
		</td>
	</tr>
</table>
</form>
</div>
<div id="resultat_imports">
</div>

<SCRIPT type="text/javascript">
	tarifs_fournisseur_import();
	//on masque le chargement
	H_loading();
</SCRIPT>
</div>