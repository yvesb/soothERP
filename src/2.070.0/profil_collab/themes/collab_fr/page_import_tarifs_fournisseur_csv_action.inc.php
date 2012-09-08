<?php
// *************************************************************************************************************
// IMPORT FICHIER TARIFS FOURNISSEUR CSV
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
<p>&nbsp;</p>
<p>Import tarifs fournisseur CSV</p>
<p>&nbsp;</p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br />";
}
?>
<script type="text/javascript">
	var erreur=false;
	var texte_erreur = "";
	if (!erreur) {
		<?php 
		switch ($_REQUEST["fonction_generer"]) {
			case "supprimer":
				?>
				window.parent.alerte.alerte_erreur('Suppression effectuée', 
							"<?php echo count($liste_rec); ?> " + 
							"enregistrement<?php if(count($liste_rec) > 1) echo 's'; ?> " + 
							"supprimé<?php if(count($liste_rec) > 1) echo 's'; ?>",
							'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
				window.parent.page.verify('import_tarifs_fournisseur_csv_step2',
								'import_tarifs_fournisseur_csv_step2.php',
								'true','sub_content');
				<?php
			break;
			case "import":
				?>
				window.parent.alerte.alerte_erreur('Import effectué', 
								"<?php echo $GLOBALS['_INFOS']['count_import']."/".count($liste_rec); ?> " + 
								"enregistrement<?php if($GLOBALS['_INFOS']['count_import'] > 2) echo 's'; ?> " + 
								"importé<?php if($GLOBALS['_INFOS']['count_import'] > 2) echo 's'; ?>",
								'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
				window.parent.page.verify('import_annuaire_csv_step2',
								'<?php echo $DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil(); ?>/import_tarifs_fournisseur_csv_step2.php',
								'true','sub_content');
				<?php
			break;
		}
		?>
		window.parent.changed = false;
	}
</script>