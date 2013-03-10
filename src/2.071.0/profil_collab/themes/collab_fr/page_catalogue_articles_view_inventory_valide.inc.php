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
//echo $_REQUEST['desc_courte'];
?>
<p>&nbsp;</p>
<p>article inventaire depuis visualisation </p>
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
	window.parent.changed	=	false;
}
else
{
	window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $_REQUEST['ref_article']?>','true','sub_content');
	window.parent.changed = false;
}
</script>