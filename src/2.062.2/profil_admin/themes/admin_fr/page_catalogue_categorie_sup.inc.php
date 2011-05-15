
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
<p>art_categ Modif </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var articles_existants=false;
var bad_new_ref_art_categ_parent=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="articles_existants") {
		echo "articles_existants=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_new_ref_art_categ_parent") {
		echo "bad_new_ref_art_categ_parent=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

if (articles_existants) {
window.parent.alerte.confirm_supprimer('catalogue_supprim_categs_impossible', '');
		}

}
else
{
window.parent.changed = false;
window.parent.page.verify('catalogue_categorie','catalogue_categorie.php','true','sub_content');

}
</script>