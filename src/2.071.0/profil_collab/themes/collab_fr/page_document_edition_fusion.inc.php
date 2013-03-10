
<?php

// *************************************************************************************************************
// FUSION DE DOCUMENT
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
//echo $_REQUEST['desc_courte'];
?>
<p>&nbsp;</p>
<p>fusion de document </p>
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

page.verify('document_edition','documents_edition.php?ref_doc=<?php echo $_REQUEST['ref_doc']?>','true','sub_content');
		

changed = false;
}
</script>