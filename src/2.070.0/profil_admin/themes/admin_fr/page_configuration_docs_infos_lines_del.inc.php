<?php
// *************************************************************************************************************
// DEL D'UN MODELE DE LIGNE D'INFORMATION DE DOCUMENTS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>modèle de ligne d'info(suppression) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
if (erreur) {
	
}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('configuration_docs_infos_lines','configuration_docs_infos_lines.php','true','sub_content');

}
</script>