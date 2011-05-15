<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
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
?><p>&nbsp;</p>
<p>Import tarifs fournisseur CSV</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
}

?>
if (erreur) {

}else{
	<?php 
	if (count($lignes)) { 
		?>
		window.parent.alerte.alerte_erreur ('Import en cours', 
						"<?php echo $GLOBALS['_INFOS']['count_import']."/".$GLOBALS['_INFOS']['total_import']; ?> enregistrements importés<br />",
						'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		window.parent.page.verify('import_tarifs_fournisseur_csv_step2_done',
						'import_tarifs_fournisseur_csv_step2_done.php?count_import=<?php echo $GLOBALS['_INFOS']['count_import'];?>&total_import=<?php echo $GLOBALS['_INFOS']['total_import'];?>',
						'true','formFrame');
		<?php 
	} else {
		?>
		window.parent.alerte.alerte_erreur ('Import effectué', 
						"<?php echo $GLOBALS['_INFOS']['count_import']."/".$GLOBALS['_INFOS']['total_import']; ?> enregistrements importés<br />",
						'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		window.parent.page.verify('import_tarifs_fournisseur_csv_step3',
						'import_tarifs_fournisseur_csv_step3.php',
						'true','sub_content');
		<?php 
	} 
	?>
	window.parent.changed = false;

}
</script>