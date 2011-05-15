<?php

// *************************************************************************************************************
// MODIFICATION DE L'IMPEX POUR UN SERVEUR D'IMPORT
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
<p>modification d'impex d'un serveur d'import</p>
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

}
else
{
window.parent.changed = false;
<?php
if ($_REQUEST["autorise"]) {
	?>
	window.open( "<?php echo $import_serveur->getUrl_serveur_import().$ECHANGE_LMB_DIR;?>export_serveur_impex_add.php?ref_serveur_import=<?php echo $_SERVER['REF_SERVEUR'];?>&code_serveur_import=<?php echo $CODE_SECU;?>&id_impex=<?php echo $_REQUEST["id_impex_type"]?>", "formFrame");
	<?php
} else {
	?>
	window.parent.page.verify('liste_serveur_import','<?php echo $DIR."profil_admin/";?>serveur_import_liste.php','true','sub_content');
	<?php
} 
?>


}
</script>
