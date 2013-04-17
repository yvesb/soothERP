<?php

// *************************************************************************************************************
// Gestion des categories de fournisseurs
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
<p>gestion categories_forunisseurs  add </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
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

window.parent.page.verify('annuaire_gestion_categ_fournisseur','annuaire_gestion_categories_fournisseur.php','true','sub_content');

}
</script>