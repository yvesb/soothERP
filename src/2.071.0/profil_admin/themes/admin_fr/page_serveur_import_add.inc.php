<?php

// *************************************************************************************************************
// AJOUT D'UN SERVEUR D'IMPORT
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
<p>Ajout d'un serveur d'import</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var serveur_existants = false;
var serveur_non_trouvé = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="serveur_existants") {
		echo "serveur_existants=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="serveur_non_trouvé") {
		echo "serveur_non_trouvé=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	
	if (serveur_existants) {
		texte_erreur += "Cette référence ou l'URL serveur fait déjà partie de liste des serveurs d'import.<br/>";
	} 

	if (serveur_non_trouvé) {
		texte_erreur += "Le serveur n'a pas été trouvé.<br/>";
	} 
	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
window.parent.changed = false;
window.open("<?php echo $_REQUEST["url_serveur_import"].$ECHANGE_LMB_DIR;?>export_serveur_add.php?impex=<?php echo implode(";",$liste_impex );?>&ref_serveur_import=<?php echo $_SERVER['REF_SERVEUR'];?>&code_serveur_import=<?php echo $CODE_SECU;?>&url_serveur_import="+document.URL.replace("/profil_admin/serveur_import_add.php", ""), "_self");

}
</script>
