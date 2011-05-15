<?php

// *************************************************************************************************************
// SUPPRESSION D'UN SERVEUR D'IMPORT
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
<p>Suppression d'un serveur d'import</p>
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
 if (last_catalogue_client) {
	texte_erreur += "Vous devez conserver un calatalogue client minimum.<br/>";
 }
	window.parent.alerte.alerte_erreur ('Suppression impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
window.parent.changed = false;

	window.open( "<?php echo $url.$ECHANGE_LMB_DIR;?>export_serveur_sup.php?ref_serveur_import=<?php echo $_SERVER['REF_SERVEUR'];?>&code_serveur_import=<?php echo $CODE_SECU;?>", "formFrame");



}
</script>
