<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

?>
<script type="text/javascript">
	window.parent.page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $_REQUEST["conso_id_compte_credit"];?>&ref_article=<?php echo $_REQUEST["conso_ref_article"];?>','true','edition_consommation');
	window.parent.document.getElementById("edition_consommation").style.display = "none";
	window.parent.page.article_recherche_conso();
</script>