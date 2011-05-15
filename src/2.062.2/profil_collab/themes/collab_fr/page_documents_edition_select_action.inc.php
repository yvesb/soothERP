
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
<p>action sur la selection </p>
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
ref_doc = "<?php 
if (isset($GLOBALS['_INFOS']['ref_doc_copie'])) {
	echo $GLOBALS['_INFOS']['ref_doc_copie'];
} else {
	echo $_REQUEST['ref_doc'];
}
?>";

//open_doc (ref_doc);

	page.verify("document_edition","documents_edition.php?ref_doc="+ref_doc, "true", "sub_content");
}
</script>