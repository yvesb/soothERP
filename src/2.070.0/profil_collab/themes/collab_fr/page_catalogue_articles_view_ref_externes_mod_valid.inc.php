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
<p>modification de ref_article_externe </p>
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
	if ($alerte=="bad_pa_unitaire") {
		echo "bad_pa_unitaire=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_ref_fournisseur") {
		echo "bad_ref_fournisseur=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="exist_ref_article_externe") {
		echo "exist_ref_article_externe=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	if (bad_pa_unitaire) {
		texte_erreur += "Le prix d'achat n'est pas valide n'est pas valide.<br />";
	}
	if (bad_ref_fournisseur) {
		texte_erreur += "Un fournisseur doit être sélectionné.<br />";
	}
	if (exist_ref_article_externe) {
		texte_erreur += "La référence externe de l'article existe déjà pour ce fournisseur.<br />";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;
window.parent.close_article_ref_externe();
window.parent.page.verify('catalogue_articles_view_ref_externes','catalogue_articles_view_ref_externes.php?ref_article=<?php echo $article->getRef_article();?>','true','ref_externes_info_under');
window.parent.page.verify('catalogue_articles_edition_gt', 'catalogue_articles_edition_tarifs.php?ref_article=<?php echo $article->getRef_article();?>', 'true', 'tarifs_info_under');

}
</script>