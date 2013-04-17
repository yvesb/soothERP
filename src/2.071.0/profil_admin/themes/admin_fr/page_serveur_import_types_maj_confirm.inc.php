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
	window.parent.page.verify('liste_serveur_import','<?php echo $DIR."profil_admin/";?>serveur_import_liste.php','true','sub_content');


}
</script>
