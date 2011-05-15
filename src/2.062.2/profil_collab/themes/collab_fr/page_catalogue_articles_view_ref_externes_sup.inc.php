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
<p>suppression de ref_article_externe </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var bad_pa_unitaire= false;
var bad_ref_fournisseur= false;
var exist_ref_article_externe= false;
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
window.parent.close_article_ref_externe();
window.parent.page.verify('catalogue_articles_view_ref_externes','catalogue_articles_view_ref_externes.php?ref_article=<?php echo $article->getRef_article();?>','true','ref_externes_info_under');

}
</script>