<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV
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
<p>Import catalogue CSV</p>
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
	if (isset($GLOBALS['_ALERTES']['import_fichier_trop_de_colonnes'])) {?>
	erreur= true;
	<?php 
	}
?>
if (erreur) {

<?php 
if (!empty($_FILES['fichier_csv']['tmp_name'])) {
	?>
	<?php if (isset($GLOBALS['_ALERTES']['import_fichier_trop_de_colonnes'])) {?>
	texte_erreur += "Nombre de colonnes trop important dans votre fichier.<br />Veuillez vérifier le format d'export de votre fichier";
	window.parent.alerte.alerte_erreur ('Etape 1', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	<?php 
	}
} 
?>
}
else
{
<?php 
if (!empty($_FILES['fichier_csv']['tmp_name'])) {
	?>
	texte_erreur += "Import fichier <?php echo $_FILES['fichier_csv']['name'];?> terminé .<br />";
	<?php if (isset($GLOBALS['_INFOS']['count_erreur'])) {?>
	texte_erreur += "<?php echo $GLOBALS['_INFOS']['count_erreur'];?> lignes en erreur lors de l'import.<br />";
	<?php 
	}
} 
?>
window.parent.alerte.alerte_erreur ('Etape 1', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
window.parent.changed = false;
window.parent.page.verify('default_content','modules/import_catalogue_csv/import_catalogue_csv_step1.php','true','sub_content');

}
</script>
