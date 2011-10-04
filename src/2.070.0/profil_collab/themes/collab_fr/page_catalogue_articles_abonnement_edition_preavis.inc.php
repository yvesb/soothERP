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
	window.parent.page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $_REQUEST["preavis_id_abo"];?>&ref_article=<?php echo $_REQUEST["preavis_ref_article"];?>','true','edition_abonnement');
	window.parent.document.getElementById("edition_abonnement").style.display = "";

</script>