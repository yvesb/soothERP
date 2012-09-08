
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
<p>article stop_article </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var appartenance_lot=false;
var still_dispo=false;
var erreur=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="appartenance_lot") {
		echo "appartenance_lot=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="still_dispo") {
		echo "still_dispo=true;\n";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

	//article appartenant à un lot
	if (appartenance_lot) {
		window.parent.alerte.confirm_supprimer('article_appartenance_lot', '');
	}
	//article toujours en stock
	if (still_dispo) {
		window.parent.alerte.confirm_supprimer('article_toujours_dispo', '');
	}

}
else
{
<?php 
if (isset ($_REQUEST['ref_article']) ) {
	?>
	window.parent.changed = false;
	window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $_REQUEST['ref_article']?>','true','sub_content');
	<?php
}
?>
}
</script>