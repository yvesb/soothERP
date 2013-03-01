<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


// ******************************************************************
// Variables communes d'affichage
// ******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<p>&nbsp;</p>
<p>article service _ abo  renouvellement </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

for ($i = 0; $i<$nb_id; $i++){?>
	<script type="text/javascript">
		window.parent.page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $tab_id_abo[$i];?>&ref_article=<?php echo $tab_ref_article[$i];?>','true','edition_abonnement');
		window.parent.page.article_recherche_abo();
	</script>
<?php }?>
