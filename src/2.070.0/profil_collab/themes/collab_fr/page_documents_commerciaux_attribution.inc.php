<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<p>modification de la liste des commerciaux </p>
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

?>
if (erreur) {
	


}
else
{

window.parent.changed = false;
window.parent.page.traitecontent('documents_marges','documents_marges.php?ref_doc=<?php echo $_REQUEST["ref_doc"]?>','true','marge_content');
window.parent.page.traitecontent('documents_entete', 'documents_entete_maj.php?ref_doc=<?php echo $_REQUEST["ref_doc"]?>', true, 'block_head');
}
</script>